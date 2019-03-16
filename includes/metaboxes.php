<?php
if(!defined('ABSPATH')) exit;

/**
 * Agrego metabox al CPT sliders
 */
function dm_sliders_add_metaboxes(){
  add_meta_box('dm_sliders_meta_box', 'Items del slider', 'dm_sliders_metaboxes', 'dm_sliders', 'normal', 'high', null);
}
add_action('add_meta_boxes', 'dm_sliders_add_metaboxes');

/**
 * Contenido / formulario del CPT sliders
 */
function dm_sliders_metaboxes($post){
  $dm_sliders_data_json = get_post_meta($post->ID, 'dm_sliders_slider', true);

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

  wp_nonce_field(basename(__FILE__), 'dm_sliders_nonce');
  ?>
  <div class="container-fluid">
    <div class="row">
      <form id="dm_sliders_form">
        <!-- Items ya cargados -->
        <div class="col-12">
          <ul id="dm_sliders_sortable" class="iten-cargados">
            <?php foreach($dm_sliders_data_array as $k => $v): ?>
            <li class="dm_sliders-item_container">              
                <input type="hidden" class="_dm_sliders_data" name="_dm_sliders_data[]" value='<?php echo json_encode(array($v)); ?>' />
                <div class="card p-1">
                  <div class="img-card">
                    <img class="img-miniatura" src="<?php echo $v["dm_sliders_preview"]; ?>" alt="...">
                  </div>
                  <div class="card-body py-2 px-1 text-center">
                    <a href="javascript:;" class="card-link dm_sliders_thumb_action" data-action="edit"><i class="fas fa-edit"></i> Editar</a>
                    <a href="javascript:;" class="card-link dm_sliders_thumb_action" data-action="delete"><i class="fas fa-trash"></i> Borrar</a>
                  </div>
                </div>                
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        
        <div class="col-12">
        <!-- Item de agregar nuevo -->
          <div id="dm_sliders_container_link_add">
            <div class="card p-1">
              <div class="img-card">
                <img class="img-miniatura" src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/default.png"; ?>" alt="Agregar nuevo">
              </div>
              <div class="card-body py-2 px-1 text-center">
                <a href="javascript:;" class="card-link dm_sliders_thumb_action" data-action="add"><i class="fas fa-plus"></i> Agregar</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Formulario de carga -->
      <div id="dm_sliders_form-container" class="row d-none mt-5">
        <div class="col-12 my-3">          
          <input type="hidden" name="dm_sliders">
          <div class="form-group">
            <div class="row">
              <div class="col-1">
                <label>Tipo</label>
              </div>
              <div class="col-11">
                <div class="form-check-inline cont-tipo">
                  <img src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/estandar.png"; ?>" alt="">
                  <input class="form-check-input" type="radio" name="dm_sliders_type" id="dm_sliders_type_1" value="1" checked>
                  <label class="form-check-label" for="dm_sliders_type_1">
                      Estándar                    
                  </label>
                </div>
                <div class="form-check-inline cont-tipo">
                  <img src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/2columnas.png"; ?>" alt="">
                  <input class="form-check-input" type="radio" name="dm_sliders_type" id="dm_sliders_type_2" value="2">
                  <label class="form-check-label" for="dm_sliders_type_2">
                    2 Columnas
                  </label>
                </div>
                <div class="form-check-inline cont-tipo">
                  <img src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/3columnas.png"; ?>" alt="">
                  <input class="form-check-input" type="radio" name="dm_sliders_type" id="dm_sliders_type_3" value="3">
                  <label class="form-check-label" for="dm_sliders_type_3">
                    3 Columnas
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-1"></div>
            <div class="col-11 subtypes-container d-none">
              <div class="form-check-inline cont-tipo subtype-2-cols d-none">
                <img src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/2columnas-left.png"; ?>" alt="">
                <input class="form-check-input" type="radio" name="dm_sliders_subtype" id="dm_sliders_subtype_2_1" value="1">
                <label class="form-check-label" for="dm_sliders_subtype_2_1">
                    Left                    
                </label>
              </div>
              <div class="form-check-inline cont-tipo subtype-2-cols d-none">
                <img src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/2columnas-right.png"; ?>" alt="">
                <input class="form-check-input" type="radio" name="dm_sliders_subtype" id="dm_sliders_subtype_2_2" value="2">
                <label class="form-check-label" for="dm_sliders_subtype_2_2">
                    Right                    
                </label>
              </div>
              <div class="form-check-inline cont-tipo subtype-3-cols d-none">
                <img src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/3columnas-left.png"; ?>" alt="">
                <input class="form-check-input" type="radio" name="dm_sliders_subtype" id="dm_sliders_subtype_3_1" value="1">
                <label class="form-check-label" for="dm_sliders_subtype_3_1">
                    Left                    
                </label>
              </div>
              <div class="form-check-inline cont-tipo subtype-3-cols d-none">
                <img src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/3columnas-center.png"; ?>" alt="">
                <input class="form-check-input" type="radio" name="dm_sliders_subtype" id="dm_sliders_subtype_3_2" value="2">
                <label class="form-check-label" for="dm_sliders_subtype_3_2">
                    Center                    
                </label>
              </div>
              <div class="form-check-inline cont-tipo subtype-3-cols d-none">
                <img src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/3columnas-right.png"; ?>" alt="">
                <input class="form-check-input" type="radio" name="dm_sliders_subtype" id="dm_sliders_subtype_3_3" value="3">
                <label class="form-check-label" for="dm_sliders_subtype_3_3">
                    Right                    
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 my-3">          
          <div class="form-group">
            <div class="row">
              <div class="col-1">
                <label for="dm_sliders_image" class="">Imagen</label>
              </div>
              <div class="col-11">
                <div class="form-check-inline">
                  <div class="card p-1">
                      <div class="img-card">
                        <!-- Imagen por defecto / miniatura -->
                        <img class="img-miniatura" id="dm_sliders_preview" src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/default.png"; ?>" alt="..." />
                      </div>
                      <div class="card-body py-2 px-1 text-center">
                        <!-- Apertura de galería -->
                        <a href="javascript:;" class="dm_sliders_btn_gallery" id="dm_sliders_image">Abrir galería</a>
                      </div>                  
                  </div>              
                </div>
                <!-- Campo oculto para almacenar ID -->
                <input type="hidden" name="dm_sliders_image_id" id="dm_sliders_image_id" value="" />
                <p id="passwordHelpBlock" class="form-text text-muted">Tamaño recomendado: 1920 x 1080px</p>
              </div>
            </div>                      
          </div>
        </div>
        <div class="col-12 my-3">
          <div class="form-group">
            <div class="row">
              <div class="col-1">
                <label for="dm_sliders_global_link" class="">Link</label>
              </div>
              <div class="col-7">                
                <input type="text" class="form-control" id="dm_sliders_global_link" name="dm_sliders_global_link" placeholder="https://www.misitio.com/landing">
              </div>
              <div class="col-4">                
                <input type="checkbox" class="form-control" id="dm_sliders_global_link_target" name="dm_sliders_global_link_target" value="1">
                <label for="dm_sliders_global_link_target" ><em>Abrir enlace en una pestaña nueva</em></label>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 my-3">
          <div class="form-group">
            <div class="row">
              <div class="col-1">
                <label for="dm_sliders_content" class="">Texto</label>
              </div>
              <div class="col-11">
                <?php wp_editor( '', 'dm_sliders_content', array(
                  'media_buttons' => false,
                  'textarea_rows' => 20,
                  'editor_height' => 450,
                  'editor_class' => 'dm_sliders_editor_class'
                ) ); ?>
              </div>
            </div>                  
          </div>
        </div>          
        <div class="col-12 my-3">
          <div class="form-group">
            <div class="row">
              <div class="col-1">
                <label for="dm_sliders_boton_text" class="">Botón texto</label>
              </div>
              <div class="col-3">                  
                <input type="text" class="form-control" id="dm_sliders_boton_text" name="dm_sliders_boton_text" placeholder="PARTICIPÁ!">
              </div>
              <div class="col-1">
                <label for="dm_sliders_boton_link" class="">Botón link</label>
              </div>
              <div class="col-3">                  
                <input type="url" class="form-control" id="dm_sliders_boton_link" name="dm_sliders_boton_link" placeholder="https://www.misitio.com/landing">
              </div>
              <div class="col-4">                
                <input type="checkbox" class="form-control" id="dm_sliders_boton_link_target" name="dm_sliders_boton_link_target" value="1">
                <label for="dm_sliders_boton_link_target" class=""><em>Abrir enlace en una pestaña nueva</em></label>
              </div>
            </div>
          </div>
        </div>    
        <div class="col-12 my-3">         
          <div class="d-none alert" role="alert" id="dm_sliders_form_alert"></div>
          <button id="dm_sliders_btn-save" class="btn btn-primary">Guardar Item</button>
          <button type="reset" id="dm_sliders_btn-cancel" class="btn btn-danger">Cancelar</button> 
        </div>       
      </form>
    </div>
  </div>  
  <?php
}

/**
 * Almacenamiento de metaboxes de quizes
 */
function dm_sliders_save_metaboxes($post_id, $post, $update){
  // Validación de seguridad con nonce
  if(!isset($_POST['dm_sliders_nonce']) || !wp_verify_nonce($_POST['dm_sliders_nonce'], basename(__FILE__))){
    return $post_id;
  }

  // Validación de seguridad con permisos de usuario
  if(!current_user_can('edit_post', $post_id)){
    return $post_id;
  }

  // Validación de seguridad evitando autoguardado
  if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
    return $post_id;
  }

  $a_data = array(
    "dm_sliders_data" => $_POST["_dm_sliders_data"]
  );

  update_post_meta($post_id, 'dm_sliders_slider', ($a_data));
}
add_action('save_post', 'dm_sliders_save_metaboxes', 10, 3);