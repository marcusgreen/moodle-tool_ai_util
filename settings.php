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
 * Plugin settings
 *
 * @package    tool_ai_util
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add('root', new admin_category('tool_ai_util', new lang_string('pluginname', 'tool_ai_util')));
    
    $settings = new admin_settingpage('managetoolaiutil', new lang_string('pluginname', 'tool_ai_util'));
    
    if ($ADMIN->fulltree) {
        $settings->add(new admin_setting_heading(
            'tool_ai_util/general',
            new lang_string('general', 'tool_ai_util'),
            new lang_string('general_desc', 'tool_ai_util')
        ));
    }
    
    $ADMIN->add('tool_ai_util', $settings);
}