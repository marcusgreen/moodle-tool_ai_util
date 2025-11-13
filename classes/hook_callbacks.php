<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Hook callbacks for tool_ai_util
 *
 * @package    tool_ai_util
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_ai_util;

use local_ai_manager\hook\userinfo_extend;
use local_ai_manager\userinfo;
/**
 * Hook callbacks for tool_ai_util plugin
 */
class hook_callbacks {

    /**
     * Handle userinfo_extend hook to assign extended role by default
     *
     * @param userinfo_extend $userinfoextend The hook event
     * @return void
     */
    public static function handle_userinfo_extend(userinfo_extend $userinfoextend): void {
        global $DB;

        // Get the idmteacher role
        $teacherrole = $DB->get_record('role', ['shortname' => 'editingteacher']);
        $userid = $userinfoextend->get_userid();
        $user = \core_user::get_user($userid);

        // If user has no institution, return early
        if (empty($user->institution)) {
            return;
        }

        try {
            // Check if user has management capabilities in local_ai_manager
            if (has_capability('local/ai_manager:manage', \context_coursecat::instance($school->get_school_categoryid()), $userid)
                    || has_capability('local/ai_manager:managetenants', \context_system::instance(), $user)) {
                $userinfoextend->set_default_role(userinfo::ROLE_UNLIMITED);
                return;
            }
        } catch (Exception $e) {
            // If there's an error getting school category, continue with other checks
        }

        // Check if user has idmteacher role assignment
        if ($teacherrole && user_has_role_assignment($userid, $teacherrole->id, \context_system::instance()->id)) {
            $userinfoextend->set_default_role(userinfo::ROLE_EXTENDED);
        } else {
            // Default to basic role if no other conditions are met
            $userinfoextend->set_default_role(userinfo::ROLE_BASIC);
        }
    }
}