<?php
  date_default_timezone_set('America/Los_Angeles');
  $local_time_zone_factor = trim(date('O', strtotime("now")), "-0");
  global $now;
  $now = time();
  require('wp/wp-blog-header.php');
?>
<!DOCTYPE html><html><head><title><?php bloginfo('name'); ?></title><meta http-equiv="Content-Type" content="text/html" charset="utf-8"><meta name="viewport" content="width=device-width, minimum-scale=1.0, target-densityDpi=160"><meta name="apple-mobile-web-app-capable" content="yes"><meta name="mobile-web-app-capable" content="yes"><meta name="twitter:widgets:csp" content="on"><link rel="stylesheet" href="css/main.css"><link rel="prefetch" href="images/logo.svg"><link rel="prefetch font/woff" href="//themes.googleusercontent.com/static/fonts/comingsoon/v3/myblyOycMnPMGjfPG-DzP4bN6UDyHWBl620a-IRfuBk.woff" type="text/css"><link rel="prefetch font/woff" href="//themes.googleusercontent.com/static/fonts/jollylodger/v1/RX8HnkBgaEKQSHQyP9itiXhCUOGz7vYGh680lGh-uXM.woff" type="text/css"><link rel="apple-touch-icon" href="images/icons/apple-touch-icon-57x57.png"><link rel="apple-touch-icon" sizes="72x72" href="images/icons/touch-icon-ipad.png"><link rel="apple-touch-icon" sizes="114x114" href="images/icons/touch-icon-iphone-retina.png"><link rel="apple-touch-icon" sizes="144x144" href="images/icons/touch-icon-ipad-retina.png"><!-- [if gte IE 9]--><style type="text/css">.gradient {
   filter: none;
}</style><!-- [endif]--></head><body><!-- hello --><!-- #background--><div id="root"><div id="page" class="simple softball"><a href="index.php"><img src="images/logo.svg" alt="logo" class="logo"></a><div class="content"><header class="cf"><span>•EAGLE SOFTBALL•</span></header><section class="content"><?php
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
</section></div><div id="page-footer"></div></div><div id="footer"><div class="links"><ul class="social"><li class="email"><a href="mailto:info@sf-eagle.com?subject=Sent%20via%20website" title="Send us email" width="60" height="60"><img src="images/icons/email.png" alt="email" class="thumb"></a></li><li class="faceboook"><a href="http://www.facebook.com/theSFEagle" title="We're on Facebook" target="_blank" width="60" height="60"><img src="images/icons/facebook.png" alt="facebook" class="thumb"></a></li><li class="twitter"><a href="https://twitter.com/sfeaglebar" title="We're on Twitter" target="_blank" width="60" height="60"><img src="images/icons/twitter.png" alt="twitter" class="thumb"></a></li><li class="google"><a href="https://plus.google.com/104184281608152528049/posts" rel="publisher" title="We're on Google Plus" target="_blank" width="60" height="60"><img src="images/icons/google-plus-icon.png" alt="google+" class="thumb"></a></li><li class="youtube"><a href="http://www.youtube.com/channel/UCmzgZ3-nEo1S8tnyjGJ3WoQ/playlists" title="We're on Youtube" target="_blank" width="60" height="60"><img src="images/icons/youtube-icon.png" alt="youtube" class="thumb"></a></li></ul></div><div class="content"><div class="googlemap"><a href="https://maps.google.com/maps?q=Eagle+Tavern,+12th+Street,+San+Francisco,+CA,+USA&amp;hl=en&amp;sll=37.770048,-122.413315&amp;sspn=0.010974,0.01929&amp;oq=Eagle&amp;t=m&amp;z=16" target="_blank"><img src="images/google-map.jpg" width="250" height="250"></a><h3>We're just off the freeway<br>398 12th Street<br>(corner of Harrison)</h3></div><div class="hankypic"><a href="GayHankyCodes.php" title="Don't miss our monthly FLAG parties"><img src="images/hankycodes.jpeg" alt="hanky codes" class="thumb"><h3>HANKY CODES</h3></a></div></div><div class="flyers"><div class="flexslider"><ul class="slides"><li><p class="rc">Every 3rd Saturday</p><a href="images/carousel/bluf-lite.jpg" rel="lightbox"><img src="images/carousel/bluf-lite-275.jpg"></a></li><li><p class="rc">Every 4th Saturday</p><a href="images/carousel/Sadistic-generic-389x600.jpg" rel="lightbox"><img src="images/carousel/Sadistic-generic-389x600-275.jpg"></a></li><li><p class="rc">3rd and 5th Sundays</p><a href="images/carousel/DDGeneric-433x650-33K.jpg" rel="lightbox"><img src="images/carousel/DDGeneric-433x650-33K-275.jpg"></a></li><li><p class="rc">2nd and 4th Wednesday</p><a href="images/carousel/underwear-generic-421x650.jpg" rel="lightbox"><img src="images/carousel/underwear-generic-421x650-275.jpg"></a></li><li><p class="rc">Every 3rd Friday</p><a href="images/carousel/CubHouse-600.jpg" rel="lightbox"><img src="images/carousel/CubHouse-600-275.jpg"></a></li><li><p class="rc">Friday Cigar Nights</p><a href="images/carousel/cigardick.jpg" rel="lightbox"><img src="images/carousel/cigardick-275.jpg"></a></li></ul></div><div class="nonFlexslider"><ul class="slides"><li><p class="rc">Every 3rd Saturday</p><img src="images/carousel/bluf-lite.jpg"></li><li><p class="rc">Every 4th Saturday</p><img src="images/carousel/Sadistic-generic-389x600.jpg"></li><li><p class="rc">3rd and 5th Sundays</p><img src="images/carousel/DDGeneric-433x650-33K.jpg"></li><li><p class="rc">2nd and 4th Wednesday</p><img src="images/carousel/underwear-generic-421x650.jpg"></li><li><p class="rc">Every 3rd Friday</p><img src="images/carousel/CubHouse-600.jpg"></li><li><p class="rc">Friday Cigar Nights</p><img src="images/carousel/cigardick.jpg"></li></ul></div></div></div></div><script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script><script src="js/main.js"></script><script src="js/fastclick.min.js"></script><script>window.addEventListener('load', function(){
  FastClick.attach(document.body);
  return false;
  });
  </script><script async src="widgets/lightbox/js/lightbox-ck.js"></script><script>$(document).ready(function() {
  $.get('index.flyers.html', function(data) {
    $('#flyers').html(data);
  });
});
$('div.lb-nav').on('click', function(e) {
  window.close();return false;
});
</script><script async src="widgets/flexslider/jquery.flexslider-ck.js"></script><script>$(window).load(function() {
$('.flexslider').flexslider({
animation: "slide",
animationLoop: "true"
});
});
</script><script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-42163204-1', 'sf-eagle.com');
ga('send', 'pageview');
</script></body></html>