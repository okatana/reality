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
			<img src="<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>">
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		</section>
		<section class="reality-entry-content col-sm-12 col-md-4">
		<?php
		//последние записи
		global $wpdb;
		$id_city=get_the_ID();
		$str = <<<STR
SELECT po.ID FROM wp_posts po
join wp_p2p p2p on p2p.p2p_to = po.ID and p2p.p2p_type='city_to_reality'
where po.post_type='reality' and po.post_status='publish' and p2p.p2p_from = $id_city
order by po.ID DESC
limit 10
STR;

		$reality_array_id = $wpdb->get_results($str);

		foreach($reality_array_id as $reality_id){
			$post_reality= get_post($reality_id->ID);
			//$args = array( 'post_id' => $reality_id->ID,  'orderby' => 'id', 'order' => 'DESC' );
			//$loop = new WP_Query( $args );
			$attr = array(
				'class' => "thumbnail-attachment",
			);
			$img_reality =  get_the_post_thumbnail( $reality_id->ID, 'thumbnail', $attr  );
			$title_reality =  $post_reality->post_title . PHP_EOL;
			$uri_reality=get_permalink($reality_id->ID);
			$prop1_reality =  get_post_meta( $reality_id->ID, 'стоимость', true );
			$prop2_reality =  get_post_meta( $reality_id->ID, 'площадь', true );
			$prop3_reality =  get_post_meta( $reality_id->ID, 'жилая_площадь', true );
			$prop4_reality =  get_post_meta( $reality_id->ID, 'этаж', true );
			$prop5_reality =  get_post_meta( $reality_id->ID, 'адрес', true );

		$str = <<<STR
			<figure class='col-sm-12  text-center'>
				<a href=" $uri_reality ">
					 $img_reality 
					<figcaption> <b>$title_reality:</b> $prop1_reality руб. $prop2_reality/$prop3_reality м<sup><small>2</small></sup></figcaption>
				</a>
			</figure>
<br/>
STR;
		echo $str;
		}
			?>


		</section>


	</div>







	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
