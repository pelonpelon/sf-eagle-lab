<?php
    global $post;
    $category_id = get_cat_ID('Softball');
    $args = array(
    'category'      => $category_id,
    'orderby'       => 'post_date',
    'order'         => 'DESC',
    'post_type'     => 'post',
    'post_status'   => 'publish',
    'numberposts'   => 2
    );
    $custom_posts = get_posts($args);
    foreach($custom_posts as $post)
    {
      if ( !$custom_posts ) { continue; }
      setup_postdata($post);
      if ( $post->post_status == "draft" ) { continue; }
      if ( $post->post_status == "private" ) { continue; }
      if ( $post->post_status == "archived" ) { continue; }
      include 'includes/timegames.php';
      ?>
      <section class="softball" style="display: block;">
          <div class="with_thumbnail"><?php
          the_content();?>
      </section><?php
    }?>
