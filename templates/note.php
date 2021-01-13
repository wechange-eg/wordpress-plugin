<?php

/**
 * This template can be overwritten by copying this file in your theme. 
 * Needs to be placed in wp-content/themes/your-theme/wechange/
 */

$note = $data->note;

$text  = $note->text; // already escaped by markdown parser
$time  = $note->timestamp;
$title = $note->title;

?>

<article>
    <h3><?= esc_html( $title ) ?></h3>
    <div><?= human_time_diff( strtotime( $time ) ) ?></div>
    <div><?= $text ?></div>
</article>
