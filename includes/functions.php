<?php
if(!defined('ABSPATH')) exit;

/**
 * Dump preformateado
 */
if(!function_exists('d')){
  function d($el){
    echo "<pre>"; print_r($el); echo "</pre>";
  }
}

/**
 * Auxiliar para agregar columas personalizadas en el orden deseado
 */
function dm_sliders_array_insert( $array, $index, $insert ) {
  return array_slice( $array, 0, $index, true ) + $insert +
  array_slice( $array, $index, count( $array ) - $index, true);
}