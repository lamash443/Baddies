<?php

namespace App\Filament\Pages;

use App\Mail\AdminBroadcastMail;
use App\Models\EmailLog;
use App\Models\SiteSetting;
use App\Models\User;
use App\Support\MailHelper;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

class SendEmailPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.send-email-page';

    protected static ?string $navigationLabel = 'Send Email';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?int $navigationSort = 10;

    protected static ?string $title = 'Broadcast Email';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'recipient_type' => 'all',
            'subject'        => '',
            'body'           => '',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Recipients')
                    ->description('Choose who should receive this email.')
                    ->schema([
                        Select::make('recipient_type')
                            ->label('Send To')
                            ->options([
                                'all'          => 'All Users',
                                'specific'     => 'Specific Users (select below)',
                                'plan'         => 'Filter by Subscription Plan',
                                'gender'       => 'Filter by Gender',
                                'verified'     => 'Verified Users Only',
                                'unverified'   => 'Unverified Users Only',
                                'blocked'      => 'Blocked Users Only',
                            ])
                            ->default('all')
                            ->live()
                            ->required(),

                        Select::make('specific_users')
                            ->label('Select Users')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(fn () => User::whereNotNull('email')
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->mapWithKeys(fn ($name, $id) => [$id => $name])
                                ->toArray()
                            )
                            ->visible(fn ($get) => $get('recipient_type') === 'specific')
                            ->required(fn ($get) => $get('recipient_type') === 'specific')
                            ->helperText('Search and select one or more users to email.'),

                        Select::make('filter_plan')
                            ->label('Subscription Plan')
                            ->options([
                                'regular'   => 'Regular',
                                'prime'     => 'Prime',
                                'prime_vip' => 'Prime VIP',
                                'vip'       => 'VIP',
                            ])
                            ->visible(fn ($get) => $get('recipient_type') === 'plan')
                            ->required(fn ($get) => $get('recipient_type') === 'plan'),

                        Select::make('filter_gender')
                            ->label('Gender')
                            ->options([
                                'female' => 'Female',
                                'male'   => 'Male',
                                'other'  => 'Other',
                            ])
                            ->visible(fn ($get) => $get('recipient_type') === 'gender')
                            ->required(fn ($get) => $get('recipient_type') === 'gender'),
                    ]),

                Section::make('Email Content')
                    ->description('Compose the email message.')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Important update from Baddies Club'),

                        Textarea::make('body')
                            ->label('Message Body')
                            ->required()
                            ->rows(12)
                            ->placeholder("Write your message here...\n\nYou can use multiple lines. The email will be formatted automatically.")
                            ->helperText('Plain text only. Line breaks are preserved in the email.'),
                    ]),
            ]);
    }

    public function send(): void
    {
        $data = $this->form->getState();

        $recipientType = $data['recipient_type'];
        $subject       = $data['subject'];
        $body          = $data['body'];

        $query = User::whereNotNull('email')->where('email', '!=', '');

        switch ($recipientType) {
            case 'all':
                // no extra filter
                break;
            case 'specific':
                $ids = $data['specific_users'] ?? [];
                if (empty($ids)) {
                    Notification::make()
                        ->title('No users selected.')
                        ->danger()
                        ->send();
                    return;
                }
                $query->whereIn('id', $ids);
                break;
            case 'plan':
                $query->where('subscription_plan', $data['filter_plan'] ?? '');
                break;
            case 'gender':
                $query->where('gender', $data['filter_gender'] ?? '');
                break;
            case 'verified':
                $query->where('is_verified', true);
                break;
            case 'unverified':
                $query->where('is_verified', false);
                break;
            case 'blocked':
                $query->where('is_blocked', true);
                break;
        }

        $users = $query->get();

        if ($users->isEmpty()) {
            Notification::make()
                ->title('No users matched the selected criteria.')
                ->warning()
                ->send();
            return;
        }

        // Apply SMTP settings once before the loop
        MailHelper::applySmtpSettings();
        $fromName = SiteSetting::get('mail_from_name', config('mail.from.name', 'Baddies Club'));

        $sent   = 0;
        $failed = 0;

        foreach ($users as $user) {
            try {
                Mail::to($user->email, $user->name)
                    ->send(new AdminBroadcastMail(
                        emailSubject:  $subject,
                        emailBody:     $body,
                        recipientName: $user->name ?? '',
                        senderName:    $fromName,
                    ));

                EmailLog::create([
                    'user_id'         => $user->id,
                    'recipient_email' => $user->email,
                    'recipient_name'  => $user->name,
                    'subject'         => $subject,
                    'type'            => 'broadcast',
                    'status'          => 'sent',
                ]);

                $sent++;

            } catch (\Exception $e) {
                EmailLog::create([
                    'user_id'         => $user->id,
                    'recipient_email' => $user->email,
                    'recipient_name'  => $user->name,
                    'subject'         => $subject,
                    'type'            => 'broadcast',
                    'status'          => 'failed',
                    'error_message'   => $e->getMessage(),
                ]);

                $failed++;
            }
        }

        $message = "Sent: {$sent}";
        if ($failed > 0) {
            $message .= ", Failed: {$failed}";
        }

        Notification::make()
            ->title("Broadcast complete — {$message}")
            ->body($failed > 0 ? 'Some emails failed. Check Email Logs for details.' : 'All emails delivered successfully.')
            ->color($failed > 0 ? 'warning' : 'success')
            ->duration(8000)
            ->send();

        // Reset form
        $this->form->fill([
            'recipient_type' => 'all',
            'subject'        => '',
            'body'           => '',
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('send')
                ->label('Send Email')
                ->icon(Heroicon::OutlinedPaperAirplane)
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Send Broadcast Email?')
                ->modalDescription('This will queue emails to all selected recipients. This action cannot be undone.')
                ->modalSubmitActionLabel('Yes, Send Now')
                ->action('send'),
        ];
    }
}
