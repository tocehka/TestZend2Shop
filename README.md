Тестовое задание, выполненное с помощью фреймворка Zend 2.

Routing: 
main: localhost страница вывода товаров без вывода товаров
admin: localhost/admin/ - обязательно необходимо поставить / в конце
Необходимая часть localhost/admin/items - админ панель для поиска и манипуляции товарами, так же реализована возможность чтения из excel файла определенного формата.

Единственная недоработка на данный момент - при использовании панели поиска без указания даты, появляется ошибка.
Поэтому пришлось закомментировать эти элементы формы в Admin/Form/SearchForm.