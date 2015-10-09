<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Theme_Fifteen
 * @since Theme Fifteen 1.0
 */

if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) || is_active_sidebar( 'sidebar-1' )  ) : ?>
	<div id="main_menu_wrapper" class="main_menu_wrapper">

		<?php 	
			$schedule_menu = get_field('schedule_menu', 'options');
		 ?>
		<div class="schedule_menu_wrapper">
			<a href="/contact"><img src="<?php echo $schedule_menu; ?>"></a>		 	
		</div>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php
					// Primary navigation menu.
					wp_nav_menu( array(
						'menu_class'     => 'nav-menu',
						'theme_location' => 'primary',
					) );
				?>
			</nav><!-- .main-navigation -->
		<?php endif; ?>
	</div><!-- .main_menu_wrapper -->

<?php endif; ?>
