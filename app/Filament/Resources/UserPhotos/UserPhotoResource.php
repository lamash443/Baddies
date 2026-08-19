<?php

namespace App\Filament\Resources\UserPhotos;

use App\Filament\Resources\UserPhotos\Pages\ListUserPhotos;
use App\Models\UserPhoto;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
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
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),
                ImageColumn::make('path')
                    ->label('Photo')
                    ->disk('public')
                    ->height(80)
                    ->width(80)
                    ->extraImgAttributes(['style' => 'object-fit:cover;border-radius:8px;']),
                TextColumn::make('caption')
                    ->label('Caption')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->recordActions([
                \Filament\Actions\Action::make('view_photo')
                    ->icon('heroicon-o-eye')
                    ->label('View')
                    ->modalHeading('View Photo')
                    ->modalContent(fn ($record) => view('filament.components.view-photo', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
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
