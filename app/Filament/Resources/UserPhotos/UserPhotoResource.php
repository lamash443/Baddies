<?php

namespace App\Filament\Resources\UserPhotos;

use App\Filament\Resources\UserPhotos\Pages\ListUserPhotos;
use App\Models\User;
use App\Models\UserPhoto;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class UserPhotoResource extends Resource
{
    protected static ?string $model = UserPhoto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'User Photos';

    protected static \UnitEnum|string|null $navigationGroup = 'Media';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('path')
                    ->label('Photo')
                    ->disk('public')
                    ->height(70)
                    ->width(70)
                    ->extraImgAttributes(['style' => 'object-fit:cover;border-radius:8px;']),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('user.subscription_plan')
                    ->label('Plan')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'regular'   => 'Regular',
                        'prime'     => 'Prime',
                        'vip'       => 'VIP',
                        'prime_vip' => 'Prime VIP',
                        default     => ucfirst((string) $state),
                    })
                    ->color(fn ($state) => match ($state) {
                        'regular'   => 'gray',
                        'prime'     => 'info',
                        'vip'       => 'warning',
                        'prime_vip' => 'danger',
                        default     => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_main')
                    ->label('Main')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                TextColumn::make('caption')
                    ->label('Caption')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('subscription_plan')
                    ->label('Subscription Plan')
                    ->options([
                        'regular'   => 'Regular',
                        'prime'     => 'Prime',
                        'vip'       => 'VIP',
                        'prime_vip' => 'Prime VIP',
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('user', function ($q) use ($data) {
                                $q->where('subscription_plan', $data['value']);
                            });
                        }
                    }),
            ])
            ->headerActions([
                Action::make('upload_photos')
                    ->label('Upload Photos for User')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('primary')
                    ->modalHeading('Upload Photos for a User')
                    ->modalDescription('Select a user and upload one or more photos to assign to their profile.')
                    ->modalWidth('2xl')
                    ->form([
                        Select::make('user_id')
                            ->label('Select User')
                            ->options(
                                User::whereNotNull('subscription_plan')
                                    ->orderByRaw("FIELD(subscription_plan,'prime_vip','vip','prime','regular')")
                                    ->get()
                                    ->mapWithKeys(fn ($u) => [
                                        $u->id => sprintf(
                                            '%s — %s',
                                            $u->name,
                                            match ($u->subscription_plan) {
                                                'regular'   => 'Regular',
                                                'prime'     => 'Prime',
                                                'vip'       => 'VIP',
                                                'prime_vip' => 'Prime VIP',
                                                default     => ucfirst((string) $u->subscription_plan),
                                            }
                                        ),
                                    ])
                            )
                            ->searchable()
                            ->required()
                            ->placeholder('Search by name…'),

                        FileUpload::make('photos')
                            ->label('Photos')
                            ->multiple()
                            ->image()
                            ->disk('public')
                            ->directory('user-gallery')
                            ->maxSize(8192)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->required()
                            ->imagePreviewHeight('120')
                            ->panelLayout('grid')
                            ->helperText('You can upload multiple photos at once. Max 8 MB each.'),

                        Toggle::make('set_first_as_main')
                            ->label('Set first photo as main profile photo')
                            ->default(false),
                    ])
                    ->action(function (array $data): void {
                        $userId  = $data['user_id'];
                        $photos  = $data['photos'] ?? [];
                        $setMain = $data['set_first_as_main'] ?? false;

                        $isFirst = true;
                        foreach ($photos as $path) {
                            $makeMain = $setMain && $isFirst;

                            // If setting as main, clear existing main flag
                            if ($makeMain) {
                                UserPhoto::where('user_id', $userId)
                                    ->where('is_main', true)
                                    ->update(['is_main' => false]);
                            }

                            UserPhoto::create([
                                'user_id' => $userId,
                                'path'    => $path,
                                'is_main' => $makeMain,
                                'caption' => null,
                            ]);

                            // Mirror to cPanel production path
                            $localPath  = storage_path('app/public/' . $path);
                            $cpanelPath = '/home/kenyanba/public_html/storage/' . $path;
                            if (file_exists($localPath) && is_dir('/home/kenyanba/public_html/storage')) {
                                $cpanelDir = dirname($cpanelPath);
                                if (!is_dir($cpanelDir)) {
                                    @mkdir($cpanelDir, 0755, true);
                                }
                                @copy($localPath, $cpanelPath);
                            }

                            $isFirst = false;
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Photos uploaded successfully')
                            ->success()
                            ->body(count($photos) . ' photo(s) added to the user\'s profile.')
                            ->send();
                    }),
            ])
            ->recordActions([
                Action::make('view_photo')
                    ->icon('heroicon-o-eye')
                    ->label('View')
                    ->modalHeading('View Photo')
                    ->modalContent(fn ($record) => view('filament.components.view-photo', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                Action::make('toggle_main')
                    ->icon(fn ($record) => $record->is_main ? 'heroicon-o-star' : 'heroicon-o-star')
                    ->label(fn ($record) => $record->is_main ? 'Unset Main' : 'Set as Main')
                    ->color(fn ($record) => $record->is_main ? 'gray' : 'warning')
                    ->requiresConfirmation(fn ($record) => $record->is_main)
                    ->confirmationMessage('This will remove the main flag from this photo.')
                    ->action(function ($record): void {
                        if (!$record->is_main) {
                            UserPhoto::where('user_id', $record->user_id)
                                ->where('is_main', true)
                                ->update(['is_main' => false]);
                        }
                        $record->update(['is_main' => !$record->is_main]);
                    }),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserPhotos::route('/'),
        ];
    }
}
