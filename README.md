README
======

![license](https://img.shields.io/packagist/l/bafs/via.svg?style=flat-square)
![PHP 5.5+](https://img.shields.io/badge/PHP-5.5+-brightgreen.svg?style=flat-square)

What is Aranea?
-----------------

Aranea is a PHP web client. All based on curl.

Installation
------------

The best way to install is to use the composer by command:

    composer require newclass/aranea
    composer install

Use example
-------------
    use Aranea\Client;
    
    $client=new Client();
    
    $response=$client->requestGet('http://google.com');
    