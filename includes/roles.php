<?php
if(!defined('ABSPATH')) exit;

/**
 * Crea el rol para el plugin
 */
function dm_sliders_create_role(){
  add_role('dmsliders', 'Sliders');
}

/**
 * Elimina el rol para el plugin
 */
function dm_sliders_remove_role(){
  remove_role('dmsliders', 'Sliders');
}

/**
 * Agrega capabilities para el rol
 */
function dm_sliders_add_capabilities() {
	$roles = array( 'administrator', 'editor', 'dmsliders' );

	foreach( $roles as $the_role ) {
    $role = get_role( $the_role );
    if(!is_null($role)){
      $role->add_cap( 'read' );
      $role->add_cap( 'edit_dmsliders' );
      $role->add_cap( 'publish_dmsliders' );
      $role->add_cap( 'edit_published_dmsliders' );
      $role->add_cap( 'edit_others_dmsliders' );
      $role->add_cap( 'delete_dmsliders' );
      $role->add_cap( 'delete_published_dmsliders' );
      $role->add_cap( 'delete_others_dmsliders' );
    }
	}

	$manager_roles = array( 'administrator', 'editor' );

	foreach( $manager_roles as $the_role ) {
    $role = get_role( $the_role );
    if(!is_null($role)){
      $role->add_cap( 'read_private_dmsliders' );
      $role->add_cap( 'edit_others_dmsliders' );
      $role->add_cap( 'edit_private_dmsliders' );
      $role->add_cap( 'delete_dmsliders' );
      $role->add_cap( 'delete_published_dmsliders' );
      $role->add_cap( 'delete_private_dmsliders' );
      $role->add_cap( 'delete_others_dmsliders' );
    }
	}
}

/**
 * Elimina capabilities para el rol
 */
function dm_sliders_remove_capabilities() {
	$manager_roles = array( 'administrator', 'editor' );

	foreach( $manager_roles as $the_role ) {
		$role = get_role( $the_role );
		$role->remove_cap( 'read' );
		$role->remove_cap( 'edit_dmsliders' );
		$role->remove_cap( 'publish_dmsliders' );
		$role->remove_cap( 'edit_published_dmsliders' );
		$role->remove_cap( 'read_private_dmsliders' );
		$role->remove_cap( 'edit_others_dmsliders' );
		$role->remove_cap( 'edit_private_dmsliders' );
		$role->remove_cap( 'delete_dmsliders' );
		$role->remove_cap( 'delete_published_dmsliders' );
		$role->remove_cap( 'delete_private_dmsliders' );
		$role->remove_cap( 'delete_others_dmsliders' );
	}
}