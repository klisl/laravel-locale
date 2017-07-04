<?php

namespace Klisl\Locale;

use Illuminate\Support\ServiceProvider;
use Route;
use Klisl\Locale\LocaleMiddleware;


class LocaleServiceProvider extends ServiceProvider
{

	
    public function boot()
    {

		//создаем префикс для всех маршрутов и устанавливаем посредника
		Route::prefix(LocaleMiddleware::getLocale())
			->middleware(LocaleMiddleware::class)
			->group(base_path('routes/web.php'));
		
		
		// Загружаем свой файл маршрутов после загрузки сервисов
        if (! $this->app->routesAreCached()) {
            include __DIR__ . '/../routes/route.php';
        }
		
		//Указываем, что файлы из папки config должны быть опубликованы при установке
        $this->publishes([__DIR__ . '/../config/' => config_path() . '/']);
		
		//Публикуем шаблон для переключения языков (файл resources\views\locales\locale.blade.php)
		$this->publishes([__DIR__ . '/../views/' => resource_path() . '/views/locales/']);

    }

	
    public function register()
    {
		
	}

}
