<?php
require_once($CFG->dirroot . '/user/profile/lib.php');
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Block externalid is defined here.
 *
 * @package     block_externalid
 * @copyright   2023 Matthew Jones <matthewj@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_externalid extends block_base
{
    /**
     * Initializes class member variables.
     */
    public function init()
    {
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_externalid');
    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content()
    {
        global $COURSE, $USER, $DB;
        $text = '';
        $context = context_course::instance($COURSE->id);

        if (!empty($this->config->roles)) {
            $userrolestr = array();
            $userroles = get_user_roles($context, $USER->id);
            foreach ($userroles as $role) {
                $userrolestr[] = strtolower(role_get_name($role, $context));
            }
            $configroles = explode(',', $this->config->roles);

            if (!array_intersect($configroles, $userrolestr)) {
                return null;
            }
        }

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        if (!empty($this->config->text)) {
            $this->content->text = $this->config->text;
        } else {
            profile_load_data($USER);
            $text .= $USER->profile_field_external_id;
        }

        // $text .= '<form action="" method="POST">
        // <input type="submit" name="show" value="show">
        // </form>';

        $this->content->text = $text;

        return $this->content;
    }

    /**
     * Defines configuration data.
     *
     * The function is called immediately after init().
     */
    public function specialization()
    {
        global $USER;

        // Load user defined title and make sure it's never empty.
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_externalid');
        } else {
            $this->title = $this->config->title;
        }

        // if (isset($_POST['show'])) {
        //     profile_load_data($USER);

        //     $user = clone ($USER);

        //     $user->profile_field_show_id = !$user->profile_field_show_id;
        //     profile_save_data($user);
        // }

        // if (isset($_POST['hide'])) {
        //     $this->show = false;
        // }
    }

    /**
     * Allow multiple instances in a single course?
     *
     * @return bool True if multiple instances are allowed, false otherwise.
     */
    public function instance_allow_multiple()
    {
        return true;
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    public function has_config()
    {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    public function applicable_formats()
    {
        return array(
            'course-view' => true,
        );
    }

    function _self_test()
    {
        return true;
    }
}