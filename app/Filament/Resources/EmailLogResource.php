<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailLogResource\Pages;
use App\Models\EmailLog;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class EmailLogResource extends Resource
{
    protected static ?string $model = EmailLog::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;
    protected static \UnitEnum|string|null $navigationGroup = 'Communications';
    protected static ?string $navigationLabel = 'Email Logs';
    protected static ?int    $navigationSort  = 10;

    // Show a badge with the count of sent emails today
    public static function getNavigationBadge(): ?string
    {
        return (string) EmailLog::today()->sent()->count();
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'success';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->width('60px'),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'welcome'   => 'info',
                        'broadcast' => 'warning',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sent'   => 'success',
                        'failed' => 'danger',
                        default  => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->sortable(),

                TextColumn::make('recipient_email')
                    ->label('Recipient')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                TextColumn::make('recipient_name')
                    ->label('Name')
                    ->searchable()
                    ->default('—'),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->subject),

                TextColumn::make('error_message')
                    ->label('Error')
                    ->limit(60)
                    ->default('—')
                    ->color('danger')
                    ->tooltip(fn ($record) => $record->error_message),

                TextColumn::make('created_at')
                    ->label('Sent At')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'welcome'   => 'Welcome',
                        'broadcast' => 'Broadcast',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        'sent'   => 'Sent',
                        'failed' => 'Failed',
                    ]),

                Filter::make('today')
                    ->label('Today only')
                    ->query(fn (Builder $query) => $query->whereDate('created_at', today()))
                    ->toggle(),
            ])
            ->actions([
                Action::make('resend')
                    ->label('Resend')
                    ->icon('heroicon-m-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Resend this email?')
                    ->modalDescription('This will re-dispatch the email to the recipient using current SMTP settings.')
                    ->action(function (EmailLog $record) {
                        \App\Support\MailHelper::applySmtpSettings();
                        try {
                            if ($record->type === 'welcome') {
                                $user = $record->user ?? \App\Models\User::where('email', $record->recipient_email)->first();
                                if (!$user) {
                                    $user = new \App\Models\User();
                                    $user->id = $record->user_id ?: 1;
                                    $user->name = $record->recipient_name ?: 'Member';
                                    $user->email = $record->recipient_email;
                                }
                                $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                                    'verification.verify',
                                    now()->addMinutes(60),
                                    ['id' => $user->id, 'hash' => sha1($user->email)]
                                );
                                \Illuminate\Support\Facades\Mail::to($record->recipient_email, $record->recipient_name)
                                    ->send(new \App\Mail\WelcomeEmail($user, $verificationUrl));
                            } else {
                                $fromAddress = trim((string) \App\Models\SiteSetting::get('mail_from_address')) ?: config('mail.from.address');
                                $fromName    = trim((string) \App\Models\SiteSetting::get('mail_from_name')) ?: config('mail.from.name', 'Kenyan Baddies Club');
                                \Illuminate\Support\Facades\Mail::raw(
                                    "Resent communication from Kenyan Baddies Club:\n\nSubject: " . $record->subject,
                                    function ($msg) use ($record, $fromAddress, $fromName) {
                                        $msg->to($record->recipient_email, $record->recipient_name)
                                            ->from($fromAddress, $fromName)
                                            ->subject($record->subject);
                                    }
                                );
                            }
                            $record->update(['status' => 'sent', 'error_message' => null]);
                            \Filament\Notifications\Notification::make()
                                ->title('Email resent successfully!')
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            $record->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
                            \Filament\Notifications\Notification::make()
                                ->title('Resend failed: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No emails logged yet')
            ->emptyStateDescription('Email logs will appear here once emails are sent.')
            ->emptyStateIcon('heroicon-o-envelope');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailLogs::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
