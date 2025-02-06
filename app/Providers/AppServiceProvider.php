<?php
namespace App\Providers;

use BezhanSalleh\PanelSwitch\PanelSwitch;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->simple()
                ->iconSize(16)
                ->visible(fn(): bool => auth()->user()->hasAnyRole([
                    'sysadmin',
                    'admin',
                    'manager',
                    'employee',
                ]))
                ->panels(function () {
                    $panels = [];
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
                                $panels = [];
                                break;
                        }
                    }

                    return $panels;
                })
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
                });
        });
    }
}
