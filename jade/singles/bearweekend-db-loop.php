<?php
  global $post; // required

  // Bear Events
  $category_id = get_cat_ID('Add to Bear Events');
  $args = array(
      'category'      => $category_id,
      'orderby'       => 'post_date',
      'order'         => 'ASC',
      'post_type'     => 'post',
      'post_status'     => 'future, publish',
      'numberposts'   => -1
  );
  $posts = get_posts($args);
  foreach($posts as $post)
  {
    setup_postdata($post);
    if ( $post->post_status == "private" ) { continue; }
    if ( $post->post_status == "archived" ) { continue; }
    include 'includes/timegames.php';

    if ( has_category( "add-to-bear-events", $post) ) {?>
    <article class="event"> <?php
      fill_event($post); ?>
    </article> <?php
    }
  }

  /**
   * fill event block
   * @param  obj $post
   * @return null
   */
  function fill_event($post)
  {
    if ( has_category(! "do-not-print-date", $post ) ) {?>

      <div class="title">
        <?php echo get_the_date('l'); echo '<br />'; the_time('g:i a'); ?>
      </div> <?php
    }
    if (has_post_thumbnail( $post_id )) {
      $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>

      <div class="thumb">
        <a href="<?php echo $image_large[0] ?>" rel="lightbox">
          <img src="<?php echo $image_large[0] ?>"
               width="<?php echo $image_large[1]; ?>"
               height="<?php echo $image_large[2]; ?>"
               alt="<?php get_the_title($post->ID); ?>" >
        </a>
      </div><?php

    }
  } ?>
