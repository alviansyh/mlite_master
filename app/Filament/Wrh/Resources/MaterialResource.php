<?php
namespace App\Filament\Wrh\Resources;

use App\Filament\Wrh\Resources\MaterialResource\Pages;
use App\Models\Material;
use App\Models\Unit;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Bahan Baku';

    protected static ?string $modelLabel = 'Bahan Baku';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Kode Bahan Baku / SKU')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('name')
                            ->label('Nama Bahan Baku')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->maxLength(65535),
                        Select::make('material_category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->required(),
                        TextInput::make('minimum_stock')
                            ->label('Minimum Stok')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Select::make('base_unit_code')
                            ->label('Satuan Dasar')
                            ->options(Unit::pluck('name', 'code'))
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode / SKU')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Bahan Baku')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                TextColumn::make('baseUnit.name')
                    ->label('Satuan Dasar')
                    ->sortable(),
                TextColumn::make('minimum_stock')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index'  => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit'   => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
