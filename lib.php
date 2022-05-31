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
 * Local Library file for additional Functions
 *
 * @package    local_leeloolxpsrm
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @author     Leeloo LXP <info@leeloolxp.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Fetch and Update Configration From L
 */
function local_leeloolxpsrm_updateset() {

    global $CFG;

    @$addsrmpage = get_config('local_leeloolxpsrm')->addsrmpage;

    if ($addsrmpage == 1) {
        $fs = get_file_storage();
        $files = $fs->get_area_files(1, 'local_staticpage', 'documents');

        $filenames = array();

        foreach ($files as $f) {
            $filenames[] = $f->get_filename();
        }

        if (!in_array('leeloolxp-smart-dashboard.html', $filenames)) {
            $filename = $CFG->dirroot . '/local/leeloolxpsrm/html/leeloolxp-smart-dashboard.html';
            $filerecord = array(
                'contextid' => 1,
                'component' => 'local_staticpage',
                'filearea' => 'documents',
                'itemid' => 0,
                'filepath' => '/',
                'filename' => 'leeloolxp-smart-dashboard.html',
            );
            $file = $fs->create_file_from_pathname($filerecord, $filename);
        }

        $addmenudash = PHP_EOL .
            'Leeloo LXP Dashboard|/local/staticpage/view.php?page=leeloolxp-smart-dashboard||||||fa-leeloo|leeloossourl|';

        $existinglinks = get_config('local_boostnavigation')->insertcustomnodesusers;

        if (strpos($existinglinks, 'leeloolxp-smart-dashboard') === false) {
            set_config('insertcustomnodesusers', $existinglinks . $addmenudash, 'local_boostnavigation');
        }
    } else {
        $fs = get_file_storage();

        $fileinfo = array(
            'component' => 'local_staticpage',
            'filearea' => 'documents',
            'itemid' => 0,
            'contextid' => 1,
            'filepath' => '/',
            'filename' => 'leeloolxp-smart-dashboard.html'
        );

        // Get file.
        $file = $fs->get_file(
            $fileinfo['contextid'],
            $fileinfo['component'],
            $fileinfo['filearea'],
            $fileinfo['itemid'],
            $fileinfo['filepath'],
            $fileinfo['filename']
        );

        // Delete it if it exists.
        if ($file) {
            $file->delete();
        }

        $existinglinks = get_config('local_boostnavigation')->insertcustomnodesusers;
        $listext = explode(PHP_EOL, $existinglinks);
        $newlist = array();

        foreach ($listext as $existmen) {
            if (strpos($existmen, 'leeloolxp-smart-dashboard') === false) {
                $newlist[] = $existmen;
            }
        }

        $newliststr = implode(PHP_EOL, $newlist);

        set_config('insertcustomnodesusers', $newliststr, 'local_boostnavigation');
    }

    return;
}

/**
 * Add Leeloo Icon by js
 */
function local_leeloolxpsrm_before_footer() {
    global $PAGE;
    $PAGE->requires->js(new moodle_url('/local/leeloolxpsrm/js/custom.js'));
}
