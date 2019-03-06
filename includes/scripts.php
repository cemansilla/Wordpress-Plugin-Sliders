<?php
if(!defined('ABSPATH')) exit;

function dm_sliders_load_bootstrap(){
  wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
  wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.min.js', array( 'jquery' ),'',true );
  wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ),'',true );
  wp_enqueue_script( 'boot3','https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js', array( 'jquery' ),'',true );
}

function dm_sliders_load_font_awesome(){
  wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css');
}

function dm_sliders_load_jquery_ui(){
  wp_enqueue_style('jquery_iu_css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
  wp_enqueue_script( 'jquery_iu_js','https://code.jquery.com/ui/1.12.1/jquery-ui.js', array( 'jquery' ),'',true );
}

function dm_sliders_frontend_scripts(){
  dm_sliders_load_bootstrap();

  wp_enqueue_style('dm_sliders_frontend_css', plugins_url('../assets/css/dm_sliders_style.css', __FILE__), array(), '1.0.1');
  wp_enqueue_script('dm_sliders_frontend_js', plugins_url('../assets/js/dm_sliders_scripts.js', __FILE__), array(), '1.0.1', true);
}
add_action('wp_enqueue_scripts', 'dm_sliders_frontend_scripts');

function dm_sliders_backend_scripts($hook){
  global $post;

  if(!is_null($post) && $post->post_type == 'dm_sliders'){
    switch($hook){
      case 'post-new.php':
      case 'post.php':
        // Enqueue WordPress media scripts
        wp_enqueue_media();
    
        dm_sliders_load_bootstrap();
        dm_sliders_load_font_awesome();
        dm_sliders_load_jquery_ui();
    
        wp_enqueue_style('dm_sliders_backend_css', plugins_url('../assets/css/backend-dm_sliders_style.css', __FILE__), array(), '1.0.0');
        wp_enqueue_script('dm_sliders_backend_js', plugins_url('../assets/js/backend-dm_sliders_scripts.js', __FILE__), array('jquery'), '0.0.8', true);
    
        wp_localize_script('dm_sliders_backend_js', 'admin_url', array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'assets_url' => plugins_url('../assets/', __FILE__)
        ));
      break;
      case 'edit.php':
        wp_enqueue_script('dm_sliders_backend_js', plugins_url('../assets/js/backend-dm_sliders_scripts.js', __FILE__), array('jquery'), '0.0.8', true);
    
        wp_localize_script('dm_sliders_backend_js', 'admin_url', array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'assets_url' => plugins_url('../assets/', __FILE__)
        ));
      break;
    }
  }else if($hook == 'dm_sliders_page_dm_sliders_demo'){
    wp_enqueue_script('dm_sliders_backend_js', plugins_url('../assets/js/backend-dm_sliders_scripts.js', __FILE__), array('jquery'), '0.0.8', true);
    
    wp_localize_script('dm_sliders_backend_js', 'admin_url', array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'assets_url' => plugins_url('../assets/', __FILE__)
    ));
  }
}
add_action('admin_enqueue_scripts', 'dm_sliders_backend_scripts');