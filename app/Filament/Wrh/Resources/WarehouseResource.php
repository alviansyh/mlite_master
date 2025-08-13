<?php
namespace App\Filament\Wrh\Resources;

use App\Filament\Wrh\Resources\WarehouseResource\Pages;
use App\Models\Warehouse;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Lokasi Gudang';
    protected static ?string $modelLabel = 'Lokasi Gudang';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        $location      = $state      = [];
        $data_location = Storage::json('json/data_location.json');
        if (is_array($data_location)) {
            $location = Collect($data_location['data']);
            $state    = $location->pluck('nama', 'nama');
        }

        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label(ucwords('kode'))
                            ->dehydrateStateUsing(fn(string $state): string => strtoupper($state))
                            ->required()
                            ->maxLength(100),
                        TextInput::make('name')
                            ->label(ucwords('nama'))
                            ->required()
                            ->maxLength(255),
                        Select::make('state')
                            ->label(ucwords('provinsi'))
                            ->live()
                            ->options($state)
                            ->searchable(),
                        Select::make('city')
                            ->label(ucwords('kota / kab'))
                            ->options(function (Get $get) use ($location) {
                                $cities = [];
                                if (filled($get('state'))) {
                                    $cities = Collect($location->where('nama', $get('state'))->first()['cities'])->pluck('nama', 'nama');
                                }
                                return $cities;
                            })
                            ->disabled(fn(Get $get): bool => ! filled($get('state')))
                            ->searchable(),
                        Textarea::make('address')
                            ->label(ucwords('alamat'))
                            ->maxLength(1300),
                        TextInput::make('postcode')
                            ->label(ucwords('kode pos'))
                            ->maxLength(10),
                        Hidden::make('is_active')
                            ->default(true),
                    ])
                    ->columns(2),
                // Section::make()
                //     ->description(ucwords('status'))
                //     ->schema([
                //         Checkbox::make('is_active')
                //             ->label(ucwords('aktif'))
                //             ->default(true)
                //         ,
                //     ])
                //     ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(ucwords('kode'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label(ucwords('nama'))
                    ->searchable(),
                TextColumn::make('state')
                    ->label(ucwords('provinsi'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('city')
                    ->label(ucwords('kota / kab'))
                    ->sortable()
                    ->searchable(),
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
                    })
                    ->sortable(),
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
            'index'  => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit'   => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
