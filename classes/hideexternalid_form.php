<?php
require_once("$CFG->libdir/formslib.php");
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
 * Creates the button used to hide the external ID.
 *
 * @package     block_externalid
 * @copyright   2023 Matthew Jones <matthewj@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class hideexternalid_form extends moodleform {
    function definition() {
        global $CFG, $COURSE;

        $mform =& $this->_form;

        $mform->addElement("hidden", "id", $COURSE->id);
        $mform->setType('id', PARAM_RAW);
        $mform->addElement("hidden", "hideexternalid", 1);
        $mform->setType('hideexternalid', PARAM_INT);
        $mform->addElement('submit', 'hide', get_string('hideexternalid', 'block_externalid'), 2);
    }
}