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
        // Proceso contenido de editor para contemplar formatos, shortcodes, etc
        $slide['dm_sliders_content_filter'] = apply_filters('the_content', $slide['dm_sliders_content']);

        /**
         * En este punto ya se cuenta con la info de cada item de slider
         *
         * Tipo: Estandar | 2 columnas | 3 columnas
         * $slide['dm_sliders_type']
         * 
         * * Subtipo, depende del tipo
         * $slide['dm_sliders_subtype']
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
         * Contenido de editor procesado
         * $slide['dm_sliders_content_filter']
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
          <div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>" >
            <a href="<?php echo $slide['dm_sliders_global_link']; ?>" target="<?php echo $slide['dm_sliders_global_link_target']; ?>"><img class="img-fluid" src="<?php echo $slide['dm_sliders_preview'];?>" alt=""></a>
            <div class="carousel-caption d-none d-md-block">
              <!-- Contenido -->
              <?php 
                if ($slide['dm_sliders_type'] == 1) {
                  ?>
                  <!-- Slide de estandar  -->
                  <div class="row">
                    <div class="col-12">
                        <?php echo $slide['dm_sliders_content_filter']; ?>
                        <a class="btn_slide" href="<?php echo $slide['dm_sliders_boton_link']; ?>" target="<?php echo $slide['dm_sliders_boton_link_target']; ?>"><?php echo $slide['dm_sliders_boton_text'];  ?></a>
                    </div>
                  </div>
                <?php }else if ($slide['dm_sliders_type'] == 2){
                  ?>
                  <!-- Slide de 2 columnas  -->
                  <div class="row">
                    <?php
                    if(!isset($slide['dm_sliders_subtype']) || $slide['dm_sliders_subtype'] == "1"){
                      // No hay subtipo almacenado o el subtipo corresponde a la izquierda
                      ?>
                      <div class="col-6">
                        <?php echo $slide['dm_sliders_content_filter']; ?>
                        <a class="btn_slide" href="<?php echo $slide['dm_sliders_boton_link']; ?>" target="<?php echo $slide['dm_sliders_boton_link_target']; ?>"><?php echo $slide['dm_sliders_boton_text'];  ?></a>
                      </div>
                      <div class="col-6"></div>
                      <?php
                    }else{
                      ?>
                      <div class="col-6"></div>
                      <div class="col-6">
                        <?php echo $slide['dm_sliders_content_filter']; ?>
                        <a class="btn_slide" href="<?php echo $slide['dm_sliders_boton_link']; ?>" target="<?php echo $slide['dm_sliders_boton_link_target']; ?>"><?php echo $slide['dm_sliders_boton_text'];  ?></a>
                      </div>                      
                      <?php
                    }
                    ?>                    
                  </div>
                <?php }else if($slide['dm_sliders_type'] == 3){
                  ?>
                  <!-- Slide de 3 columnas  -->
                  <div class="row">
                    <?php
                    if(!isset($slide['dm_sliders_subtype'])){
                      // No hay subtipo almacenado
                      ?>
                      <div class="col-4">
                        <?php echo $slide['dm_sliders_content_filter']; ?>
                        <a class="btn_slide" href="<?php echo $slide['dm_sliders_boton_link']; ?>" target="<?php echo $slide['dm_sliders_boton_link_target']; ?>"><?php echo $slide['dm_sliders_boton_text'];  ?></a>
                      </div>
                      <div class="col-4"></div>
                      <div class="col-4"></div>
                      <?php
                    }else{
                      switch($slide['dm_sliders_subtype']){
                        case "2":
                          ?>
                          <div class="col-4"></div>
                          <div class="col-4">
                            <?php echo $slide['dm_sliders_content_filter']; ?>
                            <a class="btn_slide" href="<?php echo $slide['dm_sliders_boton_link']; ?>" target="<?php echo $slide['dm_sliders_boton_link_target']; ?>"><?php echo $slide['dm_sliders_boton_text'];  ?></a>
                          </div>                          
                          <div class="col-4"></div>
                          <?php
                        break;

                        case "3":
                          ?>                          
                          <div class="col-4"></div>
                          <div class="col-4"></div>
                          <div class="col-4">
                            <?php echo $slide['dm_sliders_content_filter']; ?>
                            <a class="btn_slide" href="<?php echo $slide['dm_sliders_boton_link']; ?>" target="<?php echo $slide['dm_sliders_boton_link_target']; ?>"><?php echo $slide['dm_sliders_boton_text'];  ?></a>
                          </div>
                          <?php
                        break;

                        default:
                          ?>
                          <div class="col-4">
                            <?php echo $slide['dm_sliders_content_filter']; ?>
                            <a class="btn_slide" href="<?php echo $slide['dm_sliders_boton_link']; ?>" target="<?php echo $slide['dm_sliders_boton_link_target']; ?>"><?php echo $slide['dm_sliders_boton_text'];  ?></a>
                          </div>
                          <div class="col-4"></div>
                          <div class="col-4"></div>
                          <?php
                        break;
                      }
                    }
                    ?>                    
                  </div>
                <?php }
              ?>
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