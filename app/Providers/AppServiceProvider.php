<?php

namespace App\Providers;
use App\Services\SmsService;
use Illuminate\Pagination\Paginator;// Thư viện phân trang của Laravel
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    //    $this->app->singleton(SmsService::class, function () {
    //     return new SmsService();
    //     });
        // Đăng ký dịch vụ SMS nhưng chưa thực hiện
     
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // \Illuminate\Pagination\Paginator::useBootstrapFive();
        // Chỉ sử dụng Bootstrap cho Paginator -PHÂN TRANG
        Paginator::useBootstrap();
    }
}
