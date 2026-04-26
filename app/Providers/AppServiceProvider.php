<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // ဒီ ၄ ကြောင်းကို ကူးထည့်ပေးပါ
    if (config('app.env') === 'production') {
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }
    
    // View တွေ cache လုပ်ဖို့ /tmp ကို သုံးခိုင်းတာ
    $viewPath = '/tmp/views';
    if (!is_dir($viewPath)) {
        mkdir($viewPath, 0777, true);
    }
    config(['view.compiled' => $viewPath]);
    }
}
