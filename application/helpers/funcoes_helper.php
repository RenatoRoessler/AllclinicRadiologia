<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function limpar($string){
	$table = array(
        '/'=>'', '('=>'', ')'=>'',
    );
    // Traduz os caracteres em $string, baseado no vetor $table
    $string = strtr($string, $table);
	$string= preg_replace('/[,.;:`´^~\'"]/', null, iconv('UTF-8','ASCII//TRANSLIT',$string));
	$string= strtolower($string);
	$string= str_replace(" ", "-", $string);
	$string= str_replace("---", "-", $string);
	return $string;
}

/**
 * 	Verifica se o valor � v�lido, sen�o retorna null. Mais usando para comando SQL
 * 
 *	@author Douglas Comim - 24/07/2015 09:33:32
 *	@version 0.1
 * 	@param	$val String
 * 			- Valor a ser validado
 * 	@return String or NULL
 */
function isNull( $val ){
	
	if( strlen( trim( $val ) ) >= 1 ){
		if( is_numeric( $val ) ){
			return $val;
			/*if( strlen( $val ) > 1 && substr( $val , 0, 1 ) == '0' ){
				return "'". $val . "'";
			}else{
				return $val;
			}*/
		}else{
			return "'". $val . "'";
		}
	}else{
		return "NULL";
	}
}
/**
 * 	Verifica se o valor da variavel � valido
 * 		Valido se: not null, != '',
 * 
 *	@author Douglas Comim - 28/07/2015 08:19:09
 *	@version 0.1
 * 	@param	$var String or array
 * 			- Vari�vel a ser verificada
 * 	@return boolean
 */
function isVal( $var ){
	//	Verificando se eh um array
	if( is_array($var) ){
		return true;
	}
	if( strlen( trim( $var ) ) >= 1 && $var != "" && isset( $var ) && $var != null ){
		return true;
	}else{
		return false;
	}
}
/**
 * 	Retorna caminho relativo para utiliza��o nas Views
 * 
 *	@author Douglas Comim - 24/07/2015 09:34:59
 *	@version 0.1
 * 	@param	$cons String
 * 			- Constante para ser simplificada. Ex.: SYS_LIB retorna lib
 * 	@return void
 */
function pegaCaminho( $cons ){
	if( $cons ){
		return str_replace( FCPATH, "", $cons );
	}else{
		return null;
	}
}
/**
 * 	Limpa URL para pegar controllers, acoes e parametros
 * 
 *	@author Douglas Comim - 24/07/2015 09:36:26
 *	@version 0.1
 * 	@param	$array 	array
 * 			- Variaveis passadas na URL
 * 	@param  $key	integer
 * 			- Indice para verificar
 * 	@return String
 */
function chkURL ( $array, $key ) {
	// Verifica se a chave existe no array
	if ( isset( $array[ $key ] ) && ! empty( $array[ $key ] ) ) {
		// Retorna o valor da chave
		return $array[ $key ];
	}
	// Retorna nulo por padr�o
	return null;
}
/**
 * 	Limpa vari�vel com express�o 
 * 
 *	@author Douglas Comim - 24/07/2015 09:40:03
 *	@version 0.1
 * 	@param	$var String
 * 			- Vari�vel a ser limpa
 * 	@return String
 */
function limpaVariavel( &$var ){
	$exp = "/['\\\]|(drop )|(table )|(database )|(colunm )|(create )|(show )|(delete )|(update )|(insert )|(select )|(grant )|(from )|(where )/i";
	$var = preg_replace( $exp, '', trim( $var ) );
	return $var;
}
function limpaVariavelArray( $array ){
	array_walk_recursive( $array, 'limpaVariavel');
	return $array;
}
/**
 * 	Retorna controle em execu��o
 *
 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
 *	@version 1.0.0 - 16 de jan de 2017 11:30:07
 * 	@return String
 */
