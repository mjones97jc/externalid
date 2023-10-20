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
 * Code to be executed after the plugin's database scheme has been installed is defined here.
 *
 * @package     block_externalid
 * @category    upgrade
 * @copyright   2023 Matthew Jones <matthewj@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Custom code to be run on installing the plugin.
 */
function xmldb_block_externalid_install() {
    global $DB;

    $sql = 'SELECT * FROM mdl_user_info_field WHERE shortname = ?';
    $usersids = $DB->get_records('user', [], fields: 'id');
    $usersidsarray = json_decode(json_encode($usersids), true);

    //If the external ID profiled field is not present in the database, create it.
    if (!$DB->record_exists_sql($sql, ['external_id'])) {
        $ins = (object) array(
            'shortname' => 'external_id',
            'name' => 'External ID',
            'datatype' => 'text',
            'descriptionformat' => 1,
            'categoryid' => 1,
            // 'sortorder' => 3,
            'visible' => 2,
            'param1' => 30,
            'param2' => 2048,
            'param3' => 0
        );

        $fieldid = $DB->insert_record('user_info_field', $ins);

        //Populate the external ID profile field with 'ABC123' for each and every current user.
        foreach ($usersidsarray as $index => $id) {
            $ins = (object) array(
                'userid' => (int) $id['id'],
                'fieldid' => $fieldid,
                'data' => 'ABC123',
                'dataformat' => 0,
            );
            $DB->insert_record('user_info_data', $ins);

        }
    }

    //Populated the external_visibility table for hiding or showing the external ID.
    foreach ($usersidsarray as $index => $id) {
        $ins = (object) array(
            'userid' => (int) $id['id']
        );
        $DB->insert_record('externalid_visibility', $ins);

    }

    return true;
}