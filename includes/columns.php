<?php
if(!defined('ABSPATH')) exit;

/**
 * Título de columna shortcode en listado
 */
function dm_sliders_shortcode_column($defaults){
  return dm_sliders_array_insert( $defaults, 2, [
    'shortcode' => 'Shortcode',
    'shortcode_actions' => 'Acciones'
  ]);
}
add_filter('manage_dm_sliders_posts_columns', 'dm_sliders_shortcode_column');

/**
 * Valor de columna shortcode en listado
 */
function dm_sliders_shortcode_column_value($column){
  switch($column){
    case 'shortcode':
      $_id = get_the_ID();
      printf('<span id="dm_sliders_list_shortcode_%1$s">[dm-slider id="%1$s"]', $_id);
    break;
    case 'shortcode_actions':
      $_id = get_the_ID();
      printf('</span><a href="javascript:;" class="dm_sliders_list_copy_action" data-id="%1$s">Copiar shortcode</a>', $_id);
    break;
  }
}
add_filter('manage_dm_sliders_posts_custom_column', 'dm_sliders_shortcode_column_value', 5, 1);