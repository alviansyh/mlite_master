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

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Master Kategori Produk';

    protected static ?string $modelLabel = 'Master Kategori Produk';

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
                    ->label(ucwords('nama')),
                TextColumn::make('description')
                    ->label(ucwords('deskripsi')),
                TextColumn::make('is_active')
                    ->label(ucwords('status'))
                    ->alignment(Alignment::Center)
                    ->badge()
                    ->getStateUsing(function ($record) {
                        return (bool) $record->is_active ? ucwords('aktif') : ucwords('tidak aktif');
                    })
                    ->color(function (string $state): string {
                        $map = [
                            ucwords('aktif') => 'success',
                            ucwords('tidak aktif') => 'danger',
                        ];
                        return $map[$state] ?? 'secondary';
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
