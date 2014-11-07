<div class="loop">
    <?php global $post; // required
    $args = array(
                    'category'      => $category_id,
                    'orderby'       => 'post_date',
                    'order'         => 'DESC',
                    'post_type'     => 'post',
                    'numberposts'   => 1
    );
    $custom_posts = get_posts($args);
    foreach($custom_posts as $post) : setup_postdata($post); ?>
        <h1> <?php the_title(); ?> </h1>
        <p> <?php the_content(); ?> </p>
    <?php endforeach; ?>
</div>