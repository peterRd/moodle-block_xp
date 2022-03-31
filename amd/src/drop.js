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

import Notification from 'core/notification';
import Ajax from 'core/ajax';
import {get_string} from 'core/str';

/**
 * @module     theme_boost/boost
 * @copyright  2022 Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Initialise the click handler
 * @param {HTMLElement} element The corresponding html element
 */
export const init = (element) => {
    element.on('click', (e) => {
        e.preventDefault();
        var calls = [
            {
                methodname: 'block_xp_drop_found',
                args: {
                    secret: e.currentTarget.dataset.secret,
                    course: e.currentTarget.dataset.courseid
                }
            }
        ];

        return Ajax.call(calls)[0].then((result) =>  {
            if (result.acquired) {
                element.hide();
                get_string('dropfoundheader', 'block_xp').then((test) => {
                    Notification.alert(test, result.message);
                });
            }
        });
    });
};
