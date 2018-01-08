<?php
namespace Klisl\Locale;

use Closure;
use App;
use Request;

/**
 * Class LocaleMiddleware
 * @package Klisl\Locale
 */
class LocaleMiddleware
{

    /**
     * Проверяет наличие корректной метки языка в текущем URL
     *
     * @return string|null
     */
    public static function getLocale()
    {
        $uri = Request::path(); //получаем URI

        $segmentsURI = explode('/',$uri); //делим на части по разделителю "/"

        //Проверяем метку языка  - есть ли она среди доступных языков
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], config('languages')['languages'])) {
            if ($segmentsURI[0] != config('languages')['mainLanguage']) return $segmentsURI[0];
        }

        return null;
    }

    /**
     * Устанавливает язык приложения в зависимости от метки языка из URL
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //Убираем дубли из URI (public и public/index.php)
        if (preg_match("/^\/(public)|(public\/index.php)/",$request->getBaseUrl()) ) {

            $newUrl = str_replace($request->getBaseUrl(), '', $request->getUri());
            header('Location: '.$newUrl, true, 301);
            exit();

        }


        $locale = self::getLocale();

        if($locale) App::setLocale($locale);

        else App::setLocale(config('languages')['mainLanguage']);

        return $next($request);
    }

}