<?php
require_once($CFG->dirroot . '/user/profile/lib.php');
require($CFG->dirroot . '/blocks/externalid/classes/hideexternalid_form.php');
require($CFG->dirroot . '/blocks/externalid/classes/showexternalid_form.php');
// require('../classes/externalid_form.php');
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
        global $COURSE, $USER, $DB, $OUTPUT;
        $text = '';
        $context = context_course::instance($COURSE->id);
        $mformshow = new showexternalid_form();
        $mformhide = new hideexternalid_form();
        $formdatahide = $mformhide->get_data();
        $formdatashow = $mformshow->get_data();
        $hidepreference = $DB->get_record('externalid_visibility', ['userid' => $USER->id]);
        $hidepreference = json_decode(json_encode($hidepreference), true);

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

        } else if ($formdatahide) {
            $DB->update_record('externalid_visibility', ['id' => $hidepreference['id'], 'userid' => $USER->id, 'hide' => 1]);

            $text .= get_string('hiddenid', 'block_externalid');
            $text .= $mformshow->render();

        } else if ($formdatashow) {
            $DB->update_record('externalid_visibility', ['id' => $hidepreference['id'], 'userid' => $USER->id, 'hide' => 0]);

            profile_load_data($USER);

            $text .= $USER->profile_field_external_id;
            $text .= $mformhide->render();

        } else {
            if (!$hidepreference['hide']) {
                profile_load_data($USER);

                $text .= $USER->profile_field_external_id;
                $text .= $mformhide->render();

            } else {
                $text .= get_string('hiddenid', 'block_externalid');
                $text .= $mformshow->render();
            }
        }

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