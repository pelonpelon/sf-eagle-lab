<ul class="listing">

<?php global $post; // required
$day = '';

       $args=array('post_type'=>'event','numberposts'=>-1);
       $custom_posts=get_posts($args);
       foreach($custom_posts as $post){
           /* update weekly events to this week */
           $weekly=get_post_meta(get_the_ID(),'weekly',true);
           if($weekly){
               include 'includes/timegames.php';
               if($begintime<$now){
                   $day=date('l',$begintime);
                   $hour=date('Hi',$begintime);
                   $t=strtotime($day." ".$hour);
                   $custom_field_date=date('Y-m-d',$t);
                   update_post_meta($post->ID,'date',$custom_field_date);
               }
           }
           include 'includes/timegames.php';
           update_post_meta($post->ID,'date_num',$begintime);
       }
       $day='';
       rewind_posts();

$args = array(
            'meta_key'      => 'date_num',
            'orderby'       => 'meta_value_num',
            'order'         => 'ASC',
            'post_type'     => 'event',
            'numberposts'   => -1
               );
$custom_posts = get_posts($args);
foreach($custom_posts as $post)
{
    setup_postdata($post);
    $type_of_event = get_field('type_of_event');
    include 'includes/timegames.php';
    if ( $begintime > $now + 60*60*24*7 || $now > $endtime ) { continue; }

    if ($day != date('l', $begintime)) { ?>
      <li id="<?php echo date('l', $begintime); ?>" class="day">
      <h3><?php echo date('l', $begintime); ?> <sup><?php echo date('n/j', $begintime); ?></sup> </h3> <?php }

    $day = date('l', $begintime);
    $price = "$" . get_field('price'); ?>

    <div class="event cf">
        <p class="time"><?php echo $start . " - " . $finish;
            if ( get_field('price')) { ?>
              <span class="price"><?php echo $price; ?></span> <?php } ?>
        </p><?php

    if ( $type_of_event[0] === "music" ) { ?>

      <ul class="tnl event-list"> <?php

        if ( get_field('promoter')) { ?>
          <li class="promoter">
              <a href="<?php the_field('promoter_link'); ?>" target="_blank">
                  <span> <?php the_field('promoter'); ?> </span>
              </a>
          </li><?php } ?>

        <li>
            <a href="<?php the_field('band_#1_link'); ?>" class="button" target="_blank">
                <span> <?php the_field('band_#1'); ?> </span>
            </a>
        </li> <?php

        if ( get_field('band_#2') !== "" ) { ?>
          <li>
              <a href="<?php the_field('band_#2_link'); ?>" class="button" target="_blank">
                  <span> <?php the_field('band_#2'); ?> </span>
              </a>
          </li><?php }

        if ( get_field('band_#3') !== "" ) { ?>
          <li>
              <a href="<?php the_field('band_#3_link'); ?>" class="button" target="_blank">
                  <span> <?php the_field('band_#3'); ?> </span>
              </a>
          </li><?php }

        if ( get_field('band_#4') !== "" ) { ?>
          <li>
              <a href="<?php the_field('band_#4_link'); ?>" class="button" target="_blank">
                  <span> <?php the_field('band_#4'); ?> </span>
              </a>
          </li><?php } ?>

      </ul><?php

    }

    else { ?>
        <ul class="event-list">
            <li>
                <a href="<?php the_field('link'); ?>" class="button" target="_blank">
                    <span> <?php the_title(); ?> </span>
                </a>
            </li>
        </ul><?php }

    $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
    $image_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail'); ?>

        <a href="<?php echo $image_large[0] ?>" rel="lightbox">
            <img src="<?php echo $image_thumbnail[0] ?>" width="<?php echo $image_thumbnail[1]; ?>" height="<?php echo $image_thumbnail[2]; ?>" alt="<?php the_title(); ?>">
        </a><?php

    if ( $type_of_event[0] === "music" && get_field('youtube_playlist') ) { ?>
      <a href="<?php the_field('youtube_playlist'); ?>" target="_blank">
        <img src="images/icons/icon-youtubePlaylist.jpg" alt="Youtube Playlist">
      </a><?php
    } ?>

    </div>

    <?php

    if ($day != date('l', $begintime)) { ?>
      </li> <?php }

} ?>
</ul>

<a href="calendar.php" >
  <h3 class="more_events">More...</h3>
</a>
