$=jQuery.noConflict();

$(document).ready(function(){
  //obtener la url de admin-ajax.php
  //console.log(url_eliminar.ajaxurl);

  $('.borrar_registro').on('click',function(e) {
     e.preventDefault();
     var id =$(this).attr('data-reservaciones');
     //console.log(id);
     swal({
       title: 'Estas Seguro?',
       text: "No prodras revertis esta accion!",
       type: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Eliminar',
       cancelButtonText: 'Cancelar'
     }).then((result) => {
       if (result.value) {

                               $.ajax({
                                  type: 'post',
                                  data: {
                                    'action': 'lapizzeria_eliminar',
                                    'id':id,
                                    'tipo':'eliminar'
                                  },
                                  url: url_eliminar.ajaxurl,
                                  success: function(data) {
                                    var resultado = JSON.parse(data);
                                    if(resultado.respuesta == 1) {
                                      jQuery("[data-reservaciones='"+ resultado.id +"']").parent().parent().remove();
                                      swal(
                                            'Eliminado!',
                                            'Reserva Eliminada!',
                                            'success'
                                          )
                                    }

                                  }
                               });

                             }
                          })
    });
  });
