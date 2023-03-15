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
 * View file for plugin
 *
 * @package    local_leeloolxpsrm
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @author     Leeloo LXP <info@leeloolxp.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
global $CFG, $DB, $USER, $PAGE;
$PAGE->set_pagelayout('base');
$SESSION->theme = 'leeloolxp_lb';
require_login();

require_once($CFG->libdir . '/filelib.php');

$PAGE->set_url('/local/leeloolxpsrm/index.php');

$PAGE->set_title('LeelooLXP LearnBoard');


echo $OUTPUT->header();
echo '<div id="leeloosocialdivsrm"></div>';

?>
<script>
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    var leeloolxpssourl = getCookie('leeloolxpssourl');
    if (leeloolxpssourl != '') {

        var url_string = window.location.href
        var url = new URL(url_string);
        var view = url.searchParams.get("view");
        if (view) {
            leeloolxpssourl = leeloolxpssourl + '&view=' + view;
        }

        leeloolxpssourl = leeloolxpssourl + '&view=23';

        document.getElementById("leeloosocialdivsrm").innerHTML = '<iframe src="' + leeloolxpssourl + '" class="leeloosocial"></iframe>';
    } else {
        window.location.href = "/login/index.php";
    }
</script>
<?php

echo $OUTPUT->footer();
