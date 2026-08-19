<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VerificationSubmissionResource\Pages;
use App\Models\VerificationSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

use Filament\Forms\Components\Select;

class VerificationSubmissionResource extends Resource
{
    protected static ?string $model = VerificationSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static \UnitEnum|string|null $navigationGroup = 'User Management';

    protected static ?string $navigationLabel = 'Verifications';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                ImageColumn::make('photo_path')
                    ->label('Photo')
                    ->disk('public')
                    ->height(100)
                    ->width(100)
                    ->extraImgAttributes(['style' => 'object-fit:cover;border-radius:8px;cursor:pointer;']),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'  => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default    => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->recordActions([
                Action::make('view_photo')
                    ->label('View Photo')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (VerificationSubmission $record) => 'Verification Photo — ' . $record->user->name)
                    ->modalContent(fn (VerificationSubmission $record) => new HtmlString(
                        '<div style="text-align:center;padding:1rem;">'
                        . '<img src="' . Storage::url($record->photo_path) . '" '
                        . 'style="max-width:100%;max-height:80vh;border-radius:12px;box-shadow:0 4px 24px rgba(0,0,0,0.5);" />'
                        . '<p style="margin-top:1rem;color:#999;font-size:0.85rem;">'
                        . 'Submitted: ' . $record->created_at->format('d M Y, H:i')
                        . '</p></div>'
                    ))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Verification')
                    ->modalDescription('This will verify the user and grant them access to upload photos & videos.')
                    ->visible(fn (VerificationSubmission $record): bool => $record->status !== 'approved')
                    ->action(function (VerificationSubmission $record) {
                        $record->update(['status' => 'approved']);
                        $record->user->update(['is_verified' => true]);
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Verification')
                    ->modalDescription('This will reject the submission. The user will need to re-submit.')
                    ->visible(fn (VerificationSubmission $record): bool => $record->status !== 'rejected')
                    ->action(function (VerificationSubmission $record) {
                        $record->update(['status' => 'rejected']);
                        $record->user->update(['is_verified' => false]);
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                Action::make('verify_new_user')
                    ->label('Verify New User')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->form([
                        Select::make('user_id')
                            ->label('Select User')
                            ->options(fn () => \App\Models\User::where('is_verified', false)->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $user = \App\Models\User::find($data['user_id']);
                        if ($user) {
                            $user->update(['is_verified' => true]);
                            
                            \App\Models\VerificationSubmission::create([
                                'user_id' => $user->id,
                                'status' => 'approved',
                                'photo_path' => '', // placeholder
                            ]);
                        }
                    }),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVerificationSubmissions::route('/'),
        ];
    }
}
