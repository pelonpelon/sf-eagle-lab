<?php global $post; // required
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

$monthlabel = false;

foreach($custom_posts as $post)
{
    setup_postdata($post);
    $type_of_event = get_field('type_of_event');

    if ( $post->post_status == "private" ) { continue; }

    include "includes/timegames.php";
    if ( $now > $endtime + 60*60*18 ) { continue; }

    if ( ! get_field('image') ) { $image = "images/logo-cropped-thumb.jpg"; }
    else { $image = wp_get_attachment_image_src(get_field('image'), 'full'); }

    $image_full = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
    $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
    $image_medium = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
    $image_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');

    $title_thumbnail = get_field('title_thumbnail');

    $month = date('F', $begintime); 
    if ( $monthlabel != $month ) { 
      ?>
      <tr class="month">
        <td></td>
        <td><?php echo $month; ?></td>
        <td></td>
      </tr>
<?php
      $monthlabel = $month;
    }

    $crowd = get_post_meta(get_the_ID(), 'crowd', true);
    if ( $crowd ) {
      echo '<tr class="';
      echo implode(' ', $crowd);
      echo '">';
    }else{
      echo '<tr>';
    }?>
      <td>
<?php
    $day = date('l', $begintime);
    echo $day; ?> 
        <span class="bigdate"><?php echo date('j', $begintime ); ?></span>
        <p class="time">
<?php
    echo $start . " - " . $finish; ?>
        </p>
     </td>
<?php
    $type_of_event = get_field('type_of_event');
    if ( $type_of_event[0] === 'music' ) { ?>
      <td>
<?php
    if ( get_field('promoter')) { ?>
          <a href="<?php the_field('promoter_link'); ?>" target="_blank">
             <div class="promoter"> <?php the_field('promoter'); ?> </div>
          </a>
<?php } ?>
          <a href="<?php the_field('band_#1_link'); ?>" target="_blank" >
            <?php the_field('band_#1'); ?>
          </a>
<?php
    if ( get_field('band_#2') !== "" ) { ?>
          <a href="<?php the_field('band_#2_link'); ?>" target="_blank" >
              <?php the_field('band_#2'); ?>
          </a>
<?php
    } if ( get_field('band_#3') !== "" ) { ?>
          <a href="<?php the_field('band_#3_link'); ?>" target="_blank" >
              <?php the_field('band_#3'); ?>
          </a>
<?php
    } if ( get_field('band_#4') !== "" ) { ?>
          <a href="<?php the_field('band_#4_link'); ?>" target="_blank">
              <?php the_field('band_#4'); ?>
          </a>
<?php } ?>
        </td>
<?php
    } else { ?>
        <td>
          <a href="<?php the_field('link'); ?>" target="_blank" >
          <div class="event-title"> <?php the_title(); ?> </div>

<?php 
          if( $title_thumbnail ){ 
            echo wp_get_attachment_image( $title_thumbnail, 'thumb' ); 
          } ?>

          <?php $content=get_post($title_thumbnail); ?>
          <span class="thumb-caption"><?php echo $content->post_excerpt; ?></span>
          <span class="dj-name"> <?php the_field('dj_name'); ?></span>
          </a>
        </td>
<?php } ?>
        <td>
          <div class="thumb">
            <a href="<?php echo $image_full[0] ?>" width="<?php echo $image_full[1]; ?>" height="<?php echo $image_full[2]; ?>" rel="lightbox">
                <img src="<?php echo $image_thumbnail[0] ?>" width="<?php echo $image_thumbnail[1]; ?>" height="<?php echo $image_thumbnail[2]; ?>" alt="<?php the_title(); ?>">
                <span class="thumb-caption"><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></span>
            </a>
            </div>
<?php
    if ( $type_of_event[0] === "music" && get_field('youtube_playlist') ) { ?>
      <div class="thumb youtube">
        <a href="<?php the_field('youtube_playlist'); ?>" target="_blank">
          <img src="images/icons/icon-youtubePlaylist.jpg" alt="Youtube Playlist">
        </a>
        </div>
<?php } ?>
        </td>
      </tr>
<?php } ?>
