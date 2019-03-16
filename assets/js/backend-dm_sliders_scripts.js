(function($){
  $(document).ready(function(){
    if($('#dm_sliders_sortable').length > 0)
      $('#dm_sliders_sortable').sortable();
  });

  // Listener copiar shortcode
  $(document).on('click', '.dm_sliders_list_copy_action', function(){
    var id_to_copy = 'dm_sliders_list_shortcode_' + $(this).data('id');

    copyClipboard(id_to_copy);
  });

  // Listener agregar items de lider
  $(document).on('click', '.dm_sliders_thumb_action', function(){
    switch($(this).data('action')){
      case 'add':
        $('#dm_sliders_form-container').removeClass('d-none');
      break;

      case 'edit':
        var _index = $(this).closest('li.dm_sliders-item_container').index();
        if($('#dm_sliders_hidden_edit_index').length == 0){
          $('#dm_sliders_form-container').append($('<input></input>').attr('id', 'dm_sliders_hidden_edit_index').attr('type', 'hidden').attr('value', _index));
        }else{
          $('#dm_sliders_hidden_edit_index').val(_index);
        }

        var hidden_value = $(this).closest('li.dm_sliders-item_container').find('input._dm_sliders_data').val();
        var hidden_value_arr = JSON.parse(hidden_value);

        // Proceso los campos para setearles valor
        // Radio tipo
        $('input:radio[name=dm_sliders_type]').filter('[value='+hidden_value_arr[0].dm_sliders_type+']').prop('checked', true);

        // Radio subtipo
        if(!$('.subtypes-container').hasClass('d-none')){
          $('.subtypes-container').addClass('d-none');
        }

        if(!$('.subtype-2-cols').hasClass('d-none')){
          $('.subtype-2-cols').addClass('d-none');
        }

        if(!$('.subtype-3-cols').hasClass('d-none')){
          $('.subtype-3-cols').addClass('d-none');
        }

        if(hidden_value_arr[0].dm_sliders_type == 2 || hidden_value_arr[0].dm_sliders_type == 3){
          $('.subtype-'+hidden_value_arr[0].dm_sliders_type+'-cols').removeClass('d-none');
          $('#dm_sliders_subtype_'+hidden_value_arr[0].dm_sliders_type+'_'+hidden_value_arr[0].dm_sliders_subtype).prop('checked', true);
          $('.subtypes-container').removeClass('d-none');
        }

        // Info imagen
        $('#dm_sliders_preview').attr('src', hidden_value_arr[0].dm_sliders_preview);
        $('#dm_sliders_image_id').val(hidden_value_arr[0].dm_sliders_image_id);

        // Link
        $('#dm_sliders_global_link').val(hidden_value_arr[0].dm_sliders_global_link);
        var dm_sliders_global_link_target = hidden_value_arr[0].dm_sliders_global_link_target;
        $('#dm_sliders_global_link_target').prop('checked', dm_sliders_global_link_target);
        
        // Editor
        $('#dm_sliders_content').val(hidden_value_arr[0].dm_sliders_content);

        // Botón
        $('#dm_sliders_boton_link').val(hidden_value_arr[0].dm_sliders_boton_link);
        $('#dm_sliders_boton_text').val(hidden_value_arr[0].dm_sliders_boton_text);
        var dm_sliders_boton_link_target = hidden_value_arr[0].dm_sliders_boton_link_target;
        $('#dm_sliders_boton_link_target').prop('checked', dm_sliders_boton_link_target);

        // Muestro el formulario
        $('#dm_sliders_form-container').removeClass('d-none');
      break;      
      
      case 'delete':
        $(this).closest('li.dm_sliders-item_container').remove();
        $('#dm_sliders_btn-cancel').trigger('click');
      break;
    }
  });

  // Listener cancelar acción del form del metabox
  $('#dm_sliders_form').on('submit', function(e){
    e.preventDefault();
  });

  // Listener guardar agregado de item de slider
  $(document).on('click', '#dm_sliders_btn-save', function(e){
    e.preventDefault();

    dm_sliders_alert_reset();

    var _item_data = [];
    _item_data.push({
      dm_sliders_type: $("input[name='dm_sliders_type']:checked").val(),
      dm_sliders_subtype: $("input[name='dm_sliders_subtype']:checked").val(),
      dm_sliders_preview: $('#dm_sliders_preview').attr("src"),
      dm_sliders_image_id: $('#dm_sliders_image_id').val(),
      dm_sliders_global_link: $('#dm_sliders_global_link').val(),
      dm_sliders_global_link_target: $('#dm_sliders_global_link_target').is(":checked"),
      dm_sliders_content: $('#dm_sliders_content').val(),
      dm_sliders_boton_text: $('#dm_sliders_boton_text').val(),
      dm_sliders_boton_link: $('#dm_sliders_boton_link').val(),
      dm_sliders_boton_link_target: $('#dm_sliders_boton_link_target').is(":checked")
    });
    
    if($('#dm_sliders_image_id').val() != ''){
      var template = "\
      <li class='dm_sliders-item_container ui-sortable-handle'>\
        <input type='hidden' class='_dm_sliders_data' name='_dm_sliders_data[]' value='"+JSON.stringify(_item_data)+"' />\
        <div class='card p-1'>\
          <div class='img-card'>\
            <img class='img-miniatura' src='"+$('#dm_sliders_preview').attr("src")+"' alt='...'>\
          </div>\
          <div class='card-body py-2 px-1 text-center'>\
            <a href='javascript:;' class='card-link dm_sliders_thumb_action' data-action='edit'><i class='fas fa-edit'></i> Editar</a>\
            <a href='javascript:;' class='card-link dm_sliders_thumb_action' data-action='delete'><i class='fas fa-trash'></i> Borrar</a>\
          </div>\
        </div>\
      </li>";

      if($('#dm_sliders_hidden_edit_index').length == 0){
        $('#dm_sliders_sortable').append(template);
      }else{
        $('li.dm_sliders-item_container:eq('+$('#dm_sliders_hidden_edit_index').val()+')').replaceWith($(template));
      }      

      $('#dm_sliders_form-container').addClass('d-none');      
      $('#dm_sliders_preview').attr('src', admin_url.assets_url + 'images/default.png');
      $('#dm_sliders_btn-cancel').trigger('click');
      $('#dm_sliders_hidden_edit_index').remove();
    }else{
      dm_sliders_alert("Debes seleccionar una imagen", "warning");
    }
  });  

  // Listener cancelar agregado de item de slider
  $(document).on('click', '#dm_sliders_btn-cancel', function(e){
    if(!$('#dm_sliders_form-container').hasClass('d-none')){
      $('#dm_sliders_form-container').addClass('d-none');
    }

    $('#dm_sliders_preview').attr('src', admin_url.assets_url + 'images/default.png');
  });

  $(document).on('change', 'input[name=dm_sliders_type]', function(){
    switch($(this).val()){
      case "2":
        if(!$('.subtype-3-cols').hasClass('d-none')){
          $('.subtype-3-cols').addClass('d-none');
        }

        $('#dm_sliders_subtype_2_1').prop('checked', true);

        $('.subtype-2-cols').removeClass('d-none');
        $('.subtypes-container').removeClass('d-none');
      break;

      case "3":
        if(!$('.subtype-2-cols').hasClass('d-none')){
          $('.subtype-2-cols').addClass('d-none');
        }

        $('#dm_sliders_subtype_3_1').prop('checked', true);

        $('.subtype-3-cols').removeClass('d-none');
        $('.subtypes-container').removeClass('d-none');
      break;

      default:
        if(!$('subtypes-container').hasClass('d-none')){
          $('.subtypes-container').addClass('d-none');
        }
      break;
    }
  });

  // Listener de upload de imágenes
  $(document).on('click', '.dm_sliders_btn_gallery', function(e){
    e.preventDefault();
    var image_frame;
    if(image_frame){
      image_frame.open();
    }
    // Define image_frame as wp.media object
    image_frame = wp.media({
      title: 'Elegir imagen',
      multiple : false,
      library : {
        type : 'image',
      }
    });

    image_frame.on('close',function() {
      // On close, get selections and save to the hidden input
      // plus other AJAX stuff to refresh the image preview
      var selection =  image_frame.state().get('selection');
      var gallery_ids = new Array();
      var my_index = 0;
      selection.each(function(attachment) {
        gallery_ids[my_index] = attachment['id'];
        my_index++;
      });
      var ids = gallery_ids.join(",");
      $('input#dm_sliders_image_id').val(ids);
      dm_sliders_refresh_image(ids);
    });

    image_frame.on('open',function() {
      // On open, get the id from the hidden input
      // and select the appropiate images in the media manager
      var selection =  image_frame.state().get('selection');
      var ids = $('input#dm_sliders_image_id').val().split(',');
      ids.forEach(function(id) {
        var attachment = wp.media.attachment(id);
        attachment.fetch();
        selection.add( attachment ? [ attachment ] : [] );
      });
    });

    image_frame.open();
  });
  // Ajax request to refresh the image preview
  function dm_sliders_refresh_image(the_id){
    var data = {
      action: 'dm_sliders_get_image',
      id: the_id
    };

    $.ajax({
      url: admin_url.ajax_url,
      type: 'get',
      data: data
    })
    .done(function(response){
      if(response.success === true) {
        $('#dm_sliders_preview').attr('src', $(response.data.image).attr('src'));
      }
    });
  }
  
  /**
   * Alertas personalizados
   * 
   * @param string message
   * @param string type
   * Bootstrap: success | danger | warning | info
   */
  function dm_sliders_alert(message, type){
    dm_sliders_alert_reset();

    $('#dm_sliders_form_alert').html(message);
    $('#dm_sliders_form_alert').attr('class', 'alert alert-'+type);

    setTimeout(function(){
      dm_sliders_alert_reset();
    }, 2000);
  }

  /**
  *  Reseteo estilos de alerta
  */
  function dm_sliders_alert_reset(){
    $('#dm_sliders_form_alert').attr('class', 'd-none alert');
  }

  /**
   *
   *
   */
  $('#dm_sliders_btn_load_demo_content').on('click', function() {
    var btn = $(this);

    if(!btn.data('proccesed')){
      btn.attr('disabled', true);
      btn.find('span.spinner-text').html('Cargando...');    
      btn.find('span.spinner-border').removeClass('d-none');
      btn.attr('data-proccesed', true);
      
      dm_sliders_load_demo_content(btn);
    }
  });

  function dm_sliders_load_demo_content(btn){
    var data = {
      action: 'dm_sliders_load_demo_content'
    };

    $.ajax({
      url: admin_url.ajax_url,
      type: 'post',
      data: data
    })
    .done(function(response){
      if(response.success === true) {
        btn.attr('class', 'btn btn-success');
        btn.find('span.spinner-text').html('Proceso exitoso!');
      }else{
        btn.attr('class', 'btn btn-danger');
        btn.find('span.spinner-text').html('Algo ha fallado');
      }

      btn.attr('disabled', false);
      btn.find('span.spinner-border').addClass('d-none');
    });
  }
})(jQuery);

/**
 * Copia el contenido del elemento cuyo id sea pasado como parámetro
 */
function copyClipboard(id_el) {
  var elm = document.getElementById(id_el);
  
  if(document.body.createTextRange) {   // Internet Explorer
    var range = document.body.createTextRange();
    range.moveToElementText(elm);
    range.select();
    document.execCommand("Copy");
    alert("Shortcode copiado");
  }else if(window.getSelection) {       // Other browsers
    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(elm);
    selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand("Copy");
    alert("Shortcode copiado");
  }

  // Unselect
  if (window.getSelection) {
    window.getSelection().removeAllRanges();
  } else if (document.selection) {
    document.selection.empty();
  }
}