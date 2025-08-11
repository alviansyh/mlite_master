<?php
namespace App\Filament\Wrh\Resources;

use App\Filament\Wrh\Resources\WarehouseResource\Pages;
use App\Models\Warehouse;
use Filament\Forms\Components\Checkbox;
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

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Gudang';

    protected static ?string $modelLabel = 'Gudang';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                TextInput::make('code')
                    ->translateLabel()
                    ->dehydrateStateUsing(fn(string $state): string => strtoupper($state))
                    ->required(),
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                Select::make('state')
                    ->live()
                    ->options($state)
                    ->searchable()
                    ->translateLabel(),
                Select::make('city')
                    ->options(function (Get $get) use ($location) {
                        $cities = [];
                        if (filled($get('state'))) {
                            $cities = Collect($location->where('nama', $get('state'))->first()['cities'])->pluck('nama', 'nama');
                        }
                        return $cities;
                    })
                    ->disabled(fn(Get $get): bool => ! filled($get('state')))
                    ->searchable()
                    ->translateLabel(),
                Textarea::make('address')
                    ->translateLabel(),
                TextInput::make('postcode')
                    ->translateLabel(),
                Checkbox::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(ucwords('kode'))
                    ->translateLabel(),
                TextColumn::make('name')
                    ->label(ucwords('nama'))
                    ->translateLabel(),
                TextColumn::make('state')
                    ->label(ucwords('provinsi'))
                    ->translateLabel(),
                TextColumn::make('city')
                    ->label(ucwords('kota / kab'))
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
            'index'  => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit'   => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
