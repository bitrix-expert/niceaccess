<?php
/**
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Bex\Niceaccess;

use Bex\Tools\Group\GroupTools;
use Bex\Tools\ValueNotFoundException;
use Bitrix\Main\IO\File;
use Bitrix\Main\IO\InvalidPathException;

/**
 * Implements replacement of user group id's by \Bex\Tools method which returns user group id by symbol code
 * in .access.php files. File .access.php will not depend on DB user group id after that.
 *
 * @author Nik Samokhvalov <nik@samokhvalov.info>
 */
class AccessFileHandler
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
        if (empty($path)) {
            throw new InvalidPathException($path);
        }

        $this->path = $path;

        $file = new File($path);

        if ($file->getName() === '.access.php') {
            $this->isFileAccess = true;
        }
    }

    /**
     * Converting content from .access.php file, with usage symbol of the codes users groups instead id's.
     *
     * @param string $content
     *
     * @return bool
     */
    public function convertContent(&$content)
    {
        if (!$this->isFileAccess) {
            return false;
        } elseif (empty($content)) {
            return false;
        }

        $content = preg_replace_callback('/(PERM\[.+\]\[)(\"G?[0-9]+\")(\])/', function ($matches) {
            $matches[2] = trim($matches[2], "\"");
            $groupId = str_replace('G', '', $matches[2], $addG);

            try {
                $groupCode = GroupTools::findById($groupId)->code();
            } catch (ValueNotFoundException $e) {
                return $matches[0];
            }

            $value = ($addG ? "'G'." : '') . '\Bex\Tools\Group\GroupTools::find(\'' . $groupCode . '\', true)->id()';

            return $matches[1] . $value . $matches[3];
        }, $content);

        return true;
    }

    public static function onBeforeChangeFile($path, &$content)
    {
        $manager = new AccessFileHandler($path);
        $manager->convertContent($content);

        return true;
    }
}