function retornaControle(){
	$tmp = explode( '/', $_SERVER['REQUEST_URI'] );
	return $tmp[1];
}
/**
 * 	Redireciona para p�gina solicitada
 * 
 *	@author Douglas Comim - 24/07/2015 09:43:04
 *	@version 0.1
 * 	@param	$pagina String
 * 			- URL da p�gina solicitada
 * 	@return void
 */
function redireciona( $pagina ){
	//	Verificando se a chamada foi feita via AJAX
	if( requestIsAjax() ){
		$obj = array(
			'status' => $status, 
			'mensagem' => "<script>window.location.href = '$pagina';</script>", 
			'conteudo' => "<script>window.location.href = '$pagina';</script>"
		);
		echo json_encode( $obj );
	}else{
		header('Location: ' . $pagina );
	}
}
/**
 * 	Embaralha valores de IDS
 *
 *	@author Douglas Comim - 25/08/2015 09:43:04
 *	@version 0.1
 * 	@param	&$val Int
 * 			- Valor inteiro a ser embaralhado
 * 	@param	$o Int
 * 			- Opção, 0 embaralha, 1 retorna valor baseado
 * 	@return void
 */
function saltValor( $valor, $o = 0 ){
	//	Verificando se valor eh compatável
	if( is_int( (int) $valor ) ){
		if( !$o ){ // $o == 0
			$valor = ( $valor * 3 ) * 20; 
		}elseif( $o == 1 ){
			$valor = ( $valor / 20 ) / 3;
		}else{
			$valor = 0; $salt = 0;
		}
	}else{
		$valor = 0; $salt = 0;	
	}
	return $valor;
}
/**
 * 	Acentuação codificada para HTML
 *
 *	@author Douglas Comim - 04/09/2015 09:43:48
 *	@version 0.1
 * 	@param	$str - String para troca
 * 	@return void
 */
function charsHTML( $str ){
	$html = array( 'Á' => '&Aacute;', 'á' => '&aacute;', 'Â' => '&Acirc;','â' => '&acirc;','À' => '&Agrave;','à' => '&agrave;','Å' => '&Aring;','å' => '&aring;','Ã' => '&Atilde;','ã' => '&atilde;','Ä' => '&Auml;','ä' => '&auml;','Æ' => '&AElig;','æ' => '&aelig;','É' => '&Eacute;','é' => '&eacute;','Ê' => '&Ecirc;','ê' => '&ecirc;','È' => '&Egrave;','è' => '&egrave;','Ë' => '&Euml;','ë' => '&euml;','Ð' => '&ETH;','ð' => '&eth;','Í' => '&Iacute;','í' => '&iacute;','Î' => '&Icirc;','î' => '&icirc;','Ì' => '&Igrave;','ì' => '&igrave;','Ï' => '&Iuml;','ï' => '&iuml;','Ó' => '&Oacute;','ó' => '&oacute;','Ô' => '&Ocirc;','ô' => '&ocirc;','Ò' => '&Ograve;','ò' => '&ograve;','Ø' => '&Oslash;','ø' => '&oslash;','Õ' => '&Otilde;','õ' => '&otilde;','Ö' => '&Ouml;','ö' => '&ouml;','Ú' => '&Uacute;','ú' => '&uacute;','Û' => '&Ucirc;','û' => '&ucirc;','Ù' => '&Ugrave;','ù' => '&ugrave;','Ü' => '&Uuml;','ü' => '&uuml;','Ç' => '&Ccedil;','ç' => '&ccedil;','Ñ' => '&Ntilde;','ñ' => '&ntilde;','®' => '&reg;','©' => '&copy;','Ý' => '&Yacute;','ý' => '&yacute;','Þ' => '&THORN;','þ' => '&thorn;','ß' => '&szlig;' );
	return strtr( $str, $html );
}
function removeAcento( $str ){
	$html = array( 'Á' => 'A', 'á' => 'a', 'Â' => 'A','â' => 'a','À' => 'A','à' => 'a','Å' => 'A','å' => 'a','Ã' => 'A','ã' => 'a','Ä' => 'A','ä' => 'a','Æ' => 'A','É' => 'E','é' => 'e','Ê' => 'E','ê' => 'e','È' => 'E','è' => 'e','Ë' => 'E','ë' => 'e','Í' => 'I','í' => 'i','Î' => 'I','î' => 'i','Ì' => 'I','ì' => 'i','Ï' => 'I','Ó' => 'O','ó' => 'o','Ô' => 'O','ô' => 'o','Ò' => 'O','ò' => 'o','Õ' => 'O','õ' => 'o','Ö' => 'O','ö' => 'o','Ú' => 'U','ú' => 'u','Û' => 'U','û' => 'u','Ù' => 'U','ù' => 'u','Ü' => 'U','ü' => 'u','Ç' => 'C','ç' => 'c','Ñ' => 'N','ñ' => 'n' );
	return strtr( $str, $html );
}
/* Percorre todo o array limpando variaveis*/
function cleanAllVar(&$array){
	array_walk_recursive($array, function(&$value, $key) {
		$value = limpaVariavel($value);
	});
}
/* Converte os campos de texto para o charset utf-8 */
function corrigeCharset(&$arr){
	array_walk_recursive($arr, function(&$value, $key) {
		if (is_string($value)) {
			$value = iconv('utf-8','windows-1252', $value);
		}
	});
}
/**
 * 	Destroi vari�vel, objeto ...
 * 
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 0.0.2, 17 de ago de 2016 10:14:50
 * 	@param	$a ... 5
 * 	@return void
 */
