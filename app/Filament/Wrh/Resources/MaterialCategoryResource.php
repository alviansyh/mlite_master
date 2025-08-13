<?php
namespace App\Filament\Wrh\Resources;

use App\Filament\Wrh\Resources\MaterialCategoryResource\Pages;
use App\Models\MaterialCategory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaterialCategoryResource extends Resource
{
    protected static ?string $model = MaterialCategory::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Kategori Bahan Baku';
    protected static ?string $modelLabel = 'Kategori Bahan Baku';
    // protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
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
                            ucwords('aktif')       => 'success',
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
            'index'  => Pages\ListMaterialCategories::route('/'),
            'create' => Pages\CreateMaterialCategory::route('/create'),
            'edit'   => Pages\EditMaterialCategory::route('/{record}/edit'),
        ];
    }
}
