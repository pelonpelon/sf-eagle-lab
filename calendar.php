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
    <!-- #background-->
    <div id="root">
      <div id="page" class="simple calendar"><a href="index.php"><img src="images/logo.svg" alt="logo" class="logo"></a>
        <div class="content">
          <header><span>EAGLE CALENDAR</span></header>
          <section>
            <nav>
              <ul>
                <li>
                  <div class="thumb"><a href="#"><img src="images/icons/TNL-button-les_paul.png" width="120" height="120" alt="Thursday Night Live Button" class="music"></a></div>
                </li>
                <li>
                  <div class="thumb"><a href="#"><img src="images/icons/calbears-button.png" width="120" height="120" alt="Bears Button" class="bears"></a></div>
                </li>
                <li>
                  <div class="thumb"><a href="#"><img src="images/icons/tom_of_finland.png" width="120" height="120" alt="Leather Button" class="leather"></a></div>
                </li>
                <li>
                  <div class="thumb"><a href="#"><img src="images/icons/icon-specialEvents.svg" width="120" height="120" alt="Special Events Button" class="special"></a></div>
                </li>
              </ul>
            </nav>
          </section>
          <section>
            <table><?php global $post; // required
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

            </table>
          </section>
        </div>
        <div id="page-footer"></div>
      </div>
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