# Meta Templates Laravel
Laravel 8+  
PHP 7.4+  

## Установка ##
1. В файле app.php, в секцию packages добавить:
   ``\PyrobyteWeb\MetaTemplates\MetaTemplatesServiceProvider::class``  
2. ``php artisan vendor:publish --provider="PyrobyteWeb\MetaTemplates\MetaTemplatesServiceProvider"``
3. Добавить мидлвару в Http/Kernel.php ``MetaTemplateMiddleware::class``  

## Принцип работы ## 
Есть общие плейсхолдеры, которые Вы можете добавлять сами. Есть плейсхолдеры, которые используются для конкретной страницы, которые ориентируются на наименование роутинга. Все плейсхолдеры называем через #. Например, ``#year#``.  
## Использованание ##  
### Добавление нового меташаблона для всего роута ###
Для добавления нового типа меташаблона необходимо запустить команду ``php artisan meta-template:add name_meta_template``. Будет создана миграция для добавления меташаблона в базу и создан файл в директории app/MetaTemplates.  
### Добавления новых плейсхолдеров ###  
Запускаем команду ``php artisan meta-template:placeholders PlaceHolderClassName``  

## Пример использования ##  
### Создания для своего роута ###
Создадим меташаблон для тестовой страницы.  
1. Запустим команду для создания меташаблона в БД ``php artisan meta-template:add meta_template_for_testing_page``.  
У нас появится миграция и будет создан файл для описания меташаблона. 
2. Опишим миграцию для создания меташаблона в БД. В примере будет описано только св-во, в которое следует добавлять   
````
private $metaTemplates = [
    [
        'name' => 'test page',
        'route_name' => 'test-route-another',
        'active' => 1,
        'meta_title' => 'test title - #year# #custom_placeholder#',
        'meta_keywords' => 'test - #moth#',
        'meta_description' => 'test - #time#',
    ],
];
````
3. Опишим наш ``#custom_placeholder#`` в созданном классе, что именно будем там выводить. Например,  
````
public function getPlaceholders(): array
{
    return [
        'custom_placeholder' => 'мой кастомный плейсхолдер',
    ];
}
````
4. Перейдем на тестовую страницу и вызовем наш меташаблон ``app('meta)->getTitle()`` и будет выведено следущее ``test title - 2022 мой кастомный плейсхолдер``.  
### Создание плейсхолдеров(общих) ###
1. Запустим команду для создания меташаблона в БД ``php artisan meta-template:placeholders CommonMetaTemplate``.  
   У нас появится файл для описания меташаблона.
2. Опишим наш ``#common_placeholder#`` в созданном классе, что именно будем там выводить. Например,
````
public function getPlaceholders(): array
{
    return [
        'common_placeholder' => 'мой кастомный плейсхолдер',
    ];
}
````
3. Добавим наш класс ``CommonMetaTemplate::class`` в конфиг файл ``config/meta-templates.php`` в секцию ``commod``. 
4. Теперь мы можем использовать наш плейсхолдер в любом меташаблоне и не описывать его каждый раз под конкретную страницу.
