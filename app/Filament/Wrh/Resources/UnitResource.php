<?php
namespace App\Filament\Wrh\Resources;

use App\Filament\Wrh\Resources\UnitResource\Pages;
use App\Models\Unit;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UnitResource extends Resource
{
    protected static ?string $model           = Unit::class;
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Master Satuan';
    protected static ?string $modelLabel      = 'Master Satuan';
    protected static ?int $navigationSort     = 2;
    protected static ?string $navigationIcon  = 'heroicon-o-scale';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label(ucwords('kode'))
                    ->unique(ignoreRecord: true)
                    ->dehydrateStateUsing(fn(string $state): string => strtolower($state))
                    ->required()
                    ->maxLength(255),
                TextInput::make('name')
                    ->label(ucwords('deskripsi'))
                    ->dehydrateStateUsing(fn(string $state): string => ucwords($state))
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(ucwords('kode')),
                TextColumn::make('name')
                    ->label(ucwords('deskripsi')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
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
            'index'  => Pages\ListUnits::route('/'),
        ];
    }
}
