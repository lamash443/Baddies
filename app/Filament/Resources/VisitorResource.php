<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitorResource\Pages;
use App\Filament\Resources\Users\UserResource;
use App\Models\BlockedIp;
use App\Models\User;
use App\Models\Visitor;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class VisitorResource extends Resource
{
    protected static ?string $model = Visitor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static \UnitEnum|string|null $navigationGroup = 'Analytics';

    protected static ?string $navigationLabel = 'Visitors Tracking';

    protected static ?string $breadcrumb = 'Visitors Tracking';

    protected static ?string $modelLabel = 'Visitor Session';

    protected static ?string $pluralModelLabel = 'Visitors Tracking';

    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        try {
            return (string) Visitor::distinct('ip_address')->count('ip_address');
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'primary';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Total unique IP visitors tracked';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->label('Status')
                    ->state(fn (Visitor $record) => $record->status_label)
                    ->badge()
                    ->color(fn (Visitor $record) => $record->status_color)
                    ->icon(fn (Visitor $record) => $record->is_online ? 'heroicon-m-signal' : 'heroicon-m-clock')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('last_visit_at', $direction)),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->icon('heroicon-m-signal')
                    ->tooltip('Click to copy IP address'),

                TextColumn::make('registered_user_name')
                    ->label('User')
                    ->badge()
                    ->state(fn (Visitor $record) => $record->registered_user_name ?? 'Guest')
                    ->color(fn (string $state) => $state !== 'Guest' ? 'primary' : 'gray')
                    ->icon(fn (string $state) => $state !== 'Guest' ? 'heroicon-m-user-circle' : 'heroicon-m-user')
                    ->url(function (Visitor $record): ?string {
                        $user = $record->registered_user;
                        return $user ? UserResource::getUrl('edit', ['record' => $user->id]) : null;
                    })
                    ->openUrlInNewTab()
                    ->tooltip(function (Visitor $record): ?string {
                        $user = $record->registered_user;
                        return $user ? "Registered account: {$user->name} ({$user->email})" : 'Anonymous guest visitor';
                    })
                    ->searchable(query: function (Builder $query, string $search) {
                        try {
                            $matchingIps = User::where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->pluck('registration_ip')
                                ->filter()
                                ->toArray();

                            $matchingIds = User::where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->pluck('id')
                                ->toArray();

                            return $query->where(function ($q) use ($matchingIps, $matchingIds) {
                                if (!empty($matchingIps)) {
                                    $q->whereIn('ip_address', $matchingIps);
                                }
                                if (Schema::hasColumn('visitors', 'user_id') && !empty($matchingIds)) {
                                    $q->orWhereIn('user_id', $matchingIds);
                                }
                            });
                        } catch (\Throwable) {
                            return $query;
                        }
                    }),

                TextColumn::make('blocked_status')
                    ->label('Blocked')
                    ->badge()
                    ->state(function (Visitor $record): string {
                        try {
                            return BlockedIp::where('ip_address', $record->ip_address)->exists() ? 'Blocked' : 'Allowed';
                        } catch (\Throwable) {
                            return 'Allowed';
                        }
                    })
                    ->color(function (Visitor $record): string {
                        try {
                            return BlockedIp::where('ip_address', $record->ip_address)->exists() ? 'danger' : 'success';
                        } catch (\Throwable) {
                            return 'success';
                        }
                    })
                    ->icon(function (Visitor $record): string {
                        try {
                            return BlockedIp::where('ip_address', $record->ip_address)->exists() ? 'heroicon-m-no-symbol' : 'heroicon-m-check-circle';
                        } catch (\Throwable) {
                            return 'heroicon-m-check-circle';
                        }
                    }),

                TextColumn::make('location')
                    ->label('Location')
                    ->state(fn (Visitor $record) => $record->location_string)
                    ->searchable(query: function (Builder $query, string $search) {
                        return $query->where(function ($q) use ($search) {
                            $q->where('country', 'like', "%{$search}%")
                              ->orWhere('city', 'like', "%{$search}%")
                              ->orWhere('region', 'like', "%{$search}%")
                              ->orWhere('ip_address', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('country', $direction)),

                TextColumn::make('visits_count')
                    ->label('Pageviews')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-eye')
                    ->sortable(),

                TextColumn::make('formatted_time_on_site')
                    ->label('Time on Site')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-m-clock')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('total_time_seconds', $direction)),

                TextColumn::make('device')
                    ->label('Device & Browser')
                    ->state(fn (Visitor $record) => $record->device)
                    ->color('gray')
                    ->limit(35),

                TextColumn::make('visit_date')
                    ->label('Visit Date')
                    ->date('d M Y')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('first_visit_at')
                    ->label('First Visit')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('last_visit_at')
                    ->label('Last Active')
                    ->since()
                    ->sortable()
                    ->color('primary')
                    ->tooltip(fn (Visitor $record) => $record->last_visit_at ? $record->last_visit_at->format('d M Y, H:i:s') : null),
            ])
            ->defaultSort('last_visit_at', 'desc')
            ->filters([
                Filter::make('active_today')
                    ->label('Active Today')
                    ->query(fn (Builder $query) => $query->whereDate('visit_date', today()))
                    ->toggle(),

                Filter::make('online_now')
                    ->label('Online Now (Last 15m)')
                    ->query(fn (Builder $query) => $query->where('last_visit_at', '>=', now()->subMinutes(15)))
                    ->toggle(),

                Filter::make('high_engagement')
                    ->label('High Engagement (>1m or >3 visits)')
                    ->query(fn (Builder $query) => $query->where(function ($q) {
                        $q->where('total_time_seconds', '>=', 60)
                          ->orWhere('visits_count', '>=', 3);
                    }))
                    ->toggle(),

                Filter::make('blocked')
                    ->label('Blocked IPs Only')
                    ->query(function (Builder $query) {
                        try {
                            $blockedIps = BlockedIp::pluck('ip_address')->toArray();
                            return $query->whereIn('ip_address', $blockedIps);
                        } catch (\Throwable) {
                            return $query;
                        }
                    })
                    ->toggle(),

                Filter::make('registered')
                    ->label('Registered Users Only')
                    ->query(function (Builder $query) {
                        try {
                            $regIps = User::whereNotNull('registration_ip')->pluck('registration_ip')->filter()->unique()->toArray();
                            return $query->where(function ($q) use ($regIps) {
                                if (!empty($regIps)) {
                                    $q->whereIn('ip_address', $regIps);
                                }
                                if (Schema::hasColumn('visitors', 'user_id')) {
                                    $q->orWhereNotNull('user_id');
                                }
                            });
                        } catch (\Throwable) {
                            return $query;
                        }
                    })
                    ->toggle(),

                SelectFilter::make('country')
                    ->label('Country')
                    ->searchable()
                    ->options(function () {
                        if (!Schema::hasColumn('visitors', 'country')) {
                            return [];
                        }
                        return Visitor::whereNotNull('country')
                            ->where('country', '!=', '')
                            ->where('country', '!=', 'Unknown')
                            ->distinct()
                            ->orderBy('country')
                            ->pluck('country', 'country')
                            ->toArray();
                    }),
            ])
            ->recordActions([
                Action::make('inspect')
                    ->label('Inspect')
                    ->icon('heroicon-m-information-circle')
                    ->color('info')
                    ->modalHeading(fn (Visitor $record) => "Visitor Session Telemetry • {$record->ip_address}")
                    ->modalDescription(fn (Visitor $record) => "Detailed geographic, technical, and engagement telemetry")
                    ->modalContent(fn (Visitor $record) => view('filament.pages.visitor-details-modal', ['visitor' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                Action::make('block_ip')
                    ->label(function (Visitor $record): string {
                        try {
                            return BlockedIp::where('ip_address', $record->ip_address)->exists() ? 'Unblock IP' : 'Block IP';
                        } catch (\Throwable) {
                            return 'Block IP';
                        }
                    })
                    ->icon(function (Visitor $record): string {
                        try {
                            return BlockedIp::where('ip_address', $record->ip_address)->exists() ? 'heroicon-m-lock-open' : 'heroicon-m-no-symbol';
                        } catch (\Throwable) {
                            return 'heroicon-m-no-symbol';
                        }
                    })
                    ->color(function (Visitor $record): string {
                        try {
                            return BlockedIp::where('ip_address', $record->ip_address)->exists() ? 'success' : 'danger';
                        } catch (\Throwable) {
                            return 'danger';
                        }
                    })
                    ->requiresConfirmation()
                    ->modalHeading(fn (Visitor $record) => BlockedIp::where('ip_address', $record->ip_address)->exists()
                        ? "Unblock IP: {$record->ip_address}"
                        : "Block IP: {$record->ip_address}")
                    ->modalDescription(fn (Visitor $record) => BlockedIp::where('ip_address', $record->ip_address)->exists()
                        ? "This will remove the block and allow this IP to access the website again."
                        : "This will prevent this IP address from accessing the website. The visitor will see a 403 Access Restricted page.")
                    ->modalIcon(fn (Visitor $record) => BlockedIp::where('ip_address', $record->ip_address)->exists()
                        ? 'heroicon-o-lock-open'
                        : 'heroicon-o-no-symbol')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('reason')
                            ->label('Reason for blocking (optional)')
                            ->placeholder('e.g. Spam, abuse, suspicious activity...')
                            ->maxLength(255)
                            ->helperText('Leave blank to block without a reason. This field is ignored when unblocking.'),
                    ])
                    ->action(function (Visitor $record, array $data): void {
                        try {
                            $isCurrentlyBlocked = BlockedIp::where('ip_address', $record->ip_address)->exists();

                            if ($isCurrentlyBlocked) {
                                BlockedIp::unblockIp($record->ip_address);
                                Notification::make()
                                    ->title('IP Unblocked')
                                    ->body("IP address {$record->ip_address} has been unblocked and can now access the website.")
                                    ->success()
                                    ->send();
                            } else {
                                BlockedIp::blockIp(
                                    $record->ip_address,
                                    $data['reason'] ?? null,
                                    Auth::id()
                                );
                                Notification::make()
                                    ->title('IP Blocked')
                                    ->body("IP address {$record->ip_address} has been blocked from accessing the website.")
                                    ->danger()
                                    ->send();
                            }
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Error')
                                ->body('Could not update IP block status: ' . $e->getMessage())
                                ->warning()
                                ->send();
                        }
                    }),

                Action::make('ip_lookup')
                    ->label('IP Info')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (Visitor $record) => "https://whatismyipaddress.com/ip/{$record->ip_address}")
                    ->openUrlInNewTab(),

                DeleteAction::make()
                    ->modalHeading('Delete Visitor Record')
                    ->modalDescription('Are you sure you want to delete this visitor record?'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->modalHeading('Delete Selected Visitor Records')
                        ->modalDescription('Are you sure you want to delete the selected visitor records?'),
                ]),
            ])
            ->emptyStateHeading('No visitors tracked yet')
            ->emptyStateDescription('Real-time visitor data including IP address, geographic location, device specs, and time on site will appear here as users browse the website.')
            ->emptyStateIcon('heroicon-o-globe-alt');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisitors::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
