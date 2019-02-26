var Usuario = function(){
	var _self = this;

	this.salvar = function(){
		let apeluser = $('#FFAPELUSER1').val();
		let apeluserNovo = $('#FFAPELUSER').val();
		let codinst = $('#FFINSTITUICAO').val();
		let senha1 = $('#txt-senha').val();
		let senha2 = $('#txt-confir-senha').val();
		if(!codinst > 0){
			mensagem('e', 'Informe a Instituição');
			return
		}
		if(!apeluserNovo){
			mensagem('e', 'Informe o Login');	
			return
		}
		//se for usuario novo obriga a informar a senha
		if(apeluser){ //ediar
			if(senha1  ||  senha2){
				if(senha1 != senha2){
					mensagem('e', 'Senha não confere');
					return
				}
			}			
		}else{ //novo
			if(validaSeUsuarioJaFoiCadastrado(apeluserNovo, codinst)){
				mensagem('e', 'Login já cadastrado nessa Instituição');
					return
			}
			if(senha1 == false){
				mensagem('e', 'Informe a senha');
				return
			}
			if(senha2 == false){
				mensagem('e', 'Confirme a Senha');
				return
			}
			if(senha1 != senha2){
				mensagem('e', 'Senha não confere');
			return
			}
		}
		//$("#formularioCadastro").submit();
			
	}

	function validaSeUsuarioJaFoiCadastrado(apeluser, codinst) {
		var usuarioCadastrado = false;
		console.log("teste1");
		$.ajax({
			url : '/AllclinicRadiologia/Usuarios/usuarioJaCadastrado/',
			type :  'POST',
			timeoute : 30000,
			data : {
				'apeluser' : apeluser,
				'codinst' : codinst,
			},
			beforeSend: function(){
				loader('show');
			},
			success: function( retorno){
				console.log("teste");
				var j = jsonEncode( retorno, 'json');
				usuarioCadastrado =  j.usuarioCadastrado;
				console.log("teste");
				loader('hide');
			},
			error: function( request, status, error){
				loader('hide');
				mensagem('e', error );
			}
		});
		return usuarioCadastrado;
	}

}

$("document").ready(function(){
	var controle = new Usuario();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Usuarios/novo');
	});
	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Usuarios/Index');
	});	
	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$("select").prop('selectedIndex',0);
			$('#btnSearch').trigger('click')
		});
	$("#btnSalvar")
	.click(function(){
		//
		controle.salvar();
	});	

		

});