function destroi( &$a=null, &$b=null, &$c=null, &$d=null, &$e=null ){
	for( $i = 0; $i < count( func_get_args() ); $i++ ){
		$val = func_get_arg($i);
		unset( $val );
	}
}
/**
 * 	Limpa a vari�vel deixando apenas digitos num�ricos
 *
 *	@author Douglas Comim <douglas.pinheiro@unimedpf.com.br> 11 de fev de 2016 18:01:14
 *	@version 0.1
 * 	@param	$string String
 * 	@return integer
 */
function apenasDigito( $string ){
	return preg_replace( '/[^0-9]/', '', $string);
}
/**
 * 	Cria log do sistema. especifico para debug
 *
 *	@author Douglas Comim <douglas.pinheiro@unimedpf.com.br> 12 de fev de 2016 14:00:4705
 *	@version 0.1
 */
function returnArrayToString( $array ){
	ob_start();
	var_dump($array);
	$array = ob_get_clean();
	return $array;
}
/**
 * 	M�todo para encriptar/decriptar valores entre chamadas do PHP
 * 
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	
 * 	@param	$string	string
 * 			Valor em quest�o
 * 	@param	$action	char
 * 			A��o, E=encriptar, D=decriptar	
 * 
 *	@version 0.1, 9 de jun de 2016 08:41:45
 * 	@return void
 */
function cript( $string, $action = null ){
	// 	strings usadas como chave para criptografa e decriptografar
	$key = 'f6dc82448b0461b3f8ef555ad5a1be93'; // MD5 de lukeyodakenobi
	$iv = '0289c05ce4675b7c'; // Segunda chave
	$method = "AES-256-CBC";
	$output = false;

	if( strtoupper($action) == 'E' || !$action){
		$output = openssl_encrypt($string, $method, $key, 0, $iv);
		$output = base64_encode($output);
	}else if( strtoupper($action) == 'D' ){
		$output = openssl_decrypt(base64_decode($string), $method, $key, 0, $iv) ;
	}
	return $output;
}
/**
 * 	Método para embaralhar caracters de forma simples
 * 
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 1.4.19.6, 18/03/2018
 *	
 * 	@param	$string	string
 * 	@param	$action	char
 * 
 * 	@return void
 */
