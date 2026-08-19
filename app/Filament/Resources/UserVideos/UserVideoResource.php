<?php

namespace App\Filament\Resources\UserVideos;

use App\Filament\Resources\UserVideos\Pages\ListUserVideos;
use App\Models\UserVideo;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserVideoResource extends Resource
{
    protected static ?string $model = UserVideo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static ?string $navigationLabel = 'User Videos';

    protected static \UnitEnum|string|null $navigationGroup = 'Media';

    protected static ?int $navigationSort = 2;

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
                TextColumn::make('path')
                    ->label('File Path')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->path)
                    ->toggleable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->placeholder('—'),
                TextColumn::make('views')
                    ->label('Views')
                    ->sortable()
                    ->numeric(),
                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->recordActions([
                \Filament\Actions\Action::make('view_video')
                    ->icon('heroicon-o-play')
                    ->label('Play')
                    ->modalHeading('Play Video')
                    ->modalContent(fn ($record) => view('filament.components.view-video', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
                \Filament\Actions\EditAction::make()
                    ->form([
                        \Filament\Forms\Components\TextInput::make('views')
                            ->label('View Count')
                            ->numeric()
                            ->required(),
                    ]),
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
            'index' => ListUserVideos::route('/'),
        ];
    }
}
