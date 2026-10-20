<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitorResource\Pages;
use App\Models\Visitor;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class VisitorResource extends Resource
{
    protected static ?string $model = Visitor::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static \UnitEnum|string|null $navigationGroup = 'Analytics';
    protected static ?string $navigationLabel = 'Unique Visitors';
    protected static ?int    $navigationSort  = 5;

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

    public static function getEloquentQuery(): Builder
    {
        try {
            $hasCountry = \Illuminate\Support\Facades\Schema::hasColumn('visitors', 'country');
            $hasTime = \Illuminate\Support\Facades\Schema::hasColumn('visitors', 'total_time_seconds');

            $select = [
                'MAX(id) as id',
                'ip_address',
                'MAX(user_agent) as user_agent',
                'MIN(created_at) as first_visit_at',
                'MAX(COALESCE(last_visit_at, updated_at)) as last_visit_at',
                'SUM(visits_count) as visits_count',
                'MAX(created_at) as created_at',
            ];

            if ($hasCountry) {
                $select[] = 'MAX(country) as country';
                $select[] = 'MAX(country_code) as country_code';
                $select[] = 'MAX(city) as city';
                $select[] = 'MAX(region) as region';
            }

            if ($hasTime) {
                $select[] = 'SUM(total_time_seconds) as total_time_seconds';
            }

            return parent::getEloquentQuery()
                ->selectRaw(implode(', ', $select))
                ->groupBy('ip_address');
        } catch (\Throwable $e) {
            return parent::getEloquentQuery();
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-signal')
                    ->weight('bold')
                    ->tooltip('Click to copy IP address'),

                TextColumn::make('location')
                    ->label('Location')
                    ->state(fn (Visitor $record) => $record->location_string)
                    ->searchable(query: function (Builder $query, string $search) {
                        return $query->where(function ($q) use ($search) {
                            $q->where('country', 'like', "%{$search}%")
                              ->orWhere('city', 'like', "%{$search}%")
                              ->orWhere('ip_address', 'like', "%{$search}%");
                        });
                    })
                    ->badge()
                    ->color('gray'),

                TextColumn::make('formatted_time_on_site')
                    ->label('Total Time on Site')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-m-clock')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('total_time_seconds', $direction)),

                TextColumn::make('visits_count')
                    ->label('Pageviews / Visits')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-eye')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('visits_count', $direction)),

                TextColumn::make('device')
                    ->label('Device & Browser')
                    ->state(fn (Visitor $record) => $record->device)
                    ->color('gray')
                    ->limit(35),

                TextColumn::make('first_visit_at')
                    ->label('First Visit')
                    ->dateTime('d M Y, H:i')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('first_visit_at', $direction)),

                TextColumn::make('last_visit_at')
                    ->label('Last Active')
                    ->since()
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('last_visit_at', $direction))
                    ->color('primary'),
            ])
            ->defaultSort('last_visit_at', 'desc')
            ->filters([
                Filter::make('active_today')
                    ->label('Active Today')
                    ->query(fn (Builder $query) => $query->whereDate('visit_date', today()))
                    ->toggle(),

                SelectFilter::make('country')
                    ->label('Country')
                    ->options(function () {
                        return Visitor::whereNotNull('country')
                            ->where('country', '!=', '')
                            ->distinct()
                            ->pluck('country', 'country')
                            ->toArray();
                    }),
            ])
            ->actions([])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No visitors tracked yet')
            ->emptyStateDescription('Visitor data including IP location and time spent on site will appear here as users browse the website.')
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
