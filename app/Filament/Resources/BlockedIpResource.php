<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockedIpResource\Pages;
use App\Models\BlockedIp;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BlockedIpResource extends Resource
{
    protected static ?string $model = BlockedIp::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNoSymbol;

    protected static \UnitEnum|string|null $navigationGroup = 'Analytics';

    protected static ?string $navigationLabel = 'Blocked IPs';

    protected static ?string $breadcrumb = 'Blocked IPs';

    protected static ?string $modelLabel = 'Blocked IP';

    protected static ?string $pluralModelLabel = 'Blocked IPs';

    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        try {
            return (string) BlockedIp::count();
        } catch (\Throwable) {
            return null;
        }
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'danger';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Total blocked IP addresses';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->copyable()
                    ->icon('heroicon-m-no-symbol')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('reason')
                    ->label('Reason')
                    ->placeholder('No reason given')
                    ->limit(60)
                    ->tooltip(fn (BlockedIp $record) => $record->reason)
                    ->color('gray'),

                TextColumn::make('blocker.name')
                    ->label('Blocked By')
                    ->placeholder('Unknown')
                    ->badge()
                    ->color('warning')
                    ->icon('heroicon-m-user'),

                TextColumn::make('blocked_at')
                    ->label('Blocked At')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->since()
                    ->color('danger'),

                TextColumn::make('created_at')
                    ->label('Record Created')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('has_reason')
                    ->label('Has reason noted')
                    ->query(fn (Builder $query) => $query->whereNotNull('reason')->where('reason', '!=', ''))
                    ->toggle(),
            ])
            ->recordActions([
                Action::make('unblock')
                    ->label('Unblock')
                    ->icon('heroicon-m-lock-open')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading(fn (BlockedIp $record) => "Unblock IP: {$record->ip_address}")
                    ->modalDescription('This will remove the block and allow this IP to access the website again.')
                    ->modalIcon('heroicon-o-lock-open')
                    ->action(function (BlockedIp $record): void {
                        try {
                            Cache::forget('blocked_ip_' . md5($record->ip_address));
                            Cache::forget('blocked_ips_count');
                            $record->delete();

                            Notification::make()
                                ->title('IP Unblocked')
                                ->body("IP address {$record->ip_address} has been unblocked and can now access the website.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Error')
                                ->body('Could not unblock IP: ' . $e->getMessage())
                                ->warning()
                                ->send();
                        }
                    }),

                DeleteAction::make()
                    ->modalHeading(fn (BlockedIp $record) => "Remove Block: {$record->ip_address}")
                    ->modalDescription('This will permanently remove this blocked IP record.')
                    ->after(function (BlockedIp $record) {
                        Cache::forget('blocked_ip_' . md5($record->ip_address));
                        Cache::forget('blocked_ips_count');
                    }),
            ])
            ->headerActions([
                Action::make('add_blocked_ip')
                    ->label('Block IP Address')
                    ->icon('heroicon-m-no-symbol')
                    ->color('danger')
                    ->form([
                        \Filament\Schemas\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->required()
                            ->placeholder('e.g. 197.237.100.1')
                            ->maxLength(45)
                            ->rules(['ip']),

                        \Filament\Schemas\Components\TextInput::make('reason')
                            ->label('Reason (optional)')
                            ->placeholder('e.g. Spam, abuse, suspicious activity...')
                            ->maxLength(255),
                    ])
                    ->action(function (array $data): void {
                        $ip = trim($data['ip_address']);

                        if ($ip === '127.0.0.1' || $ip === '::1' || $ip === 'localhost') {
                            Notification::make()
                                ->title('Cannot Block Localhost')
                                ->body('Blocking localhost or loopback IPs is not permitted.')
                                ->warning()
                                ->send();
                            return;
                        }

                        try {
                            BlockedIp::blockIp($ip, $data['reason'] ?? null, Auth::id());

                            Notification::make()
                                ->title('IP Blocked')
                                ->body("IP address {$ip} has been blocked from accessing the website.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Error')
                                ->body('Could not block IP: ' . $e->getMessage())
                                ->warning()
                                ->send();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->modalHeading('Remove Selected Blocked IPs')
                        ->modalDescription('This will unblock all selected IP addresses.')
                        ->after(function () {
                            Cache::flush();
                        }),
                ]),
            ])
            ->emptyStateHeading('No IPs blocked yet')
            ->emptyStateDescription('Block an IP address to prevent it from accessing the website. Blocked IPs will see a 403 Access Restricted page.')
            ->emptyStateIcon('heroicon-o-no-symbol')
            ->emptyStateActions([
                Action::make('add_first_block')
                    ->label('Block an IP Address')
                    ->icon('heroicon-m-no-symbol')
                    ->color('danger')
                    ->form([
                        \Filament\Schemas\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->required()
                            ->placeholder('e.g. 197.237.100.1')
                            ->maxLength(45)
                            ->rules(['ip']),

                        \Filament\Schemas\Components\TextInput::make('reason')
                            ->label('Reason (optional)')
                            ->placeholder('e.g. Spam, abuse, suspicious activity...')
                            ->maxLength(255),
                    ])
                    ->action(function (array $data): void {
                        $ip = trim($data['ip_address']);
                        try {
                            BlockedIp::blockIp($ip, $data['reason'] ?? null, Auth::id());
                            Notification::make()
                                ->title('IP Blocked')
                                ->body("IP address {$ip} has been blocked.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Error')
                                ->body('Could not block IP: ' . $e->getMessage())
                                ->warning()
                                ->send();
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlockedIps::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
