var PesquisaAgendamento = function(){
	var _self = this;
	this.filtraAgendamento = function( param, callback ){
		$.ajax({
			url : '/AllclinicRadiologia/Agendamento/listarAgendamentoFiltro/',
			type : 'POST',
			timeout: 10000,
			data : param,
			beforeSend: function(){ 
				loader('show');
			},
			success: function( retorno ){
				$("#tableAgendamentos tbody").html( retorno );
				$("#tableAgendamentos tbody tr").click(function(){
					selectLineInTable( $(this), function( line ){
						_self.setarDados( $(line).data( 'codagtoexa' ), $(line).data( 'nome' ) );
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
		document.getElementById('FFCODAGTOEXA1').value = id;	
		document.getElementById('FFAGENDAMENTO').value = nome;	
	}
}
