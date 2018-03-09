var map;
function initMap() {
//  console.log(opciones);
  var latlng= {
    lat: parseFloat(opciones.latitud),
    lng: parseFloat(opciones.longitud)
   };
  map = new google.maps.Map(document.getElementById('mapa'), {
    center: latlng,
    zoom: parseInt(opciones.zoom)
  });

  var marker= new google.maps.Marker({
    position: latlng,
    map: map,
    title:'GeekticSoluciones'
  });
}

$ = jQuery.noConflict();
/*funcion qe permite al hacer clic en menu me aparesca con efecto el menus
toggle hace este efecto*/
$(document).ready(function(){


  //ocultar y mostrar menu
  $('.mobile-menu a').on('click', function() {
     $('nav.menu-sitio').toggle('slow');
  });

  /* funcion que hace que se muestre o oculte un menu segun la medida de la ventana*/
  var breakpoint= 768;
  $(window).resize(function(){
    if($(document).width() >= breakpoint)
    {
      $('nav.menu-sitio').show();
    }else {
      $('nav.menu-sitio').hide();
    }
  });

  //ajustar mapa
  var mapa=$('#mapa');
  if(mapa.length >= 0) {
    if($(document).width() >= breakpoint) {
      ajustarMapa(0);
    }else {
      ajustarMapa(300);
    }
  }
   $(window).resize(function(){
     if($(document).width() >= breakpoint){
       ajustarMapa(0);
     }else {
       ajustarMapa(300);
     }
   });

  jQuery('.gallery a').each(function() {
    jQuery(this).attr({'data-fluidbox' : ''});
  });

  if (jQuery('[data-fluidbox]').length > 0) {
      jQuery('[data-fluidbox]').fluidbox();
  }

});

function ajustarMapa(altura) {
  if(altura == 0) {
    var ubicacionSection = $('.ubicacion-reservacion');
    var ubicacionAltura = ubicacionSection.height();
    $('#mapa').css({'height':ubicacionAltura});
  }else {
    $('#mapa').css({'height':altura});
  }
}
