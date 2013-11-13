ExchangeTester
================

Компонент для тестирования обмена данными 1С и интернет магазина

[Описание взаимодействия](http://v8.1c.ru/edi/edi_stnd/131/ "Описание взаимодействия")

Требования
------------
1. php 5.3
2. расширение curl

Подготовка
------------
1. создать файл data/data.zip, содержащий 2 файла - import.xml, offers.xml
2. создать файл конфигурации на основе config/config-example

Использование
------------
<pre><code>$ php test.php <config_name>
</code></pre>


Результат
------------
<pre><code>$ php test.php local
Test auth:
success
PHPSESSID
oglhr5tn4tq2hbvggh719b94p2

Test init:
zip=yes
file_limit=8388608

Test file:
success


Test import file:
success


Test offers file:
success
</code></pre>