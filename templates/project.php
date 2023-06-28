<?php 

/**
 * This template can be overwritten by copying this file in your theme. 
 * Needs to be placed in wp-content/themes/your-theme/wechange/
 */

$project = $data->project;

$name        = $project->name;
$description = wp_trim_words( $project->description, 55 );
$url         = 'https://' . $project->domain . '/project/' . $project->slug . '/';
$avatar      = $project->avatar;

?>

<article>

    <div class="image">
    <?php 
        if ( ! empty( $avatar ) ) :
    ?>
        <a href="<?php echo esc_url( $url ); ?>"
        class="entry-featured-image-url">
            <img src="<?php echo esc_url( $avatar ); ?>"
                alt="<?php echo esc_attr( $name ); ?>" width="400" height="250">
        </a>
    <?php
        else :
    ?>
    <br><br>

    <?php 
        endif; 
    ?>
    </div>
   
    <h2 class="entry-title">
        <a href="<?php echo esc_url( $url ); ?>">
            <?php echo esc_html( $name ); ?>
        </a>
    </h2>
    <div class="post-content">
        <p>
            <?php echo esc_html( $description ); ?>
        </p>
    </div>
</article>
