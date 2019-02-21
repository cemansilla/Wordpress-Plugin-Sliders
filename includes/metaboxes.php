<?php
if(!defined('ABSPATH')) exit;

/**
 * Agrego metabox al CPT quizes
 */
function dm_sliders_add_metaboxes(){
  add_meta_box('dm_sliders_meta_box', 'Items del slider', 'dm_sliders_metaboxes', 'dm_sliders', 'normal', 'high', null);
}
add_action('add_meta_boxes', 'dm_sliders_add_metaboxes');

/**
 * Contenido / formulario del CPT sliders
 */
function dm_sliders_metaboxes($post){
  echo "dm_sliders_metaboxes: ";
  d($post);
  echo "dm_sliders_slider (serializado): ";
  $serializado = get_post_meta($post->ID, 'dm_sliders_slider', true);
  echo esc_attr($serializado);
  echo "<br>";

  echo "dm_sliders_slider (unserializado): ";
  $unserializado = maybe_unserialize($serializado);
  d($unserializado);
  echo "<br>";

  wp_nonce_field(basename(__FILE__), 'dm_sliders_nonce');

  $items = array(
    array(
      "img" => "sample-1.jpg"
    ),
    array(
      "img" => "sample-2.jpg"
    ),
    array(
      "img" => "sample-3.jpg"
    ),
    array(
      "img" => "sample-1.jpg"
    ),
    array(
      "img" => "sample-1.jpg"
    )
  );
  $items = array();
  ?>
  <div class="container-fluid">
    <div class="row">
      <form id="dm_sliders_form">
        <!-- Items ya cargados -->
        <?php foreach($items as $i): ?>
        <div class="col-sm-3">
          <div class="card p-1">
            <img class="card-img-top" src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/" . $i["img"]; ?>" alt="...">
            <div class="card-body py-2 px-1 text-center">
              <a href="javascript:;" class="card-link dm_sliders_thumb_action" data-action="edit"><i class="fas fa-edit"></i> Editar</a>
              <a href="javascript:;" class="card-link dm_sliders_thumb_action" data-action="delete"><i class="fas fa-trash"></i> Borrar</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

        <!-- Item de agregar nuevo -->
        <div id="dm_sliders_container_link_add" class="col-sm-3">
          <div class="card p-1">
            <img class="card-img-top" src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/default.png"; ?>" alt="Agregar nuevo">
            <div class="card-body py-2 px-1 text-center">
              <a href="javascript:;" class="card-link dm_sliders_thumb_action" data-action="add"><i class="fas fa-plus"></i> Agregar</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Formulario de carga -->
      <div id="dm_sliders_form-container" class="row d-none mt-5 p-2 bg-secondary text-white rounded">
        <div class="col">
          <input type="hidden" name="dm_sliders">
          <div class="form-group">
            <label>Tipo</label>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="dm_sliders_type" id="dm_sliders_type_1" value="1" checked>
              <label class="form-check-label" for="dm_sliders_type_1">
                Estándar
              </label>
            </div>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="dm_sliders_type" id="dm_sliders_type_2" value="2">
              <label class="form-check-label" for="dm_sliders_type_2">
                2 columnas
              </label>
            </div>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="dm_sliders_type" id="dm_sliders_type_3" value="3">
              <label class="form-check-label" for="dm_sliders_type_3">
                3 columnas
              </label>
            </div>
          </div>

          <div class="form-group">
            <label for="dm_sliders_image" class="">Imagen</label>
            <!-- Apertura de galería -->
            <a href="javascript:;" class="dm_sliders_btn_gallery" id="dm_sliders_image">Abrir galería</a>
            <!-- Imagen por defecto / miniatura -->
            <img id="dm_sliders_preview" src="<?php echo plugin_dir_url(__FILE__) . "../assets/images/default.png"; ?>" alt="..." />
            <!-- Campo oculto para almacenar ID -->
            <input type="hidden" name="dm_sliders_image_id" id="dm_sliders_image_id" value="" />
            
            <small id="passwordHelpBlock" class="form-text text-muted">
              Tamaño recomendado: 1920 x 1080px
            </small>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-8">
                <label for="dm_sliders_global_link" class="">Link</label>
                <input type="text" class="form-control" id="dm_sliders_global_link" name="dm_sliders_global_link" placeholder="https://www.misitio.com/landing">
              </div>
              <div class="col-4">
                <label for="dm_sliders_global_link_target" class="">Nueva ventana</label>
                <input type="checkbox" class="form-control" id="dm_sliders_global_link_target" name="dm_sliders_global_link_target" value="1">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="dm_sliders_content" class="">Texto</label>
            <?php wp_editor( '', 'dm_sliders_content', array(
              'media_buttons' => false,
              'textarea_rows' => 20,
              'editor_height' => 450,
              'editor_class' => 'dm_sliders_editor_class'
            ) ); ?>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-5">
                <label for="dm_sliders_boton_texto" class="">Botón texto</label>
                <input type="url" class="form-control" id="dm_sliders_boton_texto" name="dm_sliders_boton_texto" placeholder="PARTICIPÁ!">
              </div>
              <div class="col-5">
                <label for="dm_sliders_boton_link" class="">Botón link</label>
                <input type="url" class="form-control" id="dm_sliders_boton_link" name="dm_sliders_boton_link" placeholder="https://www.misitio.com/landing">
              </div>
              <div class="col-2">
                <label for="dm_sliders_boton_link_target" class="">Nueva ventana</label>
                <input type="checkbox" class="form-control" id="dm_sliders_boton_link_target" name="dm_sliders_boton_link_target" value="1">
              </div>
            </div>
          </div>

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
    "dm_sliders_type" => $_POST["_dm_sliders_type"],
    "dm_sliders_image_id" => $_POST["_dm_sliders_image_id"],
    "dm_sliders_global_link" => $_POST["_dm_sliders_global_link"],
    "dm_sliders_global_link_target" => $_POST["_dm_sliders_global_link_target"],
    "dm_sliders_content" => $_POST["_dm_sliders_content"],
    "dm_sliders_boton_texto" => $_POST["_dm_sliders_boton_texto"],
    "dm_sliders_boton_link" => $_POST["_dm_sliders_boton_link"],
    "dm_sliders_boton_link_target" => $_POST["_dm_sliders_boton_link_target"]
  );

  update_post_meta($post_id, 'dm_sliders_slider', maybe_serialize($a_data));
}
add_action('save_post', 'dm_sliders_save_metaboxes', 10, 3);