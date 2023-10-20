# externalid

Block plugin to display the user's custom profile field, "external_id". If the field does not exist on install, the plugin will instead display "ABC123" until the field is updated by the user.

## Installing via uploaded ZIP file

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/blocks/externalid

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## Testing

The plugin works entirely as requested in the provided dev-test-instructions-v1.md file. After installation, simply create a new course and add the block plugin. Any changes made to the block's ID or its visibility will be reflected in the database and vice versa. NOTE, for role restriction, input is only accepted if each role is separated by a comma and written as they appear in the database (i.e. teacher,student,coursecreator).

## License

2023 Matthew Jones <mjones97jc@gmail.com>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program. If not, see <https://www.gnu.org/licenses/>.
