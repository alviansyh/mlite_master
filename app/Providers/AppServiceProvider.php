<?php
namespace App\Providers;

use App\Http\Responses\LoginResponse;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
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
                    $labels = [];
                    if (auth()->check()) {
                        $user = auth()->user();
                        switch ($user) {
                            case $user->hasRole('sysadmin'):
                            case $user->hasRole('admin'):
                                $labels = [
                                    'adm' => 'ADMIN',
                                ];
                                break;
                            case $user->hasRole('manager'):
                            case $user->hasRole('employee'):
                                $labels = [
                                    'mar' => 'MARKETING',
                                ];
                                break;
                            default:
                                $labels = [];
                                break;
                        }
                    }

                    return $labels;
                })
                ->panels(function () {
                    $panels = ['adm', 'mar'];
                    if (auth()->check()) {
                        $user = auth()->user();
                        switch ($user) {
                            case $user->hasRole('sysadmin'):
                            case $user->hasRole('admin'):
                                $panels = ['adm'];
                                break;
                            case $user->hasRole('manager'):
                            case $user->hasRole('employee'):
                                $panels = ['mar'];
                                break;
                            default:
                                $panels = ['app'];
                                break;
                        }
                    }

                    return $panels;
                });
        });
    }
}
