<?php
namespace App\Providers;

use App\Http\Responses\LoginResponse;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoginResponseContract::class, LoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch->modalHeading('Available Panels')
                ->simple()
                ->iconSize(16)
                ->visible(fn(): bool => auth()->user()->hasAnyRole([
                    'sysadmin',
                    'admin',
                    'manager',
                    'employee',
                ]))
                ->labels(function () {
                    $labels = [
                        'app' => 'App',
                        'adm' => 'Admin',
                        'wrh' => 'Gudang',
                        'mar' => 'Pemasaran',
                    ];

                    return $labels;
                })
                ->panels(function () {
                    $panels = [];
                    if (auth()->check()) {
                        $user = auth()->user();
                        if ($user->hasAnyRole('sysadmin', 'admin')) {
                            $panels = ['adm'];
                        } elseif ($user->hasAnyRole('manager', 'employee')) {
                            $panels = ['wrh', 'mar'];
                        } else {
                            $panels = ['app'];
                        }
                    }

                    return $panels;
                });
        });
    }
}
