var PesquisarPaciente = function(){
	var _self = this;
	this.filtraTextoPadrao = function( param, callback ){
		$.ajax({
			url : '/Allclinic/Paciente/listarPacientesTela/',
			type : 'POST',
			timeout: 10000,
			data : param,
			beforeSend: function(){ 
				loader('show');
			},
			success: function( retorno ){
				$("#tableTextoPadrao tbody").html( retorno );
				$("#tableTextoPadrao tbody tr").click(function(){
					selectLineInTable( $(this), function( line ){
						_self.setarDados( $(line).data( 'prontuario' ), $(line).data( 'nome' ) );
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
		document.getElementById('FFPRONTUARIO').value = id;	
		document.getElementById('FFNOMEPAC').value = nome;	
	}
}
