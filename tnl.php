<?php
date_default_timezone_set('America/Los_Angeles');
$local_time_zone_factor = trim(date('O', strtotime("now")), "-0");
global $now;
$now = time();
require('wp/wp-blog-header.php');
?>
<!DOCTYPE html><html><head><title>SF-Eagle Gay Bar | 398 12th Street</title><meta http-equiv="Content-Type" content="text/html" charset="utf-8"><!-- <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">--><meta name="viewport" content="width=device-width"><meta name="viewport" content="initial-scale=1.0"><!--link(rel='stylesheet', href='css/wp.css')--><link rel="stylesheet" href="css/main.css.1374400525"><link href="http://fonts.googleapis.com/css?family=Jolly+Lodger|Coming+Soon|Rouge+Script" rel="stylesheet" type="text/css"><link rel="apple-touch-icon" href="images/icons/touch-icon-iphone-57x57.png"><link rel="apple-touch-icon" sizes="72x72" href="images/icons/touch-icon-ipad.png"><link rel="apple-touch-icon" sizes="114x114" href="images/icons/touch-icon-iphone-retina.png"><link rel="apple-touch-icon" sizes="144x144" href="images/icons/touch-icon-ipad-retina.png"><script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-42163204-1', 'sf-eagle.com');
ga('send', 'pageview');</script></head><body><!-- hello --><div id="background"></div><div id="page"><a href="index.php"><img src="images/logo-transparency-whiteeagle-cutout-thumb.png" alt="logo"></a><div class="contentTitle"><h1>THURSDAY NIGHT LIVE</h1></div><div class="contentText"><div class="tnl">
    <?php global $post; // required
    $tz = -25200;
    $args = array(
        'meta_key'      => 'date',
        'orderby'       => 'meta_value_num',
        'order'         => 'ASC',
        'post_type'     => 'event',
        'numberposts'   => -1
    );
    $custom_posts = get_posts($args);
    foreach($custom_posts as $post)
    {
        setup_postdata($post);
        $type = get_field('type_of_event');
        if ( $type[0] !== "music" ) { continue; }
        if ( ! get_field('image') ) { $image = "images/logo-cropped-thumb.jpg"; }
            else { $image = wp_get_attachment_image_src(get_field('image'), 'full'); }
        $epoch = ((get_post_meta(get_the_ID(), 'date', true)) / 1000) +
            (date( 'H',(int)(get_post_meta(get_the_ID(), 'time', true)) ) * 60 * 60) + $tz;
        ?>
    <table class="date">
        <tr>
            <td>
                <h2> <?php $day = date('l', $epoch);
                    if ( $day !== "Thursday" ) { echo $day; }?> <sup><?php echo date('n/j', $epoch ); ?></sup> </h2>
            </td>
            <td>
                <p>
                    <a href="<?php the_field('band_#1_link'); ?>" target="_blank" >
                         <?php the_field('band_#1'); ?>
                    </a>
                </p>
                <?php
                if ( get_field('band_#2') !== "" )
                { ?>
                    <p>
                        <a href="<?php the_field('band_#2_link'); ?>" target="_blank" >
                             <?php the_field('band_#2'); ?>
                        </a>
                    </p>
                <?php
                }
                if ( get_field('band_#3') !== "" )
                { ?>
                    <p>
                        <a href="<?php the_field('band_#3_link'); ?>" target="_blank" >
                             <?php the_field('band_#3'); ?>
                        </a>
                    </p>
                <?php
                }
                if ( get_field('band_#4') !== "" )
                { ?>
                    <p>
                        <a href="<?php the_field('band_#4_link'); ?>" target="_blank">
                             <?php the_field('band_#4'); ?>
                        </a>
                    </p>
                <?php
                } ?>
            </td>
            <td>
                <?php
                $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
                $image_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
                ?>
                <a href="<?php echo $image_large[0] ?>" width="<?php echo $image_large[1]; ?>" height="<?php echo $image_large[2]; ?>" rel="lightbox">
                    <img src="<?php echo $image_thumbnail[0] ?>" width="<?php echo $image_thumbnail[1]; ?>" height="<?php echo $image_thumbnail[2]; ?>" alt="<?php the_title(); ?>" class="thumb">
                </a>
            </td>
         </tr>
    </table>
    <?php
    } ?>
</div>
</div><p class="dougemail">Do you know a local band that wants to play Thursday Night Live at SF Eagle? For bookings please contact<a href="mailto:doug@sf-eagle.com"><br>doug@sf-eagle.com</a></p></div></body></html><script src="widgets/lightbox/js/jquery-1.7.2.min.js"></script><script src="widgets/lightbox/js/lightbox-ck.js"></script>
