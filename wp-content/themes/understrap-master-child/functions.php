<?php



add_action( 'wp_enqueue_scripts', 'my_scripts_method' , 99);
function my_scripts_method(){

   // wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/css/theme.min.css' );
   // wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/../understrap-master-child/style.css' );
    wp_enqueue_script( 'jquery' );
   // wp_enqueue_script( 'newscript', get_template_directory_uri() . '/style.css');
  // wp_enqueue_style( 'style', get_stylesheet_uri() );
}



if (function_exists("_p2p_load")) {
    function vp_post_to_post()
    {
        p2p_register_connection_type(array(
            'name' => 'city_to_reality',
            'from' => 'city',
            'to' => 'reality',
            'cardinality' => 'one-to-many',
            'admin_box' => array(
                'context' => 'advanced'
            )
        ));
    }

    add_action('p2p_init', 'vp_post_to_post');


}


add_filter( 'excerpt_more', 'new_excerpt_more' );
function new_excerpt_more( $more ){
    global $post;
    return '<a href="'. get_permalink($post) . '">Читать дальше...</a>';
}

function ajax_add_reality_form(){
    global $wpdb;
    $post_title = $_REQUEST['prop_title'];//post_title
    $prop_cost = $_REQUEST['prop_cost'];//стоимость
    $prop_square = $_REQUEST['prop_square'];//общая площадь
    $prop_living_square = $_REQUEST['prop_living_square'];//жилая площадь
    $prop_floor = $_REQUEST['prop_floor'];//этаж
    $select_city = $_REQUEST['select_city'];//город
    $prop_address = $_REQUEST['prop_address'];//адрес
    $select_type = $_REQUEST['select_type'];//тип недвижимости
    $prop_content = $_REQUEST['prop_content'];//описание недвижимости

    // Создаем массив данных новой записи
    $post_data = array(
        'post_title'    => wp_strip_all_tags( $post_title),
        'post_status'   => 'publish',
        'post_author'   =>wp_get_current_user()->ID,
        'post_type'   => 'reality',
        'post_content'   => $prop_content,

    );
    $wpdb->query('START TRANSACTION');
    try {

// Вставляем запись в базу данных
        $post_id = wp_insert_post($post_data);
        add_post_meta($post_id, 'стоимость', $prop_cost) .
        add_post_meta($post_id, 'площадь', $prop_square) .
        add_post_meta($post_id, 'жилая_площадь', $prop_living_square) .
        add_post_meta($post_id, 'этаж', $prop_floor) .
        add_post_meta($post_id, 'адрес', $prop_address) .
// соединяем с городом
        $wpdb->insert('wp_p2p', [
            'p2p_from' => $select_city,
            'p2p_to' => $post_id,
            'p2p_type' => 'city_to_reality',
        ], [
            '%d', '%d', '%s',

        ]);
//tax
        $wpdb->insert('wp_term_relationships', [
            'object_id' => $post_id,
            'term_taxonomy_id' => $select_type,
            'term_order' => '0',
        ], [
            '%d', '%d', '%d',

        ]);

        //img
        $response = load_image_from_form_reality($post_id);

        $wpdb->query('COMMIT');
    }catch(Exception $e){
        $wpdb->query('ROLLBACK');
        $response = $e->getMessage();
    }

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
        echo $response;
        wp_die();
    }
}

add_action('wp_ajax_nopriv_add_reality', 'ajax_add_reality_form' );
add_action('wp_ajax_add_reality', 'ajax_add_reality_form' );




function load_image_from_form_reality($post_id)
{
    //if (is_single($post_id))
        return my_sideload_image($post_id);

}
// код функции
    function my_sideload_image($post_id)
    {
            // These files need to be included as dependencies when on the front end.
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );

            // Let WordPress handle the upload.
            // Remember, 'my_image_upload' is the name of our file input in our form above.
            $attachment_id = media_handle_upload( 'prop_image', $post_id );

            if ( is_wp_error( $attachment_id ) ) {
                // There was an error uploading the image.
                return $attachment_id->get_error_message();
            } else {

                // The image was uploaded successfully!

                update_post_meta( $post_id, '_wp_page_template', 'template-reality.php' );
                update_post_meta($post_id, '_thumbnail_id', $attachment_id);
                return 'Сохранение успешно завершено. Объект зарегистрирован с id= ' .$post_id;
            }



}