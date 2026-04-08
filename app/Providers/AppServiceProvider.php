<?php

namespace App\Providers;

use App\Models\ContactInquiry;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Use Bootstrap 4 for pagination (AdminLTE compatibility)
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            try {
                $settings = Setting::allAsArray();
                $newInquiriesCount = ContactInquiry::where('status', 'new')->count();
            } catch (\Exception $e) {
                $settings = [];
                $newInquiriesCount = 0;
            }

            $view->with('settings', $settings);
            $view->with('newInquiriesCount', $newInquiriesCount);
        });
    }
}
