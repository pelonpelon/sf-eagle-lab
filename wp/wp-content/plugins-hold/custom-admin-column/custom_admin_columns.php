<?php

/*
  Plugin Name: Custom Admin Columns
  Plugin URI: http://www.bunchacode.com/programming/custom-admin-columns/
  Description: allows user to add additional columns to admin posts, pages and custom post type page.
  Version: 1.3
  Author: Jiong Ye
  Author URI: http://www.bunchacode.com
  License: GPL2
 */
/*  Copyright 2011  Jiong Ye  (email : dexxaye@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
?>
<?php

define('CAC_VERSION', '1.2');
define('CAC_DIR', WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'custom_admin_columns' . DIRECTORY_SEPARATOR);

$defaultColumns = array(
    'ID' => 'ID',
    'thumbnail' => 'Featured Image',
 //   'slug' => 'Permalink',
 //   'comment_status' => 'Comment Status',
 //   'ping_status' => 'Ping Status',
    'modified_date' => 'Last Modified',
 //   'comment_count' => 'Comment Count'
);

function cac_admin_init() {
    wp_enqueue_style('custom_admin_columns.css', plugins_url('custom_admin_columns.css', __FILE__));
}

add_action('admin_init', 'cac_admin_init');

/*
 * filter Pages columns
 */

function cac_page_column_filter($columns) {
    global $defaultColumns;

    $defaultColumns['parent'] = 'Parent';
    $defaultColumns['children'] = 'Children';
    return array_merge($columns, $defaultColumns);
}

add_filter('manage_pages_columns', 'cac_page_column_filter');

/*
 * filter Posts page and custom post type columns
 */

function cac_other_column_filter($columns, $type) {
    global $defaultColumns;
    if ( $type == 'event' ) { $columns = $columns + array('event date' => 'Event Date'); }
    if ( $type == 'event' ) { $defaultColumns = $defaultColumns + array('author' => 'Author'); }

    switch ($type) {
        case 'post':
            break;
        default:
            break;
    }

    return array_merge($columns, $defaultColumns);
}

add_filter('manage_posts_columns', 'cac_other_column_filter', 10, 2);

/*
 * Filter Media page columns
 */

function cac_media_column_filter($columns) {
    $columns['ID'] = 'ID';
    $columns['title'] = 'Title';
    $columns['alt'] = 'Alternative Text';
    //$columns['caption'] = 'Captions';
    //$columns['description'] = 'Description';
   // $columns['slug'] = 'Permalink';
    $columns['file'] = 'File URL';
    return $columns;
}

add_filter('manage_media_columns', 'cac_media_column_filter');

/*
 * output column value
 */

function cac_column_value($name, $id) {
    switch ($name) {
        case 'event date':
            $p = get_post($id);
            if ( $p->post_type !== 'event' ) { break; }
            $date = get_post_meta($id, 'date', true);
            $start = get_post_meta($id, 'time', true);
            $finish = get_post_meta($id, 'endtime', true);
            $begintime = strtotime($date . " " . $start);
            echo date('D, M j', $begintime );
            echo "<br />" . $start . " -  " . $finish;
            break;
        
        case 'author':
            $p = get_post($id);
            echo $p->post_author;
            break;

        case 'ID':
            echo $id;
            break;

/*          case 'slug':
            $permalink = get_permalink($id);
            echo '<a href="' . $permalink . '" target="_blank">' . $permalink . '</a>';
            break;
 */
        case 'thumbnail':
            if (function_exists('get_the_post_thumbnail'))
                echo get_the_post_thumbnail($id, array(75, 75));
            break;
        case 'parent':
            $p = get_post($id);
            $p = get_post($p->post_parent);
            if(!empty($p))
                echo '<a href="'.get_permalink($p->ID).'">'.$p->post_title.'</a>';
            break;
        case 'children':
            echo '<ul>' . wp_list_pages(array(
                'title_li' => '',
                'child_of' => $id,
                'echo' => false,
                'depth' => 1
            )) . '</ul>';
            break;
        case 'file':
            $fileURL = wp_get_attachment_url($id);
            echo '<a href="' . $fileURL . '" target="_blank">' . $fileURL . '</a>';
            break;
        case 'alt':
            echo get_post_meta($id, '_wp_attachment_image_alt', true);
        case 'caption':
        case 'description':
            $media = get_post($id);

            if ($name == 'caption')
                echo $media->post_excerpt;
            else
                echo $media->post_content;

            break;
/*        case 'comment_status':
            $p = get_post($id);
            echo $p->comment_status;
            break;
 */
          case 'ping_status':
            $p = get_post($id);
            echo $p->ping_status;
            break;
 
        case 'modified_date':
            $p = get_post($id);
            echo date('M j, Y g:i a', strtotime($p->post_modified));
            break;
/*        case 'comment_count':
            $counts = get_comment_count($id);

            echo 'Approved: ' . $counts['approved'] . '<br />' .
            'Awaiting Moderation: ' . $counts['awaiting_moderation'] . '<br />' .
            'Spam: ' . $counts['spam'] . '<br />' .
            'Total: ' . $counts['total_comments'];
            break;*/
        default:
            break;
    }
}

add_action('manage_posts_custom_column', 'cac_column_value', 10, 2);
add_action('manage_pages_custom_column', 'cac_column_value', 10, 2);
add_action('manage_media_custom_column', 'cac_column_value', 10, 2);
?>