function criptLow( $string, $action = 'E' ){

	//	Chave deve conter todos os caracteres simples possíveis
	$key = "a9b8c7d6e5f4g3h2i1j0lYkWmZnXoVpUqTrSsRtQuPvOxNzMwKyLAJBICHDGEF/-+.!@#$%&*()={}[];:,?_| '<>"; 

	$wl = strlen( $string );
	$kl = strlen( $key );
	$cript = '';
	
	if( $action === 'E' ){
		for( $i=0; $i < $wl; $i++ ){
			$lp = strpos( $key, $string[$i] );
			$cript .= $key[(( $lp + $i + $wl ) % $kl)];
		}
		return $cript;
	}else if( $action === 'D' ){
		for( $i=0; $i < $wl; $i++ ){
			$lp = strpos( $key, $string[$i] );
			$lpos = (( $lp - $i - $wl ) % $kl);
			$lpos = ( $lpos < 0 ) ? $kl - abs( $lpos ) : $lpos;
			$cript .= $key[$lpos];
		}
		return $cript;
	}
	return $string;
}
/**
 *	M�todos usados para mostrar erros de valida��o dos Schemas XML
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 0.1, 28 de jun de 2016 08:43:44
 */
function libxml_display_error($error){
	if( $error->level == LIBXML_ERR_ERROR || $error->level == LIBXML_ERR_FATAL ){
		$return['Code'] = $error->code;
		$return['String'] = trim( $error->message ) . ', in line ' . $error->line;
	}
	return $return;
}
function libxml_display_errors() {
	$errors = libxml_get_errors();
	$er = array();
	foreach ($errors as $error) {
		$er[] = libxml_display_error($error);
	}
	libxml_clear_errors();
	return $er;
}
function returnVariable(){
	for($i = 0; $i < count(func_get_args()); $i++){
		$val = func_get_arg( $i );
		if( !empty($val) && isset($val) && $val != '' && $val !== 0 ){
			return $val;
		}
	}
	return false;
}
function returnVariableNumber(){
	for($i = 0; $i < count(func_get_args()); $i++){
		$val = func_get_arg( $i );
		if( !empty($val) && isset($val) && $val != "" && $val && is_numeric($val) ){
			return $val;
		}
	}
	return 0;
}
function returnVariableTrim(){
	for($i = 0; $i < count(func_get_args()); $i++){
		$val = func_get_arg( $i );
		if( !empty($val) && isset($val) && $val != "" && $val ){
			return trim( $val );
		}
	}
	return false;
}
function returnMajor( $v1, $v2 ){
	if( !$v1 && $v2 ){
		return $v2;
	}else if( $v1 && !$v2 ){
		return $v1;
	}else if( is_array($v1) && is_array($v2) ){
		if( count($v1) > count($v2) ){
			return $v1;
		}else{
			return $v2;
		}
	}else if(is_numeric($v1) && is_numeric($v2)){
		if( $v1 > $v2 ){
			return $v1;
		}else{
			return $v2;
		}
	}
	return false;
}
/**
 * 	Pad para esquerda
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 0.0.1, 29 de jun de 2016 08:10:23
 */
function padl( $val, $n=3, $p='0' ){
	return str_pad($val, $n, $p, STR_PAD_LEFT );
}
/**
 * 	Pad para direitra
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 0.0.1, 29 de jun de 2016 08:10:23
 */
function padd( $val, $n=3, $p='0' ){
	return str_pad($val, $n, $p, STR_PAD_RIGHT );
}
/**
 * 	Calculo MOD11
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 0.0.1, 28 de jun de 2016 17:04:44
 * 	@return array
 */
function mod11( $num, $base = 9, $r = 0 ) {

	$soma = 0;
	$fator = 2;

	for ($i = strlen($num); $i > 0; $i--) {

		$numeros[$i] = substr($num, $i - 1, 1);
		$parcial[$i] = $numeros[$i] * $fator;
		$soma += $parcial[$i];

		($fator == $base) ? $fator = 1 : null ;

		$fator++;
	}
	if ($r == 0) {
		$soma *= 10;
		$digito = $soma % 11;
		//corrigido
		($digito == 10) ? $digito = '0' : null;

		if (strlen($num) == '43') {
			//ent�o estamos checando a linha digit�vel
			( $digito == '0' or $digito == 'X' or $digito > 9) ? $digito = 1 : null ;
		}
		return $digito;
	} elseif ($r == 1) {
		return $soma % 11;
	}
}
/**
 * 	Verifica namespace retornado
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 0.0.1, 29 de jun de 2016 08:10:23
 */
