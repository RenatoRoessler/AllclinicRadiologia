/** Direciona para uma URL */
function ir( URL ){
	loader("show");
	var target = arguments[1] || "_self"
	window.open( URL, target );
}
/*	Recarrega a pagina, time em segundos*/
function reload( time ){
	if( typeof time == 'undefined' ){
		time = 0
	}
	setTimeout(function(){
		window.location.reload();
	}, ( time * 1000 ) );
}
/** Dialogo padrao */
function dialogo( options ){
	if( options.ctrl == null ) options.ctrl = false;
	if( options.btn1 == null && options.tipo == 'a' ) options.btn1 = "Sair";
	if( options.btn1 == null ) options.btn1 = "Sim";
	if( options.btn2 == null ) options.btn2 = "N&atilde;o";
	options.icon1 = ( options.icon1 == null ) ? '<i class="fa fa-check"></i> ' : '<i class="fa fa-' + options.icon1 + '"></i> ';
	options.icon2 = ( options.icon2 == null ) ? '<i class="fa fa-ban"></i> ' : '<i class="fa fa-' + options.icon2 + '"></i> ';
	options.icon3 = ( options.icon3 == null ) ? '' : '<i class="fa fa-' + options.icon3 + '"></i> ';
	
	options.foco = options.foco || 'N';

	/*	Verifricando se o dialogo 1 jah esta aberto*/
	if( $( "#dialogo1" ).is( ":visible" ) ) var v = 2; else var v = 1;
	if( options.largo == true ) $("#dialogo"+v+" .modal-dialog").addClass("modal-lg"); else $("#dialogo"+v+" .modal-dialog").removeClass("modal-lg");
	
	/*	Verificando se dialog existe*/
	if( $( "#dialogo" + v ).length > 0 ){
		$( "#dialogoTitulo" + v ).html( options.titulo );
		$( "#dialogoTexto" + v ).html( options.texto );
		if( options.tipo == 'a' ){
			$( "#dialogoAcao" + v ).html( "<button id='btnDialogoSair"+v+"' type='button' class='btn btn-primary' >"+ options.icon1 + options.btn1 +"</button>" );
			$( "#btnDialogoSair" + v )
				.click( function(){ 
					if( typeof options.fnc1 !== "undefined" ){
						options.fnc1();
					}
					if( !options.ctrl ) hideModal( "dialogo" + v );
					verificaModalOpen();
				});
		}else{
			if( typeof options.btn3 !== "undefined" && options.btn3 !== null && typeof options.fnc3 !== "undefined" ){
				$( "#dialogoAcao" + v ).html( 
					"<button id='btnDialogoS"+v+"' type='button' class='btn btn-default' >"+ options.icon1 + options.btn1 +"</button>" +
					"<button id='btnDialogoN"+v+"' type='button' class='btn btn-default' >"+ options.icon2 + options.btn2 +"</button>" +
					"<button id='btnDialogo3"+v+"' type='button' class='btn btn-primary' >"+ options.icon3 + options.btn3 +"</button>"
				);
				$( "#btnDialogo3" + v )
					.on( 'click keydown', function(e){
						if( keyPressCheck( e, 13 ) || e.type == 'click' ){
							if( typeof options.fnc3 !== "undefined" ){
								options.fnc3();
							}
							if( !options.ctrl ) hideModal( "dialogo" + v );
							verificaModalOpen();
						}
					});
			}else{
				$( "#dialogoAcao" + v ).html( 
					"<button id='btnDialogoS"+v+"' type='button' class='btn btn-default' >"+ options.icon1 + options.btn1 +"</button>" +
					"<button id='btnDialogoN"+v+"' type='button' class='btn btn-primary' >"+ options.icon2 + options.btn2 +"</button>"
				);
			}
			$( "#btnDialogoS" + v )
				.on( 'click keydown', function(e){
					if( keyPressCheck( e, 13 ) || e.type == 'click' ){
						if( typeof options.fnc1 !== "undefined" ){
							options.fnc1();
						}
						if( !options.ctrl ) hideModal( "dialogo" + v );
						verificaModalOpen();
					}
				});
			$( "#btnDialogoN" + v )
				.on( 'click keydown', function(e){
					if( keyPressCheck( e, 13 ) || e.type == 'click' ){
						if( typeof options.fnc2 !== "undefined" ){
							options.fnc2();
						}
						if( !options.ctrl ) hideModal( "dialogo" + v );
						verificaModalOpen();
					}
				});
		}
		setTimeout(function(){ $( "#btnDialogo"+ options.foco + v ).focus()},700);
		$( "#dialogo" + v ).modal();
	}
}
/*
 *	Metodo para exibir dialogo de busca.
 *	Esse método deve ser definido pelo PHP, pois o nome da Tabela está criptografado por motivos de segurança
 *	
 *	Autor: 	Douglas Comim <douglas.comim@gmail.com>
 *	Data:  	08/08/2016 13:53  
 *
 *	@param	options
 *			Array com dados usados no metodo, esse array é guardado dentro do objeto "btnBuscaMain"
 *			options:
 *				0 => Tabela, criptografada usando function cript (functions.php)
 *				1 => Array de atributos para filtro na tabela
 *				2 => String com o nome das colunas que devem ser exibidas separadas por vírgula
 *				3 => Orderby, campos podem ser separados por virgual
 *				4 => Placeholder do campo input
 *				5 => Callback que vai ser excutado no release da linha selecionada. Passar somente nome da função, vai receber valores ddo registro selecionado. 
 */
