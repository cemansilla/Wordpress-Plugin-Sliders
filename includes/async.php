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