function verifyReturnNamespace( &$array ){
	if( $array['namespace'] ){
		$ns = $array['namespace'];
		unset($array['namespace']);
		return $ns;
	}
	return "fault";
}
/**
 *	Concatena todos os valores do array
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 0.1, 28 de jun de 2016 15:10:16
 * 	@return void
 */
function getValuesFromArray( $array ){
	$it = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
	$val = "";
	foreach($it as $v) {
		$val .= $v;
	}
	return $val;
}
/**
 * 	Ajusta data
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 1.0.0 - 17 de nov de 2016 13:40:12
 */
function formatDate( $date, $mask ){
	if( $date && $mask ){
		$date = new DateTime( str_replace("/", "-", $date) );
		return $date->format( $mask );
	}
	return $date;
}
/**
 * 	Converte minutos em horas, dias, mesess
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 1.0 - 15 de mar de 2017 11:36:21
 */
function formatMinute( $mins ){
	
	$hours = floor($mins /60);
	$mins  = $mins %60;
	
	if((int)$hours > 24){
		$days = floor($hours /24);
		$hours = $hours %24;
	}
	return array( 'd' => $days, 'h' => $hours, 'm' => $mins );
}
/**
 *	Transforma array em XML
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 1.0.0 - 28 de out de 2016 15:16:37
 * 	@return void
 */
function arrayToXml( $data, $rootNodeName = 'envelope', $xml = null, $ns = "", $map = null, $clean = true ){

	$data = (array) $data;
	
	if($xml == null){
		if( $ns ){
			$xml = simplexml_load_string("<$rootNodeName xmlns=\"$ns\"/>");
		}else{
			$xml = simplexml_load_string("<$rootNodeName />");
		}
	}
	// faz o loop no array
	foreach ($data as $key => $value) {
		// se for indice numerico ele renomeia o indice
		if(is_numeric($key)){
			$key = "unknownNode_" . (string) $key;
		}
		if(is_array($value)){
			//	se a chave tem noma + numero, mas precisa ter apenas o nome repetido
			//	Ex.: 'nomeChave001', 'nomeChave002' => 'nomeChave', 'nomeChave'
			if( $map ){
				foreach ( $map as $m ){
					if( strpos( $key, $m ) !== false ){
						$key = $m;
						break;
					}
				}
			}
			$node = $xml->addChild($key);
			arrayToXml($value, $rootNodeName, $node, null, $map);
		}else{
			if( !is_null( $value ) ){
				$value = utf8_decode(htmlentities(removeAcento($value)));
				$xml->addChild($key, $value);
			}
		}
	}
	if( $clean ){
		return str_replace( '<?xml version="1.0"?>', "",  $xml->asXML() );
	}else{
		return $xml->asXML();
	}
}
function validChecksStats($info,$checks){
	foreach ( $checks as $k => $v ){
		if( $info[$v[0]] == $v[1] ){
			$_SESSION['MSG'] = array( $v[2], $v[3] );
			return false;
		}
	}
	return true;
}
/**
 * 	Ajusta valores de um array que vai ser encodado em JSON
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 1.0 - 24 de mai de 2017 21:45:59
 *
 *	@param array $array - Array com valores
 *
 *	return array
 */
function jsonValores( &$array ){
	array_walk_recursive( $array, function (&$v, $k) {
		$v = ( null === $v ) ? '' : charsHTML( $v );
	});
}
/**
 * 	Encode JSON recursivo
 * 
 *	@author Douglas Comim - 26/07/2017
 * 	@param	Array $array
 * 	@return void
 */
