<?php
namespace App\Filament\Wrh\Resources;

use App\Filament\Wrh\Resources\TransactionResource\Pages;
use App\Models\Material;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
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

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $modelLabel = 'Transaksi';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(ucwords('informasi transaksi')) 
                    ->schema([
                        Radio::make('type')
                            ->label(ucwords('tipe'))
                            ->options([
                                1 => ucwords('masuk'),
                                2 => ucwords('keluar'),
                            ])
                            ->descriptions([
                                1 => ucfirst('transaksi bahan baku masuk'),
                                2 => ucfirst('transaksi bahan baku keluar'),
                            ])
                            ->inline()
                            ->default(1),
                        TextInput::make('document_number')
                            ->label('Nomor Dokumen')
                            ->unique(ignoreRecord: true)
                            ->required(),
                        DatePicker::make('date')
                            ->label(ucwords('tanggal'))
                            ->native(false)
                            ->displayFormat('j mm Y')
                            ->suffixIcon('heroicon-o-calendar')
                            ->suffixIconColor('primary')
                            ->default(now())
                            ->closeOnDateSelection()
                            ->required(),
                        TextInput::make('reference')
                            ->label(ucwords('referensi dokumen'))
                            ->maxLength(255),
                        Textarea::make('notes')
                            ->label(ucwords('catatan'))
                            ->rows(3)
                            ->maxLength(65535)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
                Section::make(ucwords('gudang dan detail item')) 
                    ->schema([
                        Select::make('destination_warehouse_id')
                            ->label(ucwords('gudang tujuan'))
                            ->options(Warehouse::pluck('name', 'id'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') == 1)
                            ->searchable()
                            ->columnSpan(2),
                        Select::make('source_warehouse_id')
                            ->label(ucwords('gudang asal'))
                            ->options(Warehouse::pluck('name', 'id'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') == 2)
                            ->searchable()
                            ->columnSpan(2),
                        Repeater::make('items')
                            ->label(ucwords('detail item'))
                            ->relationship('items')
                            ->columnSpan(2)
                            ->schema([
                                Select::make('material_id')
                                    ->label(ucwords('bahan baku'))
                                    ->options(Material::pluck('name', 'id'))
                                    ->reactive()
                                    ->required(),
                                TextInput::make('batch_number')
                                    ->label(ucwords('nomor batch'))
                                    ->required(),
                                DatePicker::make('expired_at')
                                    ->label(ucwords('tanggal kedaluwarsa'))
                                    ->native(false)
                                    ->displayFormat('j mm Y')
                                    ->suffixIcon('heroicon-o-calendar')
                                    ->suffixIconColor('primary')
                                    ->default(now())
                                    ->closeOnDateSelection()
                                    ->required(),
                                Select::make('unit_code')
                                    ->label(ucwords('satuan'))
                                    ->default('kg')
                                    ->options(function (Get $get) {
                                        $opt = [];
                                        if (filled($get('material_id'))) {
                                            $material = Material::select('base_unit_code')->where('id', $get('material_id'))->first();
                                            $opt = Unit::where('code', $material['base_unit_code'])->pluck('name', 'code')->toArray();
                                            // dd($opt);
                                        }
                                        return $opt;
                                    })
                                    ->selectablePlaceholder(false)
                                    ->disabled(fn(Get $get): bool => ! filled($get('material_id')))
                                    ->required(),
                                TextInput::make('quantity')
                                    ->label(ucwords('jumlah'))
                                    ->numeric()
                                    ->required()
                                    ->minValue(1),
                            ])
                            ->defaultItems(1)
                            ->columns(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_number')
                    ->label('Nomor Dokumen')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        return (int) $record->type == 1 ? ucwords('masuk') : ucwords('keluar');
                    })
                    ->color(function (string $state): string {
                        $map = [
                            ucwords('masuk')       => 'success',
                            ucwords('keluar') => 'danger',
                        ];
                        return $map[$state] ?? 'secondary';
                    })
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('destinationWarehouse.name')
                    ->label('Gudang Tujuan')
                    ->sortable(),
                TextColumn::make('sourceWarehouse.name')
                    ->label('Gudang Asal')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Dibuat Oleh')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit'   => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
