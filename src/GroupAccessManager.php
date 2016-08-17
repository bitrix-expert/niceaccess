<?php
/**
 * @link https://github.com/bitrix-expert/niceaccess
 * @copyright Copyright © 2015 Nik Samokhvalov
 * @license MIT
 */

namespace Bex\Niceaccess;

use Bex\Tools\Group\GroupTools;

/**
 * Class of access manager group
 * Implements method of checking current user entries in group by code
 *
 * Example:
 *  <?php
 *      use Bex\Niceaccess\GroupAccessManager;
 *      $result = GroupAccessManager::instance()->check('group_code');
 */
class GroupAccessManager
{
    /**
     * @var static access manager instance
     */
    protected static $instance;

    /**
     * @inheritdoc
     * @see GroupAccessManager::instance()
     */
    private function __construct()
    {
    }

    /**
     * @inheritdoc
     */
    private function __clone()
    {
    }

    /**
     * Get access manager instance
     * @return static
     */
    public static function instance()
    {
        if (empty(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Check current user entry in group by code
     * @param string $groupCode group's code
     * @return bool
     */
    public function check($groupCode)
    {
        $groupId = GroupTools::find($groupCode, true)->id();
        if ((int)$groupId > 0) {
            global $USER;
            return in_array($groupId, $USER->GetUserGroupArray());
        }

        return false;
    }
}

