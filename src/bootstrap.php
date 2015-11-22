<?php
/**
 * @link https://github.com/bitrix-expert/tools
 * @copyright Copyright © 2015 Nik Samokhvalov
 * @license MIT
 */

$manager = \Bitrix\Main\EventManager::getInstance();

$manager->addEventHandler('main', 'OnBeforeChangeFile', array('\Bex\Niceaccess\FileAccessManager', 'onBeforeChangeFile'));