function dialogoBusca(options){
	dialogo({
		"titulo" : "Busca",
		"texto" : '<div class="col-main col-sm-12 col-xs-12">' +
			'<div class="input-group">' +
				'<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="BuscaMain" name="BuscaMain" value="" placeholder="'+options[4]+'" required>' +
				'<span class="input-group-btn">' +
					'<button type="button" id="btnBuscaMain" class="btn btn-default sys-btn-group2" onclick="buscaMain()"> Buscar</button>' +
				'</span>' +
			'</div>' +
		'</div>' + 
		'<div class="row col-sm-12 col-xs-12">&nbsp;</div>' +
		'<div class="col-main col-sm-12 col-xs-12" id="returnBuscaMain">' +
			'<div class="table-responsive">' +
				'<table class="table table-hover table-condensed" id="returnBuscaMainTable"></table>' +
			'</div>'+
			'<div id="BuscaPag" class="col-sm-12 col-xs-12 sys-busca-paginacao"></div>' +
		'</div>',
		"fnc1" : function(){}, "fnc2" : function(){}, "tipo" : "a", "largo" : true, "ctrl" : false
	});
	setTimeout(function(){
		$("#BuscaMain").focus();
		keyCallClick( "#BuscaMain", "#btnBuscaMain", 13 ); // 13 -> ENTER
	},700);
	$("#btnBuscaMain").data("E", options);// Guardando dados no objeto para pegar depois
}
function keyPressCheck(e, key, callback) {
    var event = window.event ? window.event : e;
    if( typeof event.keyCode == 'undefined' || event.keyCode != key ){
    	return false;
    }
    if( typeof callback == 'function' ){
    	callback();
    }
    return true;
}
/*
 *	Metodo de busca principal 
 * 
 * 	Autor: Douglas Comim <douglas.comim@gmail.com>
 * 	Data: 08/06/2016 17:37
 * 
 * 	@param	obj
 * 			Objeto btnBuscaMain que armazena array com valores utilizados
 */
function buscaMain(pagina){
	//	Valida campo busca
	var valid = false;
	$('#BuscaMain').parsley().on( "field:success", function() { valid = true }).validate();
	if( valid ){
		var x = $("#btnBuscaMain").data("E"); // Recuperando array
		if( typeof x !== "undefined" ){
			x[1].V = $("#BuscaMain").val()
			$.ajax({
		    	url : "/Sys/buscaMain",
		        type : "post",
		        data : {
		        	"C" : x[2],
		        	"O" : x[3],
		        	"A" : x[1],
		        	"E" : x[0],
		        	"P" : pagina||1
		        },
		        timeout: 1000,
		        beforeSend: function(){
		        	$("#returnBuscaMainTable").html("");
		        	loader("show");
		        },
		        success: function( retorno ){
		        	retorno = jsonEncode(retorno, "json");
		        	if(retornoJson(retorno,'N')){
		        		//	Retornando tabela montada
		        		$("#returnBuscaMainTable").html( buscaMainMontaTabela(retorno.conteudo, x[5]) );
		        	}else{
		        		$("#returnBuscaMainTable").html( "<tr><td>Nenhum registro encontrado</td></tr>" );
		        	}
		        	$("#BuscaPag").html(replaceAll( 'paginaAct', "buscaMain", ( retorno.paginacao||'')));
		        	loader("hide");
		        },
				error: function( request, status, error ){
					loader("hide");
				}
			});
		}
	}
}
/*
 *	Metodo para montar tabela com retorno da busca principal 
 * 
 * 	Autor: Douglas Comim <douglas.comim@gmail.com>
 * 	Data: 08/06/2016 17:37
 * 
 * 	@param	dados
 * 			Dados retornados
 * 	@param	y
 * 			Metodo que é executado no click sobre a linha selecionada
 */
