<?php
if(!defined('ABSPATH')) exit;

/**
 * CPT de Sliders
 */
function dm_sliders_post_type() {
  $labels = array(
      'name'                  => _x( 'Slider', 'Post type general name', 'dm_sliders' ),
      'singular_name'         => _x( 'Slider', 'Post type singular name', 'dm_sliders' ),
      'menu_name'             => _x( 'Sliders', 'Admin Menu text', 'dm_sliders' ),
      'name_admin_bar'        => _x( 'Slider', 'Add New on Toolbar', 'dm_sliders' ),
      'add_new'               => __( 'Agregar nuevo', 'dm_sliders' ),
      'add_new_item'          => __( 'Agregar nuevo Slider', 'dm_sliders' ),
      'new_item'              => __( 'Nuevo Slider', 'dm_sliders' ),
      'edit_item'             => __( 'Editar Slider', 'dm_sliders' ),
      'view_item'             => __( 'Ver Slider', 'dm_sliders' ),
      'all_items'             => __( 'Todos Sliders', 'dm_sliders' ),
      'search_items'          => __( 'Buscar Sliders', 'dm_sliders' ),
      'parent_item_colon'     => __( 'Padre Sliders:', 'dm_sliders' ),
      'not_found'             => __( 'No encontrados.', 'dm_sliders' ),
      'not_found_in_trash'    => __( 'No encontrados.', 'dm_sliders' ),
      'featured_image'        => _x( 'Imagen Destacada', '', 'dm_sliders' ),
      'set_featured_image'    => _x( 'Añadir imagen destacada', '', 'dm_sliders' ),
      'remove_featured_image' => _x( 'Borrar imagen', '', 'dm_sliders' ),
      'use_featured_image'    => _x( 'Usar como imagen', '', 'dm_sliders' ),
      'archives'              => _x( 'Sliders Archivo', '', 'dm_sliders' ),
      'insert_into_item'      => _x( 'Insertar en Slider', '', 'dm_sliders' ),
      'uploaded_to_this_item' => _x( 'Cargado en este Slider', '', 'dm_sliders' ),
      'filter_items_list'     => _x( 'Filtrar Sliders por lista', '”. Added in 4.4', 'dm_sliders' ),
      'items_list_navigation' => _x( 'Navegación de Sliders', '', 'dm_sliders' ),
      'items_list'            => _x( 'Lista de Sliders', '', 'dm_sliders' ),
  );

  $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => 'cm-sliders' ),
      'capability_type'    => array('cmslider', 'cmsliders'),
      'menu_position'      => 6,
      'menu_icon'          => 'dashicons-welcome-learn-more',
      'has_archive'        => false,
      'hierarchical'       => false,
      'supports'           => array( 'title'),
      'map_meta_cap'       => true
  );

  register_post_type( 'dm_sliders', $args );
}
add_action( 'init', 'dm_sliders_post_type' );

/**
 * Flush rewrite
 * Simula la actualización de permalinks
 */
function dm_sliders_rewrite_flush(){
  dm_sliders_post_type();
  flush_rewrite_rules();
}