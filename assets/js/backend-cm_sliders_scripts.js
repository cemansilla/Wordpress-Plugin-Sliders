(function($){
  // Listener agregar items de lider
  $('.dm_sliders_thumb_action').on('click', function(){
    switch($(this).data('action')){
      case 'edit':
        console.log("edit");
      break;
      case 'delete':
        console.log("delete");
      break;
      case 'add':
        console.log("add");
        $('#dm_sliders_form-container').removeClass('d-none');
      break;
    }
  });

  // Listener cancelar acción del form del metabox
  $('#dm_sliders_form').on('submit', function(e){
    e.preventDefault();
  });

  // Listener cancelar agregado de item de slider
  $('#dm_sliders_btn-save').on('click', function(e){
    e.preventDefault();

    dm_sliders_alert_reset();
    
    console.log("programar lógica de guardado");
    console.log("tipo", $('#dm_sliders_type_1').val());
    console.log("img", $('#dm_sliders_preview').attr("src"));
    console.log("img id", $('#dm_sliders_image_id').attr("src"));    
    console.log("link", $('#dm_sliders_global_link').val());
    console.log("link target", $('#dm_sliders_global_link_target').is(":checked"));
    console.log("texto editor", $('#dm_sliders_content').val());
    console.log("boton", $('#dm_sliders_boton_texto').val());
    console.log("boton link", $('#dm_sliders_boton_link').val());    
    
    if($('#dm_sliders_image_id').val() != ''){
      var template = '\
      <div class="col-sm-3">\
        <div class="card p-1">\
          <img class="card-img-top" src="'+$('#dm_sliders_preview').attr("src")+'" alt="...">\
          <div class="card-body py-2 px-1 text-center">\
            <a href="javascript:;" class="card-link dm_sliders_thumb_action" data-action="edit"><i class="fas fa-edit"></i> Editar</a>\
            <a href="javascript:;" class="card-link dm_sliders_thumb_action" data-action="delete"><i class="fas fa-trash"></i> Borrar</a>\
          </div>\
        </div>\
      </div>';
      $('#dm_sliders_form-container').addClass('d-none');
      $(template).insertBefore('#dm_sliders_container_link_add');
      $('#dm_sliders_preview').attr('src', '');
      $('#dm_sliders_btn-cancel').trigger('click');
    }else{
      dm_sliders_alert("Debes seleccionar una imagen", "warning");
    }
  });  

  // Listener cancelar agregado de item de slider
  $('#dm_sliders_btn-cancel').on('click', function(e){
    if(!$('#dm_sliders_form-container').hasClass('d-none')){
      $('#dm_sliders_form-container').addClass('d-none');
    }
  });

  // Listener de upload de imágenes
  $('.dm_sliders_btn_gallery').on('click', function(e){
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
})(jQuery);