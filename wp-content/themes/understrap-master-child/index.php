<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

// Exit if accessed directly.


defined( 'ABSPATH' ) || exit;

get_header();
echo get_the_content(1);
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">
	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
		<div class="row">
			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>
			<main class="site-main" id="main">
				<section>
					<h2 class="entry-title text-center">Недвижимость</h2><br/>
					<div class='row'>
					<?php
					//последние записи
					$args = array( 'post_type' => 'reality', 'posts_per_page' => 10, 'orderby' => 'id', 'order' => 'DESC' );
					$loop = new WP_Query( $args );

					while ( $loop->have_posts() ) {
						$loop->the_post();
						$uri=get_permalink(get_the_ID());
						$tit = get_the_title();
						$attr = array(
							'class' => "thumbnail-attachment",
						);
						$img = get_the_post_thumbnail( get_the_ID(), 'thumbnail', $attr  );

						$prop_cost=get_field('стоимость');
						$prop_square=get_field('площадь');
						$prop_living_square=get_field('жилая_площадь');
						$prop_floor=get_field('этаж');
						$prop_address=get_field('адрес');
						$prop_content=get_the_content();


						$str=<<<STR
						<figure class='col-sm-6 col-md-3 text-center'>
							<a href=" $uri ">
								 $img 
								<figcaption> $tit: <br/>
								$prop_cost руб. $prop_square/$prop_living_square м<sup><small>2</small></sup><br/>
								$prop_address, $prop_floor этаж</figcaption>
							</a>
						</figure>
STR;
						echo $str;

						?>
<?php } ?>


			</div>
				</section>
<br/>
				<section>
					<h2 class="entry-title text-center">Города</h2><br/>
					<div class='row'>
						<?php
						//города
						$args = array( 'post_type' => 'city', 'orderby' => 'title', 'order' => 'ASC' );
						$cities = new WP_Query( $args );

						while ( $cities->have_posts() ) {
							$cities->the_post();
							$uri=get_permalink(get_the_ID());
							$tit = get_the_title();
							$attr = array(
								'class' => "thumbnail-attachment",
							);
							$img = get_the_post_thumbnail( get_the_ID(), 'thumbnail', $attr  );
							$str=<<<STR
								<figure class='col-sm-6 col-md-3 text-center'>
									<a href=" $uri ">
								 		$img 
										<figcaption > $tit </figcaption>
									</a>
								</figure>
STR;
							echo $str;

							?>
						<?php } ?>
					</div>
				</section>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

			<!-- Do the right sidebar check
			< ?php get_template_part( 'global-templates/right-sidebar-check' ); ?>
			-->
		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
//выпадающий список городов
$select_city = '<select name="select_city" class="form-field form-name">';
while ( $cities->have_posts() ) {
	$cities->the_post();
	$id_city = $cities->post->ID;
	$title_city = $cities->post->post_title;
	$select_city .= "<option class='form-control' value=\"$id_city\">$title_city</option>";
}
$select_city .= '</select>';


$taxonomies =  get_terms( array(
	'taxonomy' => 'reality_type',
	'hide_empty' => false,
) );


//выпадающий список типов недвижимости\
$select_type = '<select name="select_type" class="form-field form-name">';
foreach ( $taxonomies as $term) {

	$id_term = $term->term_id;
	$name_term = $term->name;

	$select_type .= "<option class='form-control' value=\"$id_term\">$name_term</option>";
}
$select_type .= '</select>';
?>

<div class="row">
	<div class="col-sm-1 col-md-2"></div>
	<div class="col-sm-10 col-md-8 text-center">
	<div class="form-title"><h2>Новый объект недвижимости</h2></div>
	<form class="form-container reality-form">
		<div class="form-group">
			<div class="form-title">Наименование объекта:</div>
			<input class="form-control form-field form-name" type="text"  name="prop_title"  /><br />
		</div>
		<div class="form-group">
			<div class="form-title">тип объекта:</div>
			<?=$select_type ?> <br />
		</div>
		<div class="form-group">
			<div class="form-title">стоимость объекта:</div>
			<input class="form-control form-field form-name" type="text"  name="prop_cost" /><br />
		</div>
		<div class="form-group">
			<div class="form-title">площадь объекта:</div>
			<input class="form-control form-field form-name" type="text"  name="prop_square" /><br />
		</div>
		<div class="form-group">
			<div class="form-title">жилая площадь объекта:</div>
			<input class="form-control form-field form-name" type="text"  name="prop_living_square" /><br />
		</div>
		<div class="form-group">
			<div class="form-title">этаж объекта:</div>
			<input class="form-control form-field form-name" type="text"  name="prop_floor" /><br />
		</div>
		<div class="form-group">
			<div class="form-title">город объекта:</div>
			<?=$select_city?> <br />
		</div>
		<div class="form-group">
			<div class="form-title">адрес объекта:</div>
			<input class="form-control form-field form-name" type="text"  name="prop_address" /><br />
		</div>

		<div class="form-group">
			<div class="form-title">описание объекта:</div>
			<p><textarea class="form-control form-field form-name" rows="10" cols="45" name="prop_content"></textarea><br /></p>
			</div>

		<div class="form-group">
			<div>
				<label for="profile_pic">Загрузите изображение объекта</label>
				<input class="form-control" type="file" id="profile_pic" name="prop_image"
					   accept=".jpg, .jpeg, .png">
			</div>
		</div>
		<div class="form-group">
			<div id="submit-ajax" class="submit-container">
				<input class="submit-button" type="submit" value="Сохранить"/>
			</div>
			<div id="response-ajax" class="submit-container">
			</div>
		</div>


	</form>
</div>
</div>

<?php get_footer();?>
<script>

jQuery(document).ready(function($){
	var form = $(".form-container");

	form.on("submit", function (event) {
		event.preventDefault();
		var vanilaForm = this;
		var form = $(vanilaForm);

		var way = form.data('action') || "add_reality";

		var formData = new FormData(vanilaForm);
		formData.append("action", way);

		$.ajax({
               url: "wp-admin/admin-ajax.php",
               method: 'post',
               data: formData,
			processData: false,
			contentType: false,
            success: function (response) {

				//очистка полей
				$('input[name ="prop_title"]').val("");
				$('input[name ="prop_cost"]').val("");
				$('input[name ="prop_square"]').val("");
				$('input[name ="prop_living_square"]').val("");
				$('input[name ="prop_floor"]').val("");
				$('input[name ="prop_address"]').val("");
				$('input[name ="prop_image"]').val("");
				$('textarea[name ="prop_content"]').val("");

				$('#response-ajax').html(response);

				//обновить страницу по timeout
				setTimeout(function(){
					window.location.reload()
				}, 500)
			}});
        });
});

</script>
