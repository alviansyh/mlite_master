<?php
namespace App\Filament\Wrh\Resources;

use App\Filament\Wrh\Resources\ProductCategoryResource\Pages;
use App\Models\ProductCategory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Kategori Produk';

    protected static ?string $modelLabel = 'Kategori Produk';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                TextColumn::make('name')
                    ->label(ucwords('nama'))
                    ->translateLabel(),
                TextColumn::make('description')
                    ->label(ucwords('deskripsi'))
                    ->translateLabel(),
                TextColumn::make('is_active')
                    ->label(ucwords('status'))
                    ->translateLabel()
                    ->alignment(Alignment::Center)
                    ->badge()
                    ->getStateUsing(function ($record) {
                        return (bool) $record->is_active ? ucwords('aktif') : ucwords('tidak aktif');
                    })
                    ->color(fn(string $state): string => match ($state) {
                        ucwords('aktif')                  => 'success',
                        ucwords('tidak aktif')            => 'danger',
                    }),
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
            'index'  => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'edit'   => Pages\EditProductCategory::route('/{record}/edit'),
        ];
    }
}
