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