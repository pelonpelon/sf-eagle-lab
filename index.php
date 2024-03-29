<?php
  date_default_timezone_set('America/Los_Angeles');
  $local_time_zone_factor = trim(date('O', strtotime("now")), "-0");
  global $now;
  $now = time();
  require('wp/wp-blog-header.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php bloginfo('name'); ?></title>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, target-densityDpi=160">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="twitter:widgets:csp" content="on">
    <link rel="stylesheet" href="css/main.css">
    <link rel="prefetch" href="images/logo.svg">
    <link rel="prefetch font/woff" href="//themes.googleusercontent.com/static/fonts/comingsoon/v3/myblyOycMnPMGjfPG-DzP4bN6UDyHWBl620a-IRfuBk.woff" type="text/css">
    <link rel="prefetch font/woff" href="//themes.googleusercontent.com/static/fonts/jollylodger/v1/RX8HnkBgaEKQSHQyP9itiXhCUOGz7vYGh680lGh-uXM.woff" type="text/css">
    <link rel="apple-touch-icon" href="images/icons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/icons/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/icons/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/icons/touch-icon-ipad-retina.png">
    <!-- [if gte IE 9]-->
    <style type="text/css">
      .gradient {
         filter: none;
      }
    </style>
    <!-- [endif]-->
  </head>
  <body><!-- hello -->
    <!-- #background--><a name="top"></a>
    <div id="root">
      <div id="page" class="index"><a name="mast"></a>
        <div id="mast"><a name="top"></a>
          <header><img src="images/logo.svg" alt="San Francisco Eagle" width="200" height="200" class="logo"></header>
          <nav>
            <ul>
              <li class="thisweek"><a href="#events" class="button"><span>Today</span></a></li>
              <li><a href="calendar.php" class="button"><span>Calendar</span></a></li>
              <li><a href="#instagram" class="button"><span>Latest<br>Pics</span></a></li>
              <li><a href="merch.php" class="button"><span>Hoodies<br>Tanks<br>& Tees</span></a></li>
              <li><a href="#footer" class="button"><span>Contact<br>Us</span></a></li>
              <li><a href="jobs.php" class="button"><span>Jobs</span></a></li>
              <li><a href="recommended.php" class="button"><span>We<br>Recommend</span></a></li>
            </ul>
          </nav>
          <div class="promo_container"><?php
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

          </div>
        </div><a name="tease"></a>
        <div id="tease"><?php
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

        </div><a name="events"></a>
        <div id="events"><ul class="listing">

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

        </div>
        <div id="pics"></div><a name="instagram"><?php
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
</a>
        <div id="page-footer"></div>
      </div><a name="footer"></a>
      <div id="footer">
        <div class="links">
          <ul class="social">
            <li class="email"><a href="mailto:info@sf-eagle.com?subject=Sent%20via%20website" title="Send us email" width="60" height="60"><img src="images/icons/email.png" alt="email" class="thumb"></a></li>
            <li class="faceboook"><a href="http://www.facebook.com/theSFEagle" title="We're on Facebook" target="_blank" width="60" height="60"><img src="images/icons/facebook.png" alt="facebook" class="thumb"></a></li>
            <li class="twitter"><a href="https://twitter.com/sfeaglebar" title="We're on Twitter" target="_blank" width="60" height="60"><img src="images/icons/twitter.png" alt="twitter" class="thumb"></a></li>
            <li class="google"><a href="https://plus.google.com/104184281608152528049/posts" rel="publisher" title="We're on Google Plus" target="_blank" width="60" height="60"><img src="images/icons/google-plus-icon.png" alt="google+" class="thumb"></a>
            </li>
            <li class="youtube"><a href="http://www.youtube.com/channel/UCmzgZ3-nEo1S8tnyjGJ3WoQ/playlists" title="We're on Youtube" target="_blank" width="60" height="60"><img src="images/icons/youtube-icon.png" alt="youtube" class="thumb"></a></li>
          </ul>
        </div>
        <div class="content">
          <div class="googlemap"><a href="https://maps.google.com/maps?q=Eagle+Tavern,+12th+Street,+San+Francisco,+CA,+USA&amp;hl=en&amp;sll=37.770048,-122.413315&amp;sspn=0.010974,0.01929&amp;oq=Eagle&amp;t=m&amp;z=16" target="_blank"><img src="images/google-map.jpg" width="250" height="250"></a>
            <h3>We're just off the freeway<br>398 12th Street<br>(corner of Harrison)</h3>
          </div>
          <div class="hankypic"><a href="GayHankyCodes.php" title="Don't miss our monthly FLAG parties"><img src="images/hankycodes.jpeg" alt="hanky codes" class="thumb">
              <h3>HANKY CODES</h3></a></div>
        </div>
        <div class="flyers">
          <div class="flexslider">
            <ul class="slides">
              <li>
                <p class="rc">Every 3rd Saturday</p><a href="images/carousel/bluf-lite.jpg" rel="lightbox"><img src="images/carousel/bluf-lite-275.jpg"></a>
              </li>
              <li>
                <p class="rc">Every 4th Saturday</p><a href="images/carousel/Sadistic-generic-389x600.jpg" rel="lightbox"><img src="images/carousel/Sadistic-generic-389x600-275.jpg"></a>
              </li>
              <li>
                <p class="rc">3rd and 5th Sundays</p><a href="images/carousel/DDGeneric-433x650-33K.jpg" rel="lightbox"><img src="images/carousel/DDGeneric-433x650-33K-275.jpg"></a>
              </li>
              <li>
                <p class="rc">2nd and 4th Wednesday</p><a href="images/carousel/underwear-generic-421x650.jpg" rel="lightbox"><img src="images/carousel/underwear-generic-421x650-275.jpg"></a>
              </li>
              <li>
                <p class="rc">Every 3rd Friday</p><a href="images/carousel/CubHouse-600.jpg" rel="lightbox"><img src="images/carousel/CubHouse-600-275.jpg"></a>
              </li>
              <li>
                <p class="rc">Friday Cigar Nights</p><a href="images/carousel/cigardick.jpg" rel="lightbox"><img src="images/carousel/cigardick-275.jpg"></a>
              </li>
            </ul>
          </div>
          <div class="nonFlexslider">
            <ul class="slides">
              <li>
                <p class="rc">Every 3rd Saturday</p><img src="images/carousel/bluf-lite.jpg">
              </li>
              <li>
                <p class="rc">Every 4th Saturday</p><img src="images/carousel/Sadistic-generic-389x600.jpg">
              </li>
              <li>
                <p class="rc">3rd and 5th Sundays</p><img src="images/carousel/DDGeneric-433x650-33K.jpg">
              </li>
              <li>
                <p class="rc">2nd and 4th Wednesday</p><img src="images/carousel/underwear-generic-421x650.jpg">
              </li>
              <li>
                <p class="rc">Every 3rd Friday</p><img src="images/carousel/CubHouse-600.jpg">
              </li>
              <li>
                <p class="rc">Friday Cigar Nights</p><img src="images/carousel/cigardick.jpg">
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="backtothetop"><a href="#top" class="button"><span>Back To The Top</span></a></div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/fastclick.min.js"></script>
    <script>
      window.addEventListener('load', function(){
        FastClick.attach(document.body);
        return false;
        });
        
    </script>
    <script async src="widgets/lightbox/js/lightbox-ck.js"></script>
    <script>
      $(document).ready(function() {
        $.get('index.flyers.html', function(data) {
          $('#flyers').html(data);
        });
      });
      $('div.lb-nav').on('click', function(e) {
        window.close();return false;
      });
      
    </script>
    <script async src="widgets/flexslider/jquery.flexslider-ck.js"></script>
    <script>
      $(window).load(function() {
      $('.flexslider').flexslider({
      animation: "slide",
      animationLoop: "true"
      });
      });
      
    </script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-42163204-1', 'sf-eagle.com');
      ga('send', 'pageview');
      
    </script>
  </body>
</html>