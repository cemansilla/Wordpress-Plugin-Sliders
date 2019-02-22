<?php
if(!defined('ABSPATH')) exit;

/**
 * Funcionalidad de shortcode
 * Modo de uso:  [dm-slider]
 */
function dm_slider_shortcode( $atts ) {
  $slider_id = (int)$atts["id"];

  $dm_sliders_data_json = get_post_meta($slider_id, 'dm_sliders_slider', true);
  $dm_sliders_data_array = array();  
  if(
    !empty($dm_sliders_data_json) && 
    isset($dm_sliders_data_json["dm_sliders_data"]) &&
    is_array($dm_sliders_data_json["dm_sliders_data"])){
      foreach($dm_sliders_data_json["dm_sliders_data"] as $k => $v){
        $decoded = json_decode($v, true);
        $dm_sliders_data_array[] = $decoded[0];
      }
  }

  $count = count($dm_sliders_data_array);

  ob_start();
  echo "dm_sliders_data_json";
  d($dm_sliders_data_json);
  echo "dm_sliders_data_array";
  d($dm_sliders_data_array);
  ?>
  <header>
    <div id="dm_sliders_carousel" class="carousel slide" data-ride="carousel">
      <!-- Indicadores -->
      <ol class="carousel-indicators">
        <?php for($i = 0; $i < $count; $i++){ ?>
        <li data-target="#dm_sliders_carousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
        <?php } ?>
      </ol>

      <div class="carousel-inner" role="listbox">
        <?php foreach($dm_sliders_data_array as $i => $slide): ?>
        <?php
        /**
         * En este punto ya se cuenta con la info de cada item de slider
         *
         * Tipo: Estandar | 2 columnas | 3 columnas
         * $slide['dm_sliders_type']
         * 
         * Imagen
         * $slide['dm_sliders_preview']
         * 
         * Imagen ID
         * $slide['dm_sliders_image_id']
         * 
         * Link global
         * $slide['dm_sliders_global_link']
         * 
         * Target: _blank | _self. Depende de si el valor es 0 o 1, hay que validar
         * $slide['dm_sliders_global_link_target']
         * 
         * Contenido de editor
         * $slide['dm_sliders_content']
         * 
         * Botón texto
         * $slide['dm_sliders_boton_text']
         * 
         * Botón link: TODO: validar si hay dato agregar link, sino no
         * $slide['dm_sliders_boton_link']
         * 
         * Botón link target. TODO: validar si hay link agregar el target
         * $slide['dm_sliders_boton_link_target']
         */
        ?>
        <div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>" style="background-image: url('<?php echo $slide['dm_sliders_preview']; ?>')">
          <div class="carousel-caption d-none d-md-block">
            <!-- Contenido -->
            <?php echo $slide['dm_sliders_content']; ?>

            <!-- TODO: agregar contenido del comentario de arriba -->
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <a class="carousel-control-prev" href="#dm_sliders_carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">&lt;&lt;</span>
      </a>
      <a class="carousel-control-next" href="#dm_sliders_carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">&gt;&gt;</span>
      </a>
    </div>
  </header>
  <?php
  $html = ob_get_contents();
  ob_end_clean();

  return $html;
}
add_shortcode( 'dm-slider', 'dm_slider_shortcode' );