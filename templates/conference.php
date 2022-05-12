<?php

/**
 * This template can be overwritten by copying this file in your theme. 
 * Needs to be placed in wp-content/themes/your-theme/wechange/
 */

$conference = $data->conference;

$description  = $conference->description; // already escaped by markdown parser
$from_date    = $conference->from_date;
$to_date      = $conference->to_date;
$name         = $conference->name;
$url          = $conference->url;
$avatar       = $conference->avatar;
$managed_tags = $conference->managed_tags;

$time_format = get_option('date_format') . ' ' . get_option('time_format');

?>

<article>
    <h3><a href="<?= esc_url($url) ?>"><?= esc_html( $name ) ?></a></h3>
    <div><?= wp_date( $time_format, strtotime( $from_date ) ) ?></div>
    <div><?= $description ?></div>
</article>
