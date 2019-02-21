<?php
if(!defined('ABSPATH')) exit;

/**
 * Crea el rol para el plugin
 */
function dm_sliders_create_role(){
  add_role('cmsliders', 'Sliders');
}

/**
 * Elimina el rol para el plugin
 */
function dm_sliders_remove_role(){
  remove_role('cmsliders', 'Sliders');
}

/**
 * Agrega capabilities para el rol
 */
function dm_sliders_add_capabilities() {
	$roles = array( 'administrator', 'editor', 'cmsliders' );

	foreach( $roles as $the_role ) {
    $role = get_role( $the_role );
    if(!is_null($role)){
      $role->add_cap( 'read' );
      $role->add_cap( 'edit_cmsliders' );
      $role->add_cap( 'publish_cmsliders' );
      $role->add_cap( 'edit_published_cmsliders' );
      $role->add_cap( 'edit_others_cmsliders' );
      $role->add_cap( 'delete_cmsliders' );
      $role->add_cap( 'delete_published_cmsliders' );
      $role->add_cap( 'delete_others_cmsliders' );
    }
	}

	$manager_roles = array( 'administrator', 'editor' );

	foreach( $manager_roles as $the_role ) {
    $role = get_role( $the_role );
    if(!is_null($role)){
      $role->add_cap( 'read_private_cmsliders' );
      $role->add_cap( 'edit_others_cmsliders' );
      $role->add_cap( 'edit_private_cmsliders' );
      $role->add_cap( 'delete_cmsliders' );
      $role->add_cap( 'delete_published_cmsliders' );
      $role->add_cap( 'delete_private_cmsliders' );
      $role->add_cap( 'delete_others_cmsliders' );
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
		$role->remove_cap( 'edit_cmsliders' );
		$role->remove_cap( 'publish_cmsliders' );
		$role->remove_cap( 'edit_published_cmsliders' );
		$role->remove_cap( 'read_private_cmsliders' );
		$role->remove_cap( 'edit_others_cmsliders' );
		$role->remove_cap( 'edit_private_cmsliders' );
		$role->remove_cap( 'delete_cmsliders' );
		$role->remove_cap( 'delete_published_cmsliders' );
		$role->remove_cap( 'delete_private_cmsliders' );
		$role->remove_cap( 'delete_others_cmsliders' );
	}
}