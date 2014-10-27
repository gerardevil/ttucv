
var param = 'opcion=consulta';

var json = $.ajax({  
		 type: 'GET',  
		 url: 'control/ctrl_banner.php',
		 //dataType: 'json',
		 data: param,
		 async: false  
		}).responseText
		

		
var aux = jQuery.parseJSON(json);
var imagenes = new Array();

for(var i=0;i<aux.length;i++){
	imagen = new Array(3);
	imagen[0] = "../art/banner/" + aux[i].misc_imagen1;
	imagenes[i] = imagen;
}

//alert(imagenes);

var translideshow1=new translideshow({
 wrapperid: "myslideshow", //ID of blank DIV on page to house Slideshow
 dimensions: [710, 272], //width/height of gallery in pixels. Should reflect dimensions of largest image
 imagearray: imagenes,
 displaymode: {type:'auto', pause:2000, cycles:0, pauseonmouseover:true},
 orientation: "h", //Valid values: "h" or "v"
 persist: true, //remember last viewed slide and recall within same session?
 slideduration: 600 //transition duration (milliseconds)
})
