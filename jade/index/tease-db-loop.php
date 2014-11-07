<?php
global $post; // required

// scheduled event in tease
$args = array(
'meta_key'      => 'date',
'orderby'       => 'meta_value',
'order'         => 'ASC',
'post_type'     => 'event',
'numberposts'   => -1
);
$custom_posts = get_posts($args);
foreach($custom_posts as $post)
{
    setup_postdata($post);
    if ( $post->post_status == "draft" ) { continue; }
    if ( $post->post_status == "private" ) { continue; }
    if ( $post->post_status == "archived" ) { continue; }
    if ( get_field('tease') )
    {
        include 'includes/timegames.php';
        if ( $begintime > ($now + 60*60*24*7) || ($now + 60*60*2) > $endtime ) { continue; } ?>

        <section class="event" style="display: block;"> <?php
        if ( get_field('lead') )
        { ?>
          <div class="lead"><?php echo (get_field('lead')); ?> </div> <?php
        } ?>
          <div class="post-content">  
<?php
        if ( get_field('include_title') )
        { ?>
          <h2> <?php echo $post->post_title; ?> </h2> <?php
        }
        fill_tease($post, "scheduled");
        ?>
          </div>
        </section>
        <?php
        break;
    }
}

// additional event if checked in admin screen
$category_id = get_cat_ID('Add to main content section');
$args = array(
    'category'      => $category_id,
    'orderby'       => 'post_date',
    'order'         => 'DESC',
    'post_type'     => 'post',
    'post_status'   => 'publish',
    'numberposts'   => -1
);
$posts = get_posts($args);
foreach($posts as $post)
{
    setup_postdata($post);
    if ( $post->post_status == "draft" ) { continue; }
    if ( $post->post_status == "private" ) { continue; }
    if ( $post->post_status == "archived" ) { continue; }
    include 'includes/timegames.php'; ?>

    <hr>
      <section class="tease_now custom" style="display: block;">
        <div class="post-content">
          <?php fill_tease($post, "custom"); ?>
        </div>
      </section>
<?php }

/**
 * fill the center of the top of the home page with
 * a drink special or an announcement w/ images
 * @param  obj $post
 * @return null
 */
function fill_tease($post, $kind)
{
  if ( has_category( "print-post-title", $post ) ) { ?>

      <h2> <?php the_title(); ?> </h2> <?php

  }
  if (has_post_thumbnail( $post->ID )) {
    $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
    $image_medium = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
    $image_full = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); ?>

    <div>
      <a href="<?php the_field('link'); ?>" target="_blank">
        <img src="<?php echo $image_large[0] ?>"
             width="<?php echo $image_large[1]; ?>"
             height="<?php echo $image_large[2]; ?>"
             alt="<?php get_the_title($post->ID); ?>" >
      </a>
    </div><?php

  }
  if($post->post_content != "") {

      the_content();

  }
  if (the_field('blurb') != "") { ?>

  <p><?php the_field('blurb'); ?> </p> <?php

  }
} ?>
