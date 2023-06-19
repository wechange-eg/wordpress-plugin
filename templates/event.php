<?php

/**
 * This template can be overwritten by copying this file in your theme. 
 * Needs to be placed in wp-content/themes/your-theme/wechange/
 */

$event = $data->event;

$note      = $event->note; // already escaped by markdown parser
$from_date = $event->from_date;
$to_date   = $event->to_date;
$title     = $event->title;
$image     = $event->image;

$time_format = get_option('date_format') . ' ' . get_option('time_format');

?>

<article>
    <h3><?= esc_html( $title ) ?></h3>
    <div><?= wp_date( $time_format, strtotime( $from_date ) ) ?></div>
    <div><?= $text ?></div>
</article>
