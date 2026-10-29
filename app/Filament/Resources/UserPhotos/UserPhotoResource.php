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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

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
                        default     => $state ? ucfirst((string) $state) : 'No Plan',
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
                        'prime_vip' => 'Prime VIP',
                        'vip'       => 'VIP',
                        'prime'     => 'Prime',
                        'regular'   => 'Regular',
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
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return User::query()
                                    ->where(function ($query) use ($search) {
                                        $query->where('name', 'like', "%{$search}%")
                                            ->orWhere('email', 'like', "%{$search}%");
                                    })
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(function ($u) {
                                        $plan = match ($u->subscription_plan) {
                                            'prime_vip' => 'Prime VIP',
                                            'vip'       => 'VIP',
                                            'prime'     => 'Prime',
                                            'regular'   => 'Regular',
                                            default     => $u->subscription_plan ? ucfirst($u->subscription_plan) : 'No Plan',
                                        };
                                        return [$u->id => "{$u->name} ({$u->email}) — [{$plan}]"];
                                    });
                            })
                            ->getOptionLabelUsing(function ($value) {
                                $u = User::find($value);
                                if (!$u) return $value;
                                $plan = match ($u->subscription_plan) {
                                    'prime_vip' => 'Prime VIP',
                                    'vip'       => 'VIP',
                                    'prime'     => 'Prime',
                                    'regular'   => 'Regular',
                                    default     => $u->subscription_plan ? ucfirst($u->subscription_plan) : 'No Plan',
                                };
                                return "{$u->name} ({$u->email}) — [{$plan}]";
                            })
                            ->options(function () {
                                return User::query()
                                    ->orderBy('name')
                                    ->limit(100)
                                    ->get()
                                    ->mapWithKeys(function ($u) {
                                        $plan = match ($u->subscription_plan) {
                                            'prime_vip' => 'Prime VIP',
                                            'vip'       => 'VIP',
                                            'prime'     => 'Prime',
                                            'regular'   => 'Regular',
                                            default     => $u->subscription_plan ? ucfirst($u->subscription_plan) : 'No Plan',
                                        };
                                        return [$u->id => "{$u->name} ({$u->email}) — [{$plan}]"];
                                    });
                            })
                            ->required()
                            ->placeholder('Search by name or email…'),

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
                    ->icon('heroicon-o-star')
                    ->label(fn ($record) => $record->is_main ? 'Unset Main' : 'Set as Main')
                    ->color(fn ($record) => $record->is_main ? 'gray' : 'warning')
                    ->requiresConfirmation()
                    ->modalHeading('Toggle Main Photo')
                    ->modalDescription('Are you sure you want to change the main cover photo status for this user?')
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
