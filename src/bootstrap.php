<?php
/**
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) return false;

$manager = \Bitrix\Main\EventManager::getInstance();

$manager->addEventHandler('main', 'OnBeforeChangeFile', ['\Bex\Niceaccess\AccessFileHandler', 'onBeforeChangeFile']);