function buscaMainMontaTabela(dados,y){
	var head; var body; var b; var q = 0;
	var o = Object.keys(dados[0]);
	//	Criando o head da tabela
	head  = "<thead><tr>";
	for(var i in o) {
		if( o[i] != "R__" ){
			head += "<th>"+o[i]+"</th>";
		}
	}
	head += "</tr></thead>";
	
	body = "<tbody>";
	for(var i in dados) {
		b=""; // limpando b
		for (var k in dados[i]){
	        //console.log("Chave é " + k + ", valor é " + dados[i][k]);
			if( k != "R__" ){
				b += "<td>"+dados[i][k]+"</td>";
			}
		}
		body += "<tr class='sys-table-head' onclick='"+y+"("+jsonEncode(dados[i],"string", false)+")'>"+b+"</tr>";
		q++; // Contando
	}
	body += "</tbody>";
	$("#buscaMainQtdReg").html("Total de "+q+" registro(s).<br/>");
	return head + body;
}
/*	Esconde modal*/
function hideModal(){
	if( arguments.length > 0 ){
		var arg = arguments[0];
	}else{
		if( $( "#dialogo2" ).is( ":visible" ) ) var v = 2; else var v = 1;
		var arg = "dialogo" + v;
	}
	if( isVal( arg ) ){
		$( "#" + arg ).modal("hide").removeData('bs.modal').data('modal', null);
		if( arg == "dialogo2" ){
			$("#dialogo1").css("overflow-x","hidden").css("overflow-y","auto");
		}
	}
}
function verificaModalOpen(){
	setTimeout(function(){
		if( $( "#dialogo1" ).is( ":visible" ) ) {
			$( "body" ).addClass( "modal-open" );
		}
	},100);
}
/**	Paginacao */
function paginaAct( pagina ){
	//	Verificando se objeto ja existe
	loader(0);
	if( $("#formulario #pagina").length > 0 ){
		$("#pagina").val( pagina );
	}else{
		$("#formulario").prepend("<input type='hidden' id='pagina' name='pagina' value='"+ pagina +"' />");
	}
	//	Enviando formulario
	$("#formulario").submit();
}
/** Verifica se objeto existe */
function isObject( obj ){
	if( typeof obj == "object" && obj.length > 0 ){
		return true;
	}else{
		return false;
	}
}
/** Verifica se valor existe */
function isVal( val ){
	if( typeof val != "undefined" && val && val != "" ){
		return true;
	}else{
		return false;
	}
}
function loader(){
	var arg = ( arguments.length > 0 ) ? arguments[0] : null;
	if( isVal( arg ) ){
		if( arg.toLowerCase() == "hide" ){
			$("#loader").fadeOut("fast");
			$("#labLoader").html( "Processando" );
		}else if( arg.toLowerCase() == "show" ){
			if( arguments.length > 1 ){
				loaderLabel(arguments[1]);
			}
			$("#loader").fadeIn("fast");
		}
	}else{
		$("#loader").fadeToggle("fast");
	}
}
function loaderLabel(text){
	text = ( text.length > 57 ) ? text.substring(0,57) + '...' : text;
	$("#lblLoader").html(text);
}
/* 	Convert objeto para string JSON e string JSON para objeto  */
function jsonEncode( val, tipo, format ){
	if( isVal( tipo ) ){
		if( tipo.toLowerCase() == "json" ){
			return JSON.parse( val );
		}else if( tipo.toLowerCase() == "string" ){
			if( format == true ){
				return JSON.stringify( val, null, 2 );
			}else{
				return JSON.stringify( val );
			}
		}
	}
}
/*	Replace all */
function replaceAll( find, replace, str) {
	if( !isVal(str) ){
		return "";
	}
	return str.replace( new RegExp(find, 'g'), replace );
}
/*	Inicia selects*/
function startSelect(){
	if( arguments.length > 0 ) var arg = arguments[0]; else var arg = "start";
	if( isVal( arg ) ){
		if( arg.toLowerCase() == "start" ){
			$('.selectpicker').not(".bs-select-hidden").selectpicker({
				width: "100%"
			});
			$('.selectpicker').selectpicker( 'setStyle', 'input-sm sys-select', 'add' );
		}else if( arg.toLowerCase() == "refresh" ){
			$('.selectpicker').selectpicker( 'refresh' );
		}
	}
}
/* 	Exibe/esconde mensagens de erro na tela, s success, e error, n none */
function mensagem( tipo, mensagem ){
	if( typeof mensagem !== "undefined" ){
		var messages = {};
		messages['s'] = messages['success'] = 'alert-success';
		messages['e'] = messages['danger'] = 'alert-danger';
		messages['a'] = messages['warning'] = 'alert-warning';
		messages['i'] = messages['info'] = 'alert-info';
		$("#mensagem").hide();
		$("#mensagem-texto")
			.removeClass("alert-info")
			.removeClass("alert-warning")
			.removeClass("alert-danger")
			.removeClass("alert-success");
		$("#mensagem-texto").addClass(messages[tipo.toLowerCase()]);
		$("#mensagem").fadeIn("fast");
		clearTimeout( $("#mensagem").data("ctrl") );
		$("#mensagem-texto").html(mensagem);
		if (arguments[2]) { 
			$('#mensagem').css('z-index',500001) 
		} else { 
			$('#mensagem').css('z-index',65); 
		}
		if (!arguments[3]) {
			hideMensagem();
		}
		mensagemError();
	}
}
function hideMensagem(){
	$("#mensagem").data("ctrl",setTimeout(function(){
		$("#mensagem").fadeOut("fast");
	},8000));
}
/*	Tooltipo*/
function startTooltip(){
	$('[data-toggle="tooltip"]').tooltip();
}
/*	Inicia mask */
function startMask(){
	$.applyDataMask("input");
}
function startOrderTable(obj){
	var refresh = arguments[1] || false;
	if( refresh ){
		$(obj).trigger("update");
		return true;
	}
	if( $(obj).length > 0 ){
		$(obj).tablesorter(
			{dateFormat : "ddmmyyyy"}
		);
		$(obj).bind("sortStart",function() {
	        loader("show");
	    }).bind("sortEnd",function() { 
	    	loader("hide"); 
	    });
	}
}
/*	Trata erro em JSON */
function retornoJson( json ){
	var m = arguments[1] || true;
	if( !json.status){
		if(m == true){
			mensagem("e", json.mensagem );
			loader("hide");
		}
		return false;
	}else{
		return true;
	}
}
function fullScreen() {
	var el = document.body;
	var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullScreen;
	if (requestMethod) {
		requestMethod.call(el);
	} else if (typeof window.ActiveXObject !== "undefined") {
		var wscript = new ActiveXObject("WScript.Shell");
		if (wscript !== null) {
			wscript.SendKeys("{F11}");
		}
	}
}
function htmlToText( html ){
	var text = $('<textarea />').html(html).text();
	return text;
}
function download(file,automatico){
	if(automatico){
		window.open('/Sys/download/'+file);
	}else{
		dialogo({
			"titulo":"Download do arquivo", 
			"texto":"Link para arquivo:<br/><a href='/Sys/download/"+file+"' target='_blank'> "+file+" </a>",
			"fnc1":function(){},
			"fnc2":function(){},
			"tipo":"a"
		});
	}
}
function startData(obj){
	var options = {
	    language: "pt-BR",
	    todayHighlight: true,
	    autoclose: true,
	    todayBtn: true
	};
	$(obj)
		.datepicker(options)
		.focus(function(){
			$(this).select();
		});
}
function marcarCheckBox( obj, tabela ){
	$("#"+ tabela +" input[type='checkbox']:visible").prop("checked", $(obj).prop("checked") );
}
/*
 * Esconde registros das tabelas conforme filtros
 */
