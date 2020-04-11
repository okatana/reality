<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title text-center">', '</h1>' ); ?>

	</header><!-- .entry-header -->




	<div class="row">
		<section class="reality-entry-content col-sm-12 col-md-8">
			<img src="<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>" class="img-fluid">
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		</section>

		<?php
		  $props=[
		  	["Стоимость", "стоимость",'icon6.jpg'],
		  	["Площадь", "площадь",'icon5.jpg'],
		  	["Жилая площадь", "жилая_площадь",'icon5.jpg'],
		  	["Этаж", "этаж",'icon7.jpg'],
		  	["Адрес", "адрес",'icon4.jpg'],

		  ]
		?>

		<section class="reality-entry-props col-sm-12 col-md-4">
			<?php
			foreach($props as $prop){
			?>
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header col-sm-12">
							<div class="row">
								<div class="col-sm-3">
									<img align="center" src="/reality/wp-content/themes/understrap-master-child/img/<?= $prop[2] ?>" class="img-fluid">
								</div>
								<p class="col-sm-9"><?= $prop[0] ?></p>

							</div>
						</div>


						<div class="card-body">
							<h4 class="card-title text-center"><?php echo get_field($prop[1]);?></h4>
							<p class="card-text">

							</p>
						</div>

					</div>
				</div>
<br/>

			<?php
			}
			?>


		</section>


	</div>







	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
