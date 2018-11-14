var PesquisaExame = function(){
	var _self = this;
	this.filtraProcedimento = function( param, callback ){
		$.ajax({
			url : '/AllclinicRadiologia/Procedimentos/listarProcedimentosFiltro/',
			type : 'POST',
			timeout: 10000,
			data : param,
			beforeSend: function(){ 
				loader('show');
			},
			success: function( retorno ){
				$("#tableExames tbody").html( retorno );
				$("#tableExames tbody tr").click(function(){
					selectLineInTable( $(this), function( line ){
						_self.setarDados( $(line).data( 'codprocedimento' ), $(line).data( 'descricao' ) );
					} );
				});
				if( typeof callback !== "undefined" ){
					callback();
				}
				loader('hide');
			},
			error: function( request, status, error ){
				loader('hide');
			}
		});
	}
	this.setarDados = function( id, nome ){
		loader('show');
		document.getElementById('FFPROCEDIMENTO').value = id;	
		document.getElementById('FFNOMEPROCEDIMENTOTELA').value = nome;	
	}
}
