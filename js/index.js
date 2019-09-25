/*
  Creación de una función personalizada para jQuery que detecta cuando se detiene el scroll en la página
*/
$.fn.scrollEnd = function(callback, timeout) {
  $(this).scroll(function(){
    var $this = $(this);
    if ($this.data('scrollTimeout')) {
      clearTimeout($this.data('scrollTimeout'));
    }
    $this.data('scrollTimeout', setTimeout(callback,timeout));
  });
};
/*
  Función que inicializa el elemento Slider
*/

function inicializarSlider(){
  $("#rangoPrecio").ionRangeSlider({
    type: "double",
    grid: false,
    min: 0,
    max: 100000,
    from: 200,
    to: 80000,
    prefix: "$"
  });
}
/*
  Función que reproduce el video de fondo al hacer scroll, y deteiene la reproducción al detener el scroll
*/
function playVideoOnScroll(){
  var ultimoScroll = 0,
      intervalRewind;
  var video = document.getElementById('vidFondo');
  $(window)
    .scroll((event)=>{
      var scrollActual = $(window).scrollTop();
      if (scrollActual > ultimoScroll){
       video.play();
     } else {
        //this.rewind(1.0, video, intervalRewind);
        video.play();
     }
     ultimoScroll = scrollActual;
    })
    .scrollEnd(()=>{
      video.pause();
    }, 10)
}

function inicializarCiudades(){
	var form_data = new FormData();
	form_data.append('initData', "1");
	$.ajax({
		url: './src/orquestaData.php',
		type: 'POST',
		dataType: 'json', 
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		success: function(data, ms, settings){
				var div = document.getElementById('selectCiudad');
                Object.keys(data.ciudades).forEach(function(key){     
								
										var options = document.createElement('option');
										options.setAttribute('value', data.ciudades[key]);
										options.text = data.ciudades[key];
										div.appendChild(options);
                });			
				
				var div2 = document.getElementById('selectTipo');
				 Object.keys(data.tipo).forEach(function(key){     
								
										var options2 = document.createElement('option');
										options2.setAttribute('value', data.tipo[key]);
										options2.text = data.tipo[key];
										div2.appendChild(options2);
                });
				// $(document).ready(function(){$('#selectTipo').material_select();});
				$('#selectCiudad').material_select();
				$('#selectTipo').material_select();
		}
	})
	
}

inicializarSlider();
playVideoOnScroll();
inicializarCiudades();

$(function(){
	$('#submitButton').on('click',function (e){
		e.preventDefault();

		var form_data = getInfoForm();
		
		
	$.ajax({
		url: './src/orquestaData.php',
		type: 'POST',
		dataType: 'json',
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,		
		success: function(data, ms, settings){
				poblarTablero(data);
		}
	})
		
	});
	
	$('#mostrarTodos').on('click',function (e){
		e.preventDefault();

		var form_data = new FormData();
		form_data.append('all', "1");
		
	$.ajax({
		url: './src/orquestaData.php',
		type: 'POST',
		dataType: 'json',
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,		
		success: function(data, ms, settings){
				poblarTablero(data);
		}
	})
		
	});
	
});




function getInfoForm(){
	  var form_data = new FormData();
	  form_data.append('selectCiudad', $("[id='selectCiudad']").val());
	  form_data.append('selectTipo', $("[id='selectTipo']").val());
	  form_data.append('rangoPrecio', $("[id='rangoPrecio']").val());  
	  return form_data;
}


function poblarTablero(dataLoad){
	$('.itemMostrado').remove();
	var colContenido = $(".colContenido");
	var div = document.createElement("div");
	  Object.keys(dataLoad.data).forEach(function(key){
        $('.colContenido').append(
               "<div class='itemMostrado' id="+dataLoad.data[key].Id+">"
              +  	"<img src='img/home.jpg'></img>" 
              +     "<div><p><b>Direccion: </b>"+dataLoad.data[key].Direccion+"<br>"
              +     "<b>Ciudad: </b>"+dataLoad.data[key].Ciudad+"<br>"
              +     "<b>Telefono: </b>"+dataLoad.data[key].Telefono+"<br>"
              +     "<b>Codigo_Postal: </b>"+dataLoad.data[key].Codigo_Postal+"<br>"
              +     "<b>Tipo: </b>"+dataLoad.data[key].Tipo+"<br></p>"
              +     "<p class='precioTexto'><b>Precio: </b>"+dataLoad.data[key].Precio+"</p></div>"
              + "</div>"

          );
	  });
	  colContenido.append(div)
}
