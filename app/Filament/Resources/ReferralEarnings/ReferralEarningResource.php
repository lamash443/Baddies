<?php

namespace App\Filament\Resources\ReferralEarnings;

use App\Filament\Resources\ReferralEarnings\Pages\CreateReferralEarning;
use App\Filament\Resources\ReferralEarnings\Pages\EditReferralEarning;
use App\Filament\Resources\ReferralEarnings\Pages\ListReferralEarnings;
use App\Filament\Resources\ReferralEarnings\Schemas\ReferralEarningForm;
use App\Filament\Resources\ReferralEarnings\Tables\ReferralEarningsTable;
use App\Models\ReferralEarning;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReferralEarningResource extends Resource
{
    protected static ?string $model = ReferralEarning::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;
    
    protected static ?string $navigationLabel = 'Referral Earnings';

    public static function getNavigationGroup(): ?string
    {
        return 'Finance';
    }

    public static function form(Schema $schema): Schema
    {
        return ReferralEarningForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReferralEarningsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReferralEarnings::route('/'),
            'create' => CreateReferralEarning::route('/create'),
            'edit' => EditReferralEarning::route('/{record}/edit'),
        ];
    }
}