function listaFiltro(obj,table){
	var filtro = $(obj).val().toLowerCase();
	$("#"+table+" tbody tr").each(function(){
		if( $(this).text().toLowerCase().indexOf(filtro) === -1 ){
			$(this).hide();
		}else{
			$(this).show();
		}
	});
}
function convertSize(val){
	var c = {1:'K',2:'M',3:'G',4:'T'};
	var v = 0;
	for( i=1; i <= 4; i++ ){
		v = val / ( Math.pow( 1024, i ) );
		if( v > 0 && v < 1024 ) break ;
	}
	return ( arguments[1] == true ) ? v.toFixed(2) + " " + c[i] + "iB" : v.toFixed(2);
	
}
function convertBytes(val,to){
	var c = {'K':1,'M':2,'G':3,'T':4};
	val = val / ( Math.pow( 1024, c[to.toUpperCase()] ) );
	return ( arguments[2] == true ) ? val.toFixed(2) + " " + to.toUpperCase() + "iB" : val.toFixed(2);
}
function dialogoError(){
	$.ajax({url : "/Sys/errorClean",type : "post"});
	$( "#dialogoError").modal();
}
function mensagemError(){
	//$.ajax({url : "/Sys/mensagemClean",type : "post"});
}
function progressoMain(obj,w){
	var obj = ( typeof obj == "object" ) ? $(obj) : $("#"+obj);
	progressoBarra( obj, w );
	progressoLabel( obj, ( arguments[2] || w + "%" ) );
	progressoClass( obj, ( arguments[3] || "primary" ) );
}
function progressoLabel(obj,label){
	$(obj).children().html(label);
}
function progressoClass( obj, c ){
	$(obj).attr("class", "progress-bar progress-bar-"+c);
}
function progressoBarra(obj,val){
	if( obj && isVal(val) )
		$(obj).css("width",val+"%");
}
function naoZero(n){
	var v = ( n == 0 || typeof n == "undefined" ) ? 1 : n;
	return v;
}
function infoBottom(a,t,m){
	t = t || 'd';
	a = a || true;
	var info = [];
	info['d'] = info['primary'] = 'alert-default';
	info['s'] = info['success'] = 'alert-success';
	info['e'] = info['danger'] = 'alert-danger';
	info['a'] = info['warning'] = 'alert-warning';
	info['i'] = info['info'] = 'alert-info';
	$("#infoBottom").html(m);
	if( a )
		$("#infoBottom")
			.addClass( info[t] )
			.show();
	else
		$("#infoBottom").hide();
	mensagemError();
}
function retornaVariavel(){
	for( var i=0; i < arguments.length ; i++ ){
		if( isVal(arguments[i]) ){
			return arguments[i];
		}
	}
	return false;
}
function retornaVariavelFiltro(O,filtro ){
	var f = filtro.split( "." );
	var ff = f[ 0 ];
	f.splice(0,1);
	if( f.length >= 1 ){
		if( typeof O[ ff ] !== 'undefined' ){
			return retornaVariavelFiltro( O[ ff ], f.join(".") );
		}
		return;
	}else{
		return O[ ff ];
	}
}
function retornaArray(){
	var ar = [];
	for( var i=0; i < arguments.length ; i++ ){
		if( isVal(arguments[i]) ){
			ar.push(arguments[i]);
		}
	}
	return ar;
}
function retornaObjectToArray(){
	var ar = [];
	var l = arguments.length;
	for(var i=0; i < l; i++ ){
		if( typeof arguments[i] != "undefined" ){
			if( typeof arguments[i] == "object" || typeof arguments[i] == "array" ){
				for(var key in arguments[i]) {
					if( retornaVariavel( arguments[i][key].length, 1 ) == 1 ){
						ar.push([ arguments[i][key] ]);
					}else{
						ar.push(arguments[i][key]);	
					}
				}	
			}else{
				ar.push(arguments[i]);
			}
		}
	}
	return ar;
}
function retornaNomeObject(o){
	if( typeof o == "undefined" ){
		return false;
	}
	return Object.getOwnPropertyNames(o);
}
function retornaObject(){
	var ar = {};
	var l = arguments.length;
	for( var i=0; i < l; i++ ){
		if( typeof arguments[i] != "undefined" ){
			if( typeof arguments[i] == "object" || typeof arguments[i] == "array" ){
				for(var key in arguments[i]) {
					ar[key] = arguments[i][key];
				}
			}
		}
	}
	return ar;
}
function retornaQuantidadeObject(O){
	return Object.keys(O).length;
}
function carregaJS( f ){
	//	Verificando JS
	if( $("script[src^='/assets/lib/js/"+f+"']").length == 0 ){
		var fref = document.createElement('script');
		fref.setAttribute("type","text/javascript");
		fref.setAttribute("src", "/assets/lib/js/" + f );
		if ( typeof fref != "undefined" ){
			document.getElementsByTagName("head")[0].appendChild( fref );
		}
	}
	if( typeof arguments[1] != "undefined" ){
		return arguments[1]();
	}
}
function carregaCSS( f ){
	//	Verificando CSS
	if( $("link[href^='/assets/lib/css/"+f+"']").length == 0 ){
		var fref = document.createElement('link');
		fref.setAttribute("rel", "stylesheet");
		fref.setAttribute("type", "text/css");
		fref.setAttribute("href", "/assets/lib/css/" + f );
		if ( typeof fref != "undefined" ){
			document.getElementsByTagName("head")[0].appendChild( fref );
		}
	}
	if( typeof arguments[1] != "undefined" ){
		return arguments[1]();
	}
}
function validate(filter){
	if( typeof filter == "undefined" )
		return false;
	
	var valid = i = 0;
	$( filter ).each(function(){
		i++;
		$(this)
			.parsley()
			.on('field:success', function() {
				valid++; 
			})
			.validate();
	});
	return !(i-valid);
}
function getFields(filter){
	getVal = {};
	$(filter).each(function(){
		if( $(this).length > 0 && ( $(this).attr("id") || $(this).attr("name") ) ){
			getVal[ $(this).attr("id") || $(this).attr("name") ] = $(this).val();
		}
	});
	return getVal;
}
function getFieldsMult(filter){
	getVal = [];
	$(filter).each(function(){
		if( $(this).length > 0 && ( $(this).attr("id") || $(this).attr("name") ) ){
			getVal.push( $(this).val() );
		}
	});
	return getVal;
}
function preventGo(a){
	if( a ){
		window.onbeforeunload = function() {
			setTimeout(function(){loader("hide")},100);
			return false;
		}
	}else{
		window.onbeforeunload = null;
	}
}
function submit( URL ){
	if( typeof URL === 'undefined' ){
		return false;
	}
	if( typeof arguments[2] !== 'undefined' ){
		$(arguments[2]).attr( 'action', URL ).submit();
	}else{
		$('#formulario').attr( 'action', URL ).submit();
	}
}
function addFieldForm(id,val){
	var form = arguments[3] || '#formulario';
	$( form ).prepend($('<input type="hidden" id="'+id+'" name="'+id+'" value="'+val+'" />'));
}
function selectLineInTable( obj, callback ){
	$(".bg-lightgray").removeClass("bg-lightgray");
	$(obj).addClass("bg-lightgray");
	callback( obj );
}
function htmlConvertToDB(string){
	return string;
	//return htmlEncode( replaceAll( '"', '!aspa!', string ));
}
function disableElement(query, val){
	$(query).prop('disabled', !!val);
}
function htmlEncode(string){
	return $('<div/>').text(string).html();
}
function htmlDecode(string){
  	return $('<div/>').html(string).text();
}
function utf8Decode(t){  
  return decodeURIComponent(escape(t))  
} 
function htmlStrip(html){
	html = replaceAll("font-family:","",html);
	return html;
}
function abort(t){
	throw new Error(t);
}
function validChecksStats(id,checks){
	$.each( checks, function(i,v){
		if( $("#" + id + " i[data-"+checks[i][0]+"='"+checks[i][1]+"']").length ){
			mensagem( checks[i][2], checks[i][3] );
			abort('ValidChecks:die');
		}
	});
}
function showFooterInfo(obj){
	$("#footerInfo").toggleClass('sys-footer-info-hide');
	$("#btnFooterInfo").toggleClass('glyphicon-chevron-down');
	obj.data( 'status', !obj.data( 'status') );
	loadFooterInfo();
}
function loadFooterInfo(){
	
	if( $("#footerInfo").hasClass('sys-footer-info-hide') ){
		return false;
	}
	$(".sys-footer-info-input").val('');
	
	var line = $("#tableIndex tbody tr.bg-lightgray");
	if( !line.length ){
		$("#loader-small").hide();
		return false;
	}
	$.ajax({
		url : '/FluxoDigitacao/info/' + line.data('codlaudo'),
		type : 'POST',
		timeout: 10000,
		data : {},
		beforeSend: function(){
			$("#loader-small").show();
		},
		success: function( retorno ){
			var ret = jsonEncode( retorno, 'json' );
			$.each(ret, function(i,v){
				$("#"+i).val(v);
			});
			$("#loader-small").hide();
		},
		error: function( request, status, error ){
			mensagem('e', error);
			$("#loader-small").hide();
		}
	});
}
function loadMsgs(){
	$.ajax({
		url : '/Sys/loadMsgs',
		type : 'POST',
		timeout: 10000,
		data : {},
		beforeSend: function(){
			loader('show')
		},
		success: function( retorno ){
			var j = jsonEncode( retorno, 'json' );
			if( !j.status ){
				return false;
			}
			loadMsgsShow(j.content, 0);
			loader('hide');
		},
		error: function( request, status, error ){}
	});
}
function loadMsgsClean(cod){
	$.ajax({
		url : '/Sys/loadMsgsClean',
		type : 'POST',
		timeout: 10000,
		data : {'CodMens':cod},
		beforeSend: function(){},
		success: function( retorno ){},
		error: function( request, status, error ){}
	});
}
function loadMsgsShow(o,i){
	if( typeof o[i] !== "undefined" ){
		dialogo({
			'titulo':o[i].TITULO,
			'texto':o[i].MENSAGEM,
			'fnc1': function(){
				loadMsgsClean(o[i].CODMENS);
				loadMsgsShow(o, i+1);
			},
			'tipo':'a',
			'btn1':'Ok',
			'largo':true
		});
	}
}
function tableSimple(obj, id, css){
	if( typeof obj == "undefined" ){
		return '';
	}
	var html = "<table id='"+id+"' class='table table-condensed table-hover "+css+"'><thead><tr>";
	var titles = {};
	$.each(retornaNomeObject(obj[0]),function(i,v){
		html += "<th>"+v+"</th>";
		titles[i] = v;
	});
	html += "</tr></thead><tbody>";
	$.each(obj,function(i,v){
		html += "<tr>";
		$.each(obj[i],function(ii,vv){
			html += "<td>"+vv+"</td>";
		});
		html += "</tr>";
	});
	html += "</tbody></table>";
	return html;
}
/* Monitora teclas de atalhos*/
function monitorKey( teclas, callback ){
	var map = [];
	var debug = arguments[2] || false;
	$.each(teclas, function(i,v){
		map[v] = false;
	});
	$( window ).keydown(function(e) {
		if( debug )
			console.log("Tecla precionada: " + e.keyCode );
		if ( $.inArray( e.keyCode, teclas ) > -1 ) {
			map[ e.keyCode ] = true;
			if ( map.every( function(ee,i,a){ return ee == true ;} ) ) {
				e.preventDefault();
				$.each(teclas, function(i,v){
					map[v] = false;
				});
				callback();
			}
		}
	}).keyup(function(e) {
		if ( $.inArray( e.keyCode, teclas ) > -1 ) {
			map[ e.keyCode ] = false;
		}
	});
}
/* Monitora teclas de atalhos*/
function monitorKeyEditor( editor, teclas, callback ){
	var map = [];
	$.each(teclas, function(i,v){
		map[v] = false;
	});
	editor.on('keydown', function(e){
		if ( $.inArray( e.keyCode, teclas ) > -1 ) {
			map[ e.keyCode ] = true;
			if ( map.every( function(ee,i,a){ return ee == true ;} ) ) {
				e.preventDefault();
				$.each(teclas, function(i,v){
					map[v] = false;
				});
				callback();
			}
		}
	});
	editor.on('keyup', function(e){
		if ( $.inArray( e.keyCode, teclas ) > -1 ) {
			map[ e.keyCode ] = false;
		}
	});
}
/*	Adiciona um evento em um elemento, esperando o pressionamento de determinada tecla do teclado */
function keyCallClick( element, target, key, callback ){
	$(element).keyup(function(event){
	    if(event.keyCode == key){
	        $(target).click();
	        if( typeof callback !== "undefined" ){
	        	callback();
	        }
	    }
	});
}
function firstCharUpper(string){
	return string.charAt(0).toUpperCase() + string.slice(1);
}
function inArray(a,p){
	if( a && p ){
		var l = p.length;
		for (var i=0; i < l; i++) {
			if( a == p[i] ){
		    	return p[i];
		    }
		}
	}
	return false;
}
function linesTable( list ){
	var html;
	$.each(list, function(i,v){
		html += "<tr>";
		$.each(v, function(ii,vv){
			html += "<td>"+ ( vv || '' ) +"</td>"; 
		});
		html += "</tr>";
	});
	return html;
}
function mediaQuery(query, success, fail){
	if (window.matchMedia(query).matches) {
		if( typeof success !== "undefined" ){
			success();
		}
	} else {
		if( typeof fail !== "undefined" ){
			fail();
		}
	}
}
function getSegment(){
	let url = window.document.location.href.replace('//','/').split('/');
	if( typeof arguments[0] != 'undefined' ){
		return url[arguments[0]];
	}
	return url;
}
function selectFill( ob, call ){
	var obj = $( ob );
	clearTimeout( obj.data('sfi') );
	
	obj.data('sfi', setTimeout(function(){
		var o = {};
		o.sfv = obj.val();
		$.each(obj.data(), function(i,v){
			if( i.substring(0,2) == 'sf' ){
				o[i] = v;
			}
		});
		var abj = $('#'+o.sfa);
		$.ajax({
			url : '/AllclinicRadiologia/Sys/selectFill',
			type : 'POST',
			data : o,
			timeout: 30000,
			beforeSend: function(){
				selectFillLD(abj,true);
			},
			success: function( retorno ){
				var r = jsonEncode( retorno, 'json' );
				if( abj.prop('tagName') == 'SELECT' ){
					abj.html('');
					abj.append('<option value=""> --- </option>');
					$.each(r, function(i,v){
						abj.append('<option value="'+i+'">'+v+'</option>');
					});
				}else if( abj.prop('tagName') == 'INPUT' ){
					$.each(r, function(i,v){
						abj.val(v);
						return false;
					});
				}
				selectFillLD(abj,false);
				if( typeof call == 'function' ){
					call();
				}
			},
			error: function( request, status, error ){
				selectFillLD(abj,false);
				mensagem('e',error);
			}
		});
	}, 500));
}
function selectFillLD( o, a ){
	if( a ){
		o.prop('disabled',true);
		o.after( '<img id="sfld'+o.prop('id')+'" class="sys-sf-loader" src="/AllclinicRadiologia/assets/images/loader-sf.gif"/>' );
	}else{
		o.prop('disabled',false);
		$('#sfld'+o.prop('id')).remove();
	}
}
/*	Retorna a diferença de dias entre duas datas no formato dd/mm/aaaaa */
function dateDiff( d1, d2 ){
	if( typeof d1 == "undefined" || typeof d2 == "undefined" ){
		return false;
	}
	var nd1 = dateCreate( d1 );
	var nd2 = dateCreate( d2 );
	return Math.round(( nd2 - nd1 ) / ( 1000 * 60 * 60 * 24 ));
}
function startDateRange( d1, d2, i ){
	startData(d1+','+d2);
	$(d1+','+d2)
		.on('changeDate', function(event){
			var d = dateCreate( $(event.target).val() );
			if( ( $(event.target).val() != $(event.target).data('range') ) && ( d && d != 'Invalid Date' ) ){
				$(event.target).data('range', $(event.target).val());
				dateRange(event, $(d1), $(d2), i);
			}
		});
}
function dateRange( e, d1, d2, i ){
	var nd1 = dateCreate( d1.val() );
	var nd2 = dateCreate( d2.val() );
	if( e.target.id == d1.attr('id') ){
		if( nd2 == 'Invalid Date' ){
			nd2 = new Date(nd1);
			nd2.setDate(nd2.getDate() + i );
		}else{
			let dd = dateDiff(dateConvert(nd1, 'dd/mm/aaaa'), dateConvert(nd2, 'dd/mm/aaaa'));
			if( dd < 0 || dd > i ){
				nd2 = new Date(nd1);
				nd2.setDate(nd2.getDate() + i );	
			}
		}
	}else 
	if( e.target.id == d2.attr('id') ){
		if( nd1 == 'Invalid Date' ){
			nd1 = new Date(nd2);
			nd1.setDate(nd1.getDate() - i);
		}else{
			let dd = dateDiff(dateConvert(nd1, 'dd/mm/aaaa'), dateConvert(nd2, 'dd/mm/aaaa'));
			if( dd < 0 || dd > i ){
				nd1 = new Date(nd2);
				nd1.setDate(nd2.getDate() - i );
			}
		}
	}
	d1.val(dateConvert(nd1,'dd/mm/aaaa')).datepicker('update', nd1);
	d2.val(dateConvert(nd2,'dd/mm/aaaa')).datepicker('update', nd2);
	return false;
}
//	Converte datas
function dateConvert( d, f ){
	f = f.toLowerCase();
	if( f == 'aaaa-mm-dd' ){
		return d.toISOString().slice(0,10);
	}else 
	if( f == 'dd/mm/aaaa' ){
		return d.toLocaleString('pt-BR', {timeZone: 'UTC'}).slice(0,10);
	}
	return false;
}
function dateCreate( d ){
	//	AAAA-MM-DD
	if( /^\d{4}\-\d{1,2}\-\d{1,2}$/.exec( d ) ){
		return new Date( parseInt(d.substring(0,4)) + '-' + parseInt(d.substring(5,7)) + '-' + parseInt(d.substring(8,10)));
	}else 
	//	DD/MM/AAAA
	if( /^\d{2}\/\d{2}\/\d{4}$/.exec( d ) ){
		return new Date( parseInt(d.substring(6,10)) + '-' + parseInt(d.substring(3,5)) + '-' + parseInt(d.substring(0,2)) );
	}
	return false;
}
function elSetErrorCss( query ){
	$(query).addClass('parsley-error');
}
function elClsErrorCss( query ){
	$(query).removeClass('parsley-error');
}
function getAgentInfo(){
	var agent = {};
	agent.width = $(window).width();
	try{ 
		document.createEvent("TouchEvent"); 
		agent.touch = true;
	}catch(e){ 
	  	agent.touch = false; 
	}
	$.ajax({
		url : '/Sys/getAgentInfo',
		type : 'POST',
		timeout: 10000,
		data : agent
	});
}
function loadViewXHR(view, p, callback){
	$.ajax({
		url : '/Sys/loadViewXHR',
		type : 'POST',
		timeout: 20000,
		data : {"view": view},
		beforeSend: function(){
			loader('show')
		},
		success: function( retorno ){
			loader('hide');
			p.texto = retorno;
			dialogo(p);
			if (typeof callback == "function") {
				callback();
			}
		}
	});
}
function dialogOpen(){
	return $("#dialogo1").is(":visible");
}

function somenteNumeros(num) {
	//campo.value.replace(',','.');
	var er = /[^0-9.]/;
	er.lastIndex = 0;
	var campo = num;
	campo.value =  campo.value.replace(',','.');        
	
	if (er.test(campo.value)) {
	  campo.value = "";
	   }		 
   }
$("document").ready( function () {
	startTooltip();
	startSelect();
	startMask();
	startOrderTable("#tableIndex");
	if( $("#formulario").length > 0 ){
		$("#formulario")
			.submit(function(){
				loader("show");
			})
			.parsley().on( "form:error", function() {
				mensagem( "e", "Existem campos que devem ser informados corretamente." );
				loader("hide");
			});
	}
	/*	Previnindo enter nos submit*/
	/*$(window).keydown( function(event){
		if( event.keyCode == 13 ) {
			event.preventDefault();
			return false;
	    }
	});*/
	$('#dialogo1, #dialogo2').on('hidden.bs.modal,hidden', '.modal', function(){
		$(this).removeData('bs.modal');
	});
})