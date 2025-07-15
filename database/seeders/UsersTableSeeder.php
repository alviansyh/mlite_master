<?php

namespace Database\Seeders;

use App\Models\User;
use Filament\Commands\MakeUserCommand as FilamentMakeUserCommand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filamentMakeUserCommand = new FilamentMakeUserCommand;
        $reflector = new \ReflectionObject($filamentMakeUserCommand);

        $getUserModel = $reflector->getMethod('getUserModel');
        $getUserModel->setAccessible(true);
        $getUserModel->invoke($filamentMakeUserCommand)::create([
            'login_name' => 'sysadmin',
            'name' => 'Sysadmin',
        'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::where('login_name', 'sysadmin')->first()->assignRole('admin');
    }
}
