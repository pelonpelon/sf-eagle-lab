<?php
    global $post;
    $category_id = get_cat_ID('Add to sidebar');
    $args = array(
    'category'      => $category_id,
    'orderby'       => 'post_date',
    'order'         => 'ASC',
    'post_type'     => 'post',
    'post_status'   => 'publish',
    'numberposts'   => 2
    );
    $custom_posts = get_posts($args);
    if ( $custom_posts[1] ) {
      $post = $custom_posts[1];
      setup_postdata($post);
      ?>
        <section class="promo">
            <?php the_content();?>
        </section><?php
    }
    if ( $custom_posts[0] ) {
      $post = $custom_posts[0];
      setup_postdata($post);
      ?>
        <section class="promo">
            <?php the_content();?>
        </section><?php
    } ?>
