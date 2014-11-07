<?php
    global $post;
    $category_id = get_cat_ID('Tumblr');
    $args = array(
    'category'      => $category_id,
    'orderby'       => 'post_date',
    'order'         => 'DESC',
    'post_type'     => 'post',
    'post_status'   => 'scheduled',
    'numberposts'   => 1
    );
    $posts = get_posts($args);
    foreach($posts as $post)
    {
        if ( !$posts) { continue; }
        setup_postdata($post);
        if ( $post->post_status == "draft" ) { continue; }
        if ( $post->post_status == "private" ) { continue; }
        if ( $post->post_status == "archived" ) { continue; }
        include 'includes/timegames.php';
        ?>
        <section class="tumblr" style="display: block;">
          <h3><?php the_title() ?></h3>
          <div class="tumblr-content"><?php the_content(); ?></div>
        </section><?php
    }?>
