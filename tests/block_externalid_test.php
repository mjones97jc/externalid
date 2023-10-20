<?php
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
 * Tests profile field retrieval from the database.
 *
 * @package     block_externalid
 * @copyright   2023 Matthew Jones <matthewj@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_externalid;

defined('MOODLE_INTERNAL') || die();
class block_externalid_test extends \advanced_testcase {
    public function test_retrieve_profile_field() {
        global $DB;

        $this->assertEquals('ABC123', json_encode($DB->get_record('user_info_data', ['userid' => 1]['data'])));
    }
}