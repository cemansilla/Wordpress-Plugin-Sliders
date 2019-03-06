<?php
if(!defined('ABSPATH')) exit;

// Ajax action to refresh the user image
function dm_sliders_get_image() {
  if(isset($_GET['id']) ){
    $image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', false, array( 'id' => 'dm_sliders-preview-image' ) );
    $data = array(
        'image'    => $image,
    );
    wp_send_json_success( $data );
  } else {
    wp_send_json_error();
  }
}
add_action('wp_ajax_nopriv_dm_sliders_get_image', 'dm_sliders_get_image');  // Habilito para deslogueados
add_action('wp_ajax_dm_sliders_get_image', 'dm_sliders_get_image');         // Habilito para logueados

// Ajax action to refresh the user image
function dm_sliders_load_demo_content() {
  try{
    /**
     * Insert post
     */
    $user_id = get_current_user_id();

    $my_post = array();
    $my_post['post_title']    = 'Slider demo #' . uniqid();
    $my_post['post_content']  = '';
    $my_post['post_status']   = 'publish';
    $my_post['post_author']   = $user_id;
    $my_post['post_category'] = array(0);
    $my_post['post_type'] = 'dm_sliders';

    $post_id = wp_insert_post($my_post);

    /**
     * Upload images to gallery
     */
    // Source path
    $files_path = plugin_dir_path(__FILE__).'../assets/images/demo/';
    // Files count, one per type
    $files_count = 3;
    // Parent post
    $parent_post_id = $post_id;
    // Upload path
    $wp_upload_dir = wp_upload_dir();

    // Init postmeta
    $_dm_sliders_data = array();

    // Sample postmeta
    $sample_postmeta = array(
      1 => array(
        'dm_sliders_global_link' => 'https://www.sampleurl.com/fake-uri',
        'dm_sliders_global_link_target' => '_blank',
        'dm_sliders_content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
        'dm_sliders_boton_text' => 'Consequuntur id',
        'dm_sliders_boton_link' => 'https://www.sampleurl.com/fake-uri',
        'dm_sliders_boton_link_target' => '_blank'
      ),
      2 => array(
        'dm_sliders_global_link' => 'https://www.sampleurl.com/fake-uri',
        'dm_sliders_global_link_target' => '_self',
        'dm_sliders_content' => '',
        'dm_sliders_boton_text' => 'In repudiandae',
        'dm_sliders_boton_link' => 'https://www.sampleurl.com/fake-uri',
        'dm_sliders_boton_link_target' => '_self'
      ),
      3 => array(
        'dm_sliders_global_link' => '',
        'dm_sliders_global_link_target' => false,
        'dm_sliders_content' => 'ipsum maiores aspernatur officiis',
        'dm_sliders_boton_text' => '',
        'dm_sliders_boton_link' => '',
        'dm_sliders_boton_link_target' => false
      )
    );

    for($i = 1; $i <= $files_count; $i++){
      $_prefix = uniqid();

      $source_file_name = 'dm-sliders-sample-' . $i . '.jpg';
      $source_file_path = $files_path . $source_file_name;

      $file_name = $_prefix . '-' . $source_file_name;

      $filetype = wp_check_filetype( basename( $source_file_path ), null );    

      $attachment = array(
        'guid'           => $wp_upload_dir['url'] . '/' . $file_name, 
        'post_mime_type' => $filetype['type'],
        'post_title'     => $file_name,
        'post_content'   => '',
        'post_status'    => 'inherit'
      );

      $attach_id = wp_insert_attachment( $attachment, false, $parent_post_id );

      require_once( ABSPATH . 'wp-admin/includes/image.php' );

      $attach_data = wp_generate_attachment_metadata( $attach_id, $source_file_path );
      wp_update_attachment_metadata( $attach_id, $attach_data );
      
      $destination = $wp_upload_dir['path'] . '/'. $file_name;
      copy($source_file_path, $destination);

      $tmp_data = array(
        'dm_sliders_type' => $i,
        'dm_sliders_preview' => $wp_upload_dir['url'] . '/' . $file_name,
        'dm_sliders_image_id' => $attach_id,
        'dm_sliders_global_link' => $sample_postmeta[$i]['dm_sliders_global_link'],
        'dm_sliders_global_link_target' => $sample_postmeta[$i]['dm_sliders_global_link_target'],
        'dm_sliders_content' => $sample_postmeta[$i]['dm_sliders_content'],
        'dm_sliders_boton_text' => $sample_postmeta[$i]['dm_sliders_boton_text'],
        'dm_sliders_boton_link' => $sample_postmeta[$i]['dm_sliders_boton_link'],
        'dm_sliders_boton_link_target' => $sample_postmeta[$i]['dm_sliders_boton_link_target']
      );

      $_dm_sliders_data[($i-1)] = json_encode([$tmp_data]);
    }
    
    /**
     * Insert postmeta
     */
    $a_data = array(
      "dm_sliders_data" => $_dm_sliders_data
    );
    update_post_meta($post_id, 'dm_sliders_slider', ($a_data));

    wp_send_json_success();
  }catch(Exception $e){
    wp_send_json_error();
  }
}
add_action('wp_ajax_nopriv_dm_sliders_load_demo_content', 'dm_sliders_load_demo_content');  // Habilito para deslogueados
add_action('wp_ajax_dm_sliders_load_demo_content', 'dm_sliders_load_demo_content');         // Habilito para logueados