<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReferralEarningsRelationManager extends RelationManager
{
    protected static string $relationship = 'referralEarnings';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('referee_id')
                    ->relationship('referee', 'name')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('deposit_amount')
                    ->required()
                    ->numeric(),
                \Filament\Forms\Components\TextInput::make('commission_rate')
                    ->required()
                    ->numeric(),
                \Filament\Forms\Components\TextInput::make('bonus_amount')
                    ->required()
                    ->numeric(),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'awarded' => 'Awarded',
                        'redeemed' => 'Redeemed',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('referee.name')
                    ->label('Referred User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deposit_amount')
                    ->label('Deposit')
                    ->numeric(2)
                    ->prefix('Ksh ')
                    ->sortable(),
                TextColumn::make('bonus_amount')
                    ->label('Bonus')
                    ->numeric(2)
                    ->prefix('Ksh ')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'awarded' => 'warning',
                        'redeemed' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