function jsonEncodeArray( $array, $CONS = null ){
	array_walk_recursive( $array, function(&$item) { 
		$item = utf8_encode( $item ); 
	});
	if( $CONS ){
		return json_encode( $array, $CONS );
	}
	return json_encode( $array );
}
/**
 * 	Encode UTF8 recursivo
 * 
 *	@author Douglas Comim - 26/07/2017
 * 	@param	Array $array
 * 	@return void
 */
function utf8EncodeArray( $array ){
	array_walk_recursive( $array, function(&$item) { 
		$item = utf8_encode( $item ); 
	});
	return $array;
}
/**
 * 	Decode UTF8 recursivo
 * 
 *	@author Douglas Comim - 26/07/2017
 * 	@param	Array $array
 * 	@return void
 */
function utf8DecodeArray( $array ){
	array_walk_recursive( $array, function(&$item) { 
		$item = utf8_decode( $item ); 
	});
	return $array;
}
/**
 * 	Encode JSON recursivo
 * 
 *	@author Douglas Comim - 26/07/2017
 * 	@param	String $json
 * 	@return void
 */
function jsonDecode( $json, $CONS = null ){
	if( $CONS ){
		return json_decode( utf8_decode( $json ), $CONS );
	}
	return json_decode( utf8_decode( $json ) );
}
/**
 * 	Ajusta valores para inserção banco Oracle
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 1.0 - 24 de mai de 2017 21:45:59
 *
 *	@param $string String - String
 *
 *	return array
 */
function htmlPageToDB( $string ){
	$string = str_replace( "&", "\&", $string );
	return $string;
}
/**
 * 	Ajusta valores para mostrar na página vindo do banco Oracle
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 1.0 - 24 de mai de 2017 21:45:59
 *
 *	@param $string String - String
 *
 *	return array
 */
function htmlDBToPage( $string ){
	$string = str_replace( "\&", "&", $string );
	return $string;
}
function voltar($ref){
	$act = $_SERVER['REQUEST_URI'];
	if( $ref != '' && $act != $ref && !in_array( $act, array('/Index')) ){
		return $ref;
	}
	return false;
}
function setCookieUser( $key, $val, $id ){
	$json = getCookieUser();
	$json[$key] = $val;
	setcookie( md5( returnVariable( $id, $_SESSION['idUsuario'] )), json_encode( $json ), time()+60*60*24*365, '/', '', 1, 1 );
}
function getCookieUser( $key = null, $id ){
	$json = json_decode( $_COOKIE[ md5( returnVariable( $id, $_SESSION['idUsuario'] ) ) ], true );
	if( $key ){
		return $json[$key];
	}
	return $json;
}
/**
 * 	Verifica se a request foi origina de um AJAX
 *
 *	@author	Douglas Comim Pinheiro <douglas.comim@gmail.com>
 *	@version 1.3.23.17 | 07.01.2018
 */
function requestIsAjax(){
	return ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) ? true : false;
}
/**
 * 	Formata número para exibição
 *
 *	@author Douglas Comim <douglas.comim@gmail.com>
 *	@version 1.0.0 - 17 de nov de 2016 13:40:12
 */
function formatNumber( $number, $decs = 2, $sep = '.', $dec = ',', $neg = true ){
	/*	Zera números negativos */
	if( !$neg && ( $number < 0 ) ){
		$number = 0.00;
	}
	return number_format( (float) $number, $decs, $dec, $sep );
}
function formatNumberType( $number, $format = false, $decs = 2 ){

	if( preg_match( '/^[0-9]*(\.[0-9]{3})*,[0-9]{1,2}?$/' , $number ) ){
    	$number = str_replace( '.', '', $number );
    	$number = str_replace( ',', '.', $number );
	}
	$number = round( (float) $number, $decs );
	if( $format ){
		return formatNumber( $number, $decs );
	}else{
		return $number;
	}
}
function selectFillArray( $array ){
	$ar = array();
	foreach( $array as $k => $v){
		$ar[array_shift( $v )] = array_shift( $v );
	}
	return $ar;
}
function returnCaseInArrayString( $v, $array, $string ){
	return ( in_array( $v, $array ) ) ? $string : '';
}