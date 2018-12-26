var Convenio = function(){
	var _self = this;

    this.excluir = function(a){
		if(document.getElementById("FFCODCONV").value > 0){
			dialogo({
				"titulo":'Excluir Convênio',
				"texto":'Deseja Excluir',
				"fnc1":function(){
					$.ajax({
						url : '/AllclinicRadiologia/Convenio/excluir/',
						type : 'POST',
						timeout: 30000,
						data : {
							'Codigo' : $('#FFCODCONV').val(),
						},
						beforeSend: function(){
							loader('show');
						},
						success: function( retorno ){
							var j = jsonEncode( retorno, 'json' );
							mensagem(j.content.tipoMsg , j.content.Mensagem);
							loader('hide');	
							if(j.content.tipoMsg == 's'){
								ir('/AllclinicRadiologia/Convenio');
							}							
						},
						error: function( request, status, error ){ 
							loader('hide');
							mensagem( 'e', error )
						}
					});
				},
				"tipo":'p',
				"b1":'Confirmar',
				"b2":'Cancelar' 
			});
		}
	}



}

$("document").ready(function(){
    var controle = new Convenio();
    
    $("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Convenio/novo');
    });
    
    $("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Convenio');
    });

    $("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
    });
    
    $("#btnExcluirConvenio")
	.click(function(){
		controle.excluir();
    });



});