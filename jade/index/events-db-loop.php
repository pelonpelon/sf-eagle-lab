<ul class="listing">

<?php
  global $post;
  $day = '';
  $max_posts = 1;

 $args=array('post_type'=>'event','numberposts'=>-1);
 $custom_posts=get_posts($args);
 /* update weekly events to this week */
 foreach($custom_posts as $post){
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
  /* fill events list */
  foreach($custom_posts as $post) {
    setup_postdata($post);
    $type_of_event = get_field('type_of_event');
    if ( $post->post_status == "private" ) { continue; }
    include 'includes/timegames.php';
    // if ( $begintime > $now + 60*60*24*9 || $now > $endtime ) { continue; }
    if ( $now > $endtime-60 ) { continue; }
    if ($day != date('l', $begintime)) {
      if ( $max_posts-- == 0 ) {break;} ?>

  <li id="<?php echo date('l', $begintime); ?>" class="day">
    <h3><?php echo date('l', $begintime); ?> <sup><?php echo date('n/j', $begintime); ?></sup> </h3>

<?php 
    }
    $day = date('l', $begintime);
    $price = "$" . get_field('price');
    $image_full = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
    $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
    $image_medium = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
    $image_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
    $title_thumbnail = get_field('title_thumbnail'); ?>
   
    <div class="event cf">
      <p class="time">

<?php
    echo $start . " - " . $finish;
    if ( get_field('price')) { ?>

       <span class="price"><?php echo $price; ?></span>

<?php } ?>

      </p>

<?php
    if ( $type_of_event[0] === "music" ) { ?>
     
      <ul class="tnl event-list">

<?php
    if ( get_field('promoter')) { ?>

        <li class="promoter">
          <a href="<?php the_field('promoter_link'); ?>" target="_blank">
            <div> <?php the_field('promoter'); ?> </div>
          </a>
       </li>

<?php } ?>

        <li>
          <a href="<?php the_field('band_#1_link'); ?>" class="button" target="_blank">
            <div> <?php the_field('band_#1'); ?> </div>
          </a>
          </li>

<?php
    if ( get_field('band_#2') !== "" ) { ?>
 
        <li>
          <a href="<?php the_field('band_#2_link'); ?>" class="button" target="_blank">
            <div> <?php the_field('band_#2'); ?> </div>
          </a>
          </li>

<?php }
    if ( get_field('band_#3') !== "" ) { ?>
 
        <li>
          <a href="<?php the_field('band_#3_link'); ?>" class="button" target="_blank">
            <div> <?php the_field('band_#3'); ?> </div>
          </a>
          </li>
<?php }
    if ( get_field('band_#4') !== "" ) { ?>

        <li>
          <a href="<?php the_field('band_#4_link'); ?>" class="button" target="_blank">
            <div> <?php the_field('band_#4'); ?> </div>
          </a>
        </li>

<?php } ?>

      </ul>

<?php
    } else { ?>

      <ul class="event-list">
        <li>
          <a href="<?php the_field('link'); ?>" class="button" target="_blank">
            <div class="event-title"> <?php the_title(); ?> </div>

<?php 
    if( $title_thumbnail ){ 
      echo wp_get_attachment_image( $title_thumbnail, 'medium' ); 
    } ?>

            <span class="dj-name"> <?php the_field('dj_name'); ?> </span>
          </a>
        </li>
      </ul>

<?php } ?>

      <a href="<?php echo $image_large[0] ?>" rel="lightbox">
        <img class="flyer-thumb" 
          src="<?php echo $image_thumbnail[0] ?>" 
          width="<?php echo $image_thumbnail[1]; ?>"
          height="<?php echo $image_thumbnail[2]; ?>"
          alt="<?php the_title(); ?>" />
      </a>

<?php
    if ( $type_of_event[0] === "music" && get_field('youtube_playlist') ) { ?>

      <a href="<?php the_field('youtube_playlist'); ?>" target="_blank">
        <img class="youtubePlaylistIcon" src="images/icons/icon-youtubePlaylist.jpg" alt="Youtube Playlist">
      </a>

<?php } ?>

    </div>

<?php 
  }
  if ($day != date('l', $begintime)) { ?>

  </li>

<?php 
  } ?>

</ul>
<a class="button to-calendar" href="calendar.php">
  <span>See The<br>Complete Calendar</span>
</a>
