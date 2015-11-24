# Niceaccess

[![Build Status](https://travis-ci.org/bitrix-expert/niceaccess.svg)](https://travis-ci.org/bitrix-expert/niceaccess)
[![Latest Stable Version](https://poser.pugx.org/bitrix-expert/niceaccess/v/stable)](https://packagist.org/packages/bitrix-expert/niceaccess) 
[![Total Downloads](https://poser.pugx.org/bitrix-expert/niceaccess/downloads)](https://packagist.org/packages/bitrix-expert/niceaccess) 
[![License](https://poser.pugx.org/bitrix-expert/niceaccess/license)](https://packagist.org/packages/bitrix-expert/niceaccess)

Поддержка файлов с правами доступа (`.access.php`) в пригодном для мигрирования на несколько площадок состоянии. 
Библиотека будет пересохранять файлы `.access.php`, заменяя в них идентификаторы групп пользователей на метод 
`\Bex\Tools\GroupTools::find('code')->id()`, возвращающий идентификатор по символьному коду группы. Это позволит версионировать 
файлы `.access.php` и использовать их с любой БД, даже если идентификаторы групп пользователей различаются.

Кроме того, модуль запрещает сохранять группы пользователей без символьных кодов.

## Установка

Установите Композер. Добавьте модуль в `composer.json`:

```
cd path/to/project/root
composer require bitrix-expert/niceaccess
```

## Требования

* PHP >= 5.3
* Bitrix CMS >= 15.0.2