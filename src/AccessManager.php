<?php
/**
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Bex\Niceaccess;

use Bex\Tools\Group\GroupTools;

/**
 * Implements methods of checking access of current user. 
 * 
 * Example: 
 * ```
 * use Bex\Niceaccess\AccessManager;
 * $result = AccessManager::getInstance()->inGroup('group_code');
 * ```
 */
class AccessManager
{
    /**
     * @var static access manager instance
     */
    protected static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Get access manager instance.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (empty(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Check current user entry in group by code.
     *
     * @param string $code Group's code.
     *
     * @return bool
     */
    public function inGroup($code)
    {
        $groupId = GroupTools::find($code, true)->id();

        if ((int) $groupId > 0) {
            global $USER;
            return in_array($groupId, $USER->GetUserGroupArray());
        }

        return false;
    }
}
