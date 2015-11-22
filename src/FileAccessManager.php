<?php
/**
 * @link https://github.com/bitrix-expert/tools
 * @copyright Copyright © 2015 Nik Samokhvalov
 * @license MIT
 */

namespace Bex\Niceaccess;

use Bex\Tools\GroupTools;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\IO\File;
use Bitrix\Main\IO\InvalidPathException;

/**
 * Implements replacement of user group id's by \Bex\Tools method which returns user group id by symbol code
 * in .access.php files. File .access.php will not depend on DB user group id after that
 *
 * @author Nik Samokhvalov <nik@samokhvalov.info>
 */
class FileAccessManager
{
    protected $path;
    protected $isFileAccess = false;

    /**
     * FileAccessManager constructor.
     * 
     * @param string $path Full path to file .access.php
     *
     * @throws InvalidPathException Invalid path to file.
     */
    public function __construct($path)
    {
        if (empty($path))
        {
            throw new InvalidPathException($path);
        }

        $this->path = $path;
        
        $file = new File($path);
        
        if ($file->getName() === '.access.php')
        {
            $this->isFileAccess = true;
        }
    }

    /**
     * Resave file .access.php, with usage symbol of the codes users groups instead id's
     *
     * @param string $content
     *
     * @return bool
     * @throws ArgumentNullException
     */
    public function convertContent(&$content)
    {
        if (!$this->isFileAccess)
        {
            return false;
        }
        elseif (empty($content))
        {
            throw new ArgumentNullException('content');
        }
        
        $content = preg_replace_callback('/(PERM\[.+\]\[)(\"G?[0-9]+\")(\])/', function ($matches) {
            $matches[2] = trim($matches[2], "\"");
            $groupId = str_replace('G', '', $matches[2], $addG);
            $groupCode = GroupTools::findById($groupId)->code();

            return $matches[1] . ($addG ? "'G'." : '') . "\Bex\Tools\Group\GroupTools::find('{$groupCode}')->id()" . $matches[3];
        }, $content);
        
        return true;
    }

    public static function onBeforeChangeFile($path, &$content)
    {
        $manager = new FileAccessManager($path);
        $manager->convertContent($content);

        return true;
    }
}