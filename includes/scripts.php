<?php
if(!defined('ABSPATH')) exit;

function load_bootstrap(){
  wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
  wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.min.js', array( 'jquery' ),'',true );
  wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ),'',true );
  wp_enqueue_script( 'boot3','https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ),'',true );
}

function load_font_awesome(){
  wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css');
}

function dm_sliders_frontend_scripts(){
  load_bootstrap();

  wp_enqueue_style('dm_sliders_frontend_css', plugins_url('../assets/css/dm_sliders_style.css', __FILE__), array(), '1.0.1');
  wp_enqueue_script('dm_sliders_frontend_js', plugins_url('../assets/js/dm_sliders_scripts.js', __FILE__), array(), '1.0.1', true);
}
add_action('wp_enqueue_scripts', 'dm_sliders_frontend_scripts');

function dm_sliders_backend_scripts($hook){
  global $post;

  if($hook == 'post-new.php' || $hook == 'post.php'){
    if($post->post_type == 'dm_sliders'){
      // Enqueue WordPress media scripts
      wp_enqueue_media();

      load_bootstrap();
      load_font_awesome();

      wp_enqueue_style('dm_sliders_backend_css', plugins_url('../assets/css/backend-dm_sliders_style.css', __FILE__), array(), '1.0.0');
      wp_enqueue_script('dm_sliders_backend_js', plugins_url('../assets/js/backend-dm_sliders_scripts.js', __FILE__), array('jquery'), '0.0.1', true);

      wp_localize_script('dm_sliders_backend_js', 'admin_url', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'assets_url' => plugins_url('../assets/', __FILE__)
      ));
    }    
  }
}
add_action('admin_enqueue_scripts', 'dm_sliders_backend_scripts');