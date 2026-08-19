<?php

namespace App\Filament\Resources\Classifieds;

use App\Filament\Resources\Classifieds\Pages\CreateClassified;
use App\Filament\Resources\Classifieds\Pages\EditClassified;
use App\Filament\Resources\Classifieds\Pages\ListClassifieds;
use App\Filament\Resources\Classifieds\Schemas\ClassifiedForm;
use App\Filament\Resources\Classifieds\Tables\ClassifiedsTable;
use App\Models\Classified;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClassifiedResource extends Resource
{
    protected static ?string $model = Classified::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ClassifiedForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClassifiedsTable::configure($table);
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
            'index' => ListClassifieds::route('/'),
            'create' => CreateClassified::route('/create'),
            'edit' => EditClassified::route('/{record}/edit'),
        ];
    }
}
