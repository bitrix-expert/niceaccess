# Niceaccess

[![Build Status](https://travis-ci.org/bitrix-expert/niceaccess.svg)](https://travis-ci.org/bitrix-expert/niceaccess)
[![Latest Stable Version](https://poser.pugx.org/bitrix-expert/niceaccess/v/stable)](https://packagist.org/packages/bitrix-expert/niceaccess) 
[![Total Downloads](https://poser.pugx.org/bitrix-expert/niceaccess/downloads)](https://packagist.org/packages/bitrix-expert/niceaccess) 
[![License](https://poser.pugx.org/bitrix-expert/niceaccess/license)](https://packagist.org/packages/bitrix-expert/niceaccess)

## `.access.php`

Bitrix writes `.access.php` (files of access) the numerical group IDs of users, which prevents its migration from site 
to site where different databases (dev zone, test, production, etc.).

Niceaccess solves this problem by substitution of IDs to character codes user groups. The character code is recorded 
in the form of an API call Bex\Tools: `\Bex\Tools\GroupTools::find('code')->id()`. Because of this, your files 
`.access.php` will be relevant to with any database.

Example file `.access.php`:

```php
<?
$PERM["admin"][\Bex\Tools\Group\GroupTools::find('CONTROL_PANEL_USERS', true)->id()]="R";
$PERM["admin"]["*"]="D";
?>
```

## Tools for nice work with access rights

Class `\Bex\Niceaccess\AccessManager` implements API of checking access of current user.

## Installation

```
composer require bitrix-expert/niceaccess
```

## Requirements

* PHP >= 5.4
* Bitrix CMS >= 15.0.2