<?php
namespace App\Filament\Wrh\Resources;

use App\Filament\Wrh\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationLabel = 'Inventori';

    protected static ?string $modelLabel = 'Inventori';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('material.name')
                    ->label('Material')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('warehouse.name')
                    ->label('Gudang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('batch_number')
                    ->label('No. Batch')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Jumlah Stok')
                    ->alignment(Alignment::Center)
                    ->badge()
                    ->color(function (string $state): string {
                        $map = [
                            'primary',
                            fn($state) => $state <= 10       => 'success',
                            fn($state) => $state > 10 && $state <= 50 => 'danger',
                        ];
                        return $map[$state] ?? 'secondary';
                    })
                    ->sortable(),
                TextColumn::make('unit.name')
                    ->label('Satuan'),
                TextColumn::make('expired_at')
                    ->label('Tgl. Kedaluwarsa')
                    ->date()
                    ->sortable()
                    ->color(fn($state) => now()->addMonths(3) > $state ? 'danger' : null),
                TextColumn::make('created_at')
                    ->label('Terakhir Masuk')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'edit'   => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}
