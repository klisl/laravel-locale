laravel-locale
=================
[![Laravel 5](https://img.shields.io/badge/Laravel-5-orange.svg?style=flat-square)](http://laravel.com)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

Пакет для создания мультиязычного сайта на фреймворке Laravel-5. Текущий язык отображается в URL (кроме основного языка):
  * http://laravel.loc
  * http://laravel.loc/en
  * http://laravel.loc/uk


Смена языка осуществляется при нажатии на соответствующие ссылки. Так же, язык можно менять прямо в адресной строке.
Не используются сессии и куки. Простой код, рассчитанный на максимальное быстродействие.

Данный пакет устанавливает текущую локализацию приложения в зависимости от выбранного вами языка. Соответственно используются языковые файлы относящиеся к данной локализации.

  
Установка
------------------
Установка пакета с помощью Composer.

```
composer require klisl/laravel-locale
```

Если версия Laravel меньше чем 5.5 - добавьте в файл `config/app.php` вашего проекта в конец массива `providers` :

```php
Klisl\Locale\LocaleServiceProvider::class,
```
Для версии >=5.5 данный шаг пропустить.

После этого выполните в консоли команду публикации нужных ресурсов:

```
php artisan vendor:publish --provider="Klisl\Locale\LocaleServiceProvider"
```


Использование
-------------

В файле конфигурации `config\languages.php` нужно указать основной язык, идентификатор которого не должен выводиться в URL, а так же языки, которые вы планируете использовать. 
По-умолчанию основной язык - русский, а перечень используемых языков состоит из русского, украинского и английского.


Для отображения ссылок на переключение языка, вставьте в нужный шаблон строку
```
@include('locales.locale')
```

Это подключит шаблон `resources\views\locales\locale.blade.php`, внешний вид которого вы можете настроить под дизайн вашего приложения.



Создание ссылок на другие страницы вашего сайта
-------------

1 вариант . Используем функцию route() как-обычно:
```php
<a href="{{ route('home') }}">Home</a>
```

2 вариант. Указываем URI непосредственно в атрибуте href. Тут в начале нужно вызвать статический метод getLocale() класса LocaleMiddleware: 
```php
<a href="{{ Klisl\Locale\LocaleMiddleware::getLocale() .'/home' }}">Home</a>
```


Мой блог: [klisl.com](https://klisl.com)  
