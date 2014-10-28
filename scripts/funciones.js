

/*
 *Funciones para validar campos
 */
 
 
    // Email Validation
    function validarCorreo(email) {
      var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
      return pattern.test(email);
    }

	// Numero Validation
    function validarNumero(num) {
      var pattern = new RegExp(/^\d+$/);
      return pattern.test(num);
    } 
	
	// Url Validation
    function validarUrl(url) {
      var pattern = new RegExp(/^(ht|f)tp(s?)\:\/\/[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)( [a-zA-Z0-9\-\.\?\,\'\/\\\+&%\$#_]*)?$/);
      return pattern.test(url);
    } 

	// Telefono Validation
    function validarTelefono(num) {
      var pattern = new RegExp(/^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$/);
      return pattern.test(num);
    } 
	
	

function getHost(){

	var host = document.location.hostname;
	
	if(host == 'localhost'){
	
		host = 'http://'+host+'/ttucv/';
	
	}else{
		
		host = 'https://'+host+'/';
		
	}
	
	return host;

}

function getSiteActual(){
		
	if(document.location.href.indexOf('liga') != -1){
		return 'liga';
	}else if(document.location.href.indexOf('circuito') != -1){
		return 'circuito';
	}else{
		return '';
	}
		
	
		
}

function formatHoraMeridiana(time){
	
	var temp = time.split(':');
	
	var hora = parseInt(temp[0]);
	var minuto = parseInt(temp[1]);
	var meridiano = "am"
	if(hora > 12){hora -= 12; meridiano = "pm"}
	if(hora==0){hora=12;}
	if (hora < 10) {hora = "0" + hora}
	if (minuto < 10) {minuto = "0" + minuto}
	
	return hora + ":" + minuto + meridiano;
}	
	
	