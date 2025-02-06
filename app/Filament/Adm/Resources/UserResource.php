<?php
namespace App\Filament\Adm\Resources;

use App\Filament\Adm\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'User Accounts';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Users';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel(),
                TextInput::make('login_name')
                    ->translateLabel()
                    ->unique(ignoreRecord: true)
                    ->required(),
                Select::make('employee_id')
                    ->label('Employee ID')
                    ->translateLabel()
                    ->options([])
                    ->searchable(),
                TextInput::make('email')
                    ->translateLabel()
                    ->email(),
                TextInput::make('password')
                    ->translateLabel()
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state)),
                TextInput::make('password_confirmation')
                    ->label('Confirm Password')
                    ->translateLabel()
                    ->password()
                    ->same('password')
                    ->revealable()
                    ->visible(fn (string $operation): bool => $operation === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->translateLabel()
                    ->state(
                        static function (HasTable $livewire, $rowLoop): string {
                            return (string) (
                                $rowLoop->iteration +
                                ($livewire->getTableRecordsPerPage() * (
                                    $livewire->getTablePage() - 1
                                ))
                            );
                        }
                    )
                    ->alignment(Alignment::Center),
                TextColumn::make('login_name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->translateLabel()
                    ->limit('50')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('employee_id')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->translateLabel()
                    ->alignment(Alignment::Center)
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Inactive'                        => 'gray',
                        'Active'                          => 'success',
                    }),
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
