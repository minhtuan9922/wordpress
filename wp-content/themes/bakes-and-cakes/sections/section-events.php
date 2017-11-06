<?php
/**
 *Events Section
 * 
 * @package Bakes And Cakes
 */

$events_title       = get_theme_mod('bakes_and_cakes_events_section_title');

$events_first_post  = get_theme_mod('bakes_and_cakes_first_event_post');
$events_second_post = get_theme_mod('bakes_and_cakes_second_event_post');

$ed_make_reservation        = get_theme_mod('bakes_and_cakes_ed_make_reservation_section');
$reservation_title          = get_theme_mod('bakes_and_cakes_events_make_reservation_title');
$reservation_content_first  = get_theme_mod('bakes_and_cakes_events_reservation_content_first');
$reservation_phone_number   = get_theme_mod('bakes_and_cakes_events_reservation_phone_number');
$reservation_content_second = get_theme_mod('bakes_and_cakes_events_reservation_content_second');
$reservation_button         = get_theme_mod('bakes_and_cakes_events_reservation_button');
$reservation_button_link    = get_theme_mod('bakes_and_cakes_events_reservation_button_link');

 
if( $events_first_post || $events_second_post ){
    $events_posts = array( $events_first_post, $events_second_post );
    $events_posts = array_diff( array_unique( $events_posts ), array('') );
    
    $events_qry = new WP_Query( array( 
        'post_type'           => 'post',
        'post__in'            => $events_posts,
        'orderby'             => 'post__in',
        'ignore_sticky_posts' => true,
        'posts_per_page'       => '2'

    ) );

?>
<div class="container">
	<?php if($events_title){  ?>
		<header class="header">
			<?php if($events_title) ?><h1 class="main-title"><?php echo esc_html($events_title); ?></h1>
		</header>
	<?php } ?>
		<div class="row">
			<?php if($events_qry->have_posts()){ ?>
			<div class="columns-8">
			<?php while( $events_qry->have_posts()){ $events_qry->the_post(); ?>
				<div class="special-post">
				    <?php if(has_post_thumbnail()){ ?>
					<div class="img-holder">
					    <?php the_post_thumbnail('bakes-and-cakes-events-thumb'); ?>
					</div>
			        <?php } ?>
					<div class="text-holder">
						<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<?php the_excerpt(); ?>
					</div>
				</div>
			<?php } ?>
			</div>
            <?php } 
             wp_reset_postdata();
             if($ed_make_reservation){ ?>
				<div class="columns-4">
					<div class="info">
						<?php if($reservation_title) ?><strong><?php echo esc_html($reservation_title); ?></strong>
						<?php if($reservation_content_first) ?><p><?php echo esc_html($reservation_content_first); ?></p>
						<?php if($reservation_phone_number) ?><a href="tel:<?php echo esc_html($reservation_phone_number); ?>" class="tel-link"><?php echo esc_html($reservation_phone_number); ?></a>
						<?php if($reservation_content_second) ?><p><?php echo esc_html($reservation_content_second); ?></p>
						<?php if($reservation_button) ?><a href="<?php echo esc_url($reservation_button_link); ?>" class="btn-reserve"><?php echo esc_html($reservation_button); ?></a>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php }?>
</div>