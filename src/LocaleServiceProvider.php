<?php

namespace Klisl\Locale;

use App\Providers\RouteServiceProvider;
use Route;



class LocaleServiceProvider extends RouteServiceProvider
{


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


		//Указываем, что файлы из папки config должны быть опубликованы при установке
        $this->publishes([__DIR__ . '/../config/' => config_path() . '/']);

		//Публикуем шаблон для переключения языков (файл resources\views\locales\locale.blade.php)
		$this->publishes([__DIR__ . '/../views/' => resource_path() . '/views/locales/']);

    }


}