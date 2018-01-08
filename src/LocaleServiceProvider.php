<?php

namespace Klisl\Locale;

use App\Providers\RouteServiceProvider;
use Route;
use Config;

/**
 * Class LocaleServiceProvider
 * @author Sergey <ksl80@ukr.net>
 * @package Klisl\Locale
 */
class LocaleServiceProvider extends RouteServiceProvider
{

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();

        /*
         * Cоздаем префикс для всех маршрутов и устанавливаем посредника
         * Для корректной работы префикса, класс наследуется от RouteServiceProvider
         */

        Route::prefix(LocaleMiddleware::getLocale())
            ->middleware(LocaleMiddleware::class, 'web')
            ->namespace('App\Http\Controllers')
            ->group(base_path('routes/web.php'));

        //Загружаем свой файл маршрутов после загрузки сервисов
        if (!$this->app->routesAreCached()) {
            include __DIR__ . '/../routes/route.php';
        }


        $language = LocaleMiddleware::getLocale();
        if($language) Config::set('app.locale', $language);


        $this->publishes([__DIR__ . '/../config/' => config_path() . '/']);
        $this->publishes([__DIR__ . '/../views/' => resource_path() . '/views/locales/']);

    }

}