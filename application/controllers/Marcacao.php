<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Marcacao extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}

	public function index(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());
		$post['CODINST'] = $_SESSION['CODINST'];
		$dados['js'] = 'js/Marcacao.js'; 
		// se não existir
		if( !isset($post['FFDATAPESQUISA']) ){
			$post['FFDATAPESQUISA'] = date("d/m/Y");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAPESQUISA'] < 1){
			$post['FFDATAPESQUISA'] = date("d/m/Y");	
		}
		// se não existir
		if( !isset($post['FFATIVOFILTRO']) ){
			$post['FFATIVOFILTRO'] = 'S';
		}
		// se não existir
		if( !isset($post['FFDATAFINAL']) ){
			$post['FFDATAFINAL'] = date("d/m/Y");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAFINAL'] < 1){
			$post['FFDATAFINAL'] = date("d/m/Y");	
		}
		/*carregando as Marcações */ 
		$this->load->model('MarcacaoModel');
		$this->MarcacaoModel->index( $post );
		$dados['marcacao'] = $this->MarcacaoModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('MarcacaoView');
		$this->load->view('template/footer');
	}

	public function novo()
	{
		$dados['js'] = 'js/Marcacao.js';
		
 		$dados['retorno'] = null; //$this->InstituicaoModel->dados;
 		$dados['MSG'] = $this->session->MSG;

 		/*carregando as Eluições */ 
		$this->load->model('EluicaoModel');
		$this->EluicaoModel->buscaEluicoes();
		$dados['eluicao'] = $this->EluicaoModel->dados;

		/*carregando os farmacos */ 
		$this->load->model('FarmacoModel');
		$this->FarmacoModel->buscaTodosFarmacos();
		$dados['farmaco'] = $this->FarmacoModel->dados;

		/*carregando os Fabricantes  */ 
		$this->load->model('FabricanteModel');
		$this->FabricanteModel->buscaTodosFabricante(  );
		$dados['fabricantes'] = $this->FabricanteModel->dados;
 		/* Radiofarmacos 
		$this->FabricanteModel->buscaFabricantePeloTipo( 2 );
		$dados['radiofarmacos'] = $this->FabricanteModel->dados;
		*/

		$this->load->view('template/header',$dados);
		$this->load->view('MarcacaoCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar()
	{
		$post = limpaVariavelArray( $this->input->post());
		$codigo = null;
		$post['APELUSER'] = $_SESSION['APELUSER'];
		$this->load->model('MarcacaoModel');
					
			if($post){
				if( $post['FFCODMARCACAO'] ){
					$this->MarcacaoModel->atualizar($post);
					$codigo = $post['FFCODMARCACAO'];
				}else{
					$codigo = $this->MarcacaoModel->inserir($post);
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Marcação. <br/>[' . $this->MarcacaoModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Marcação salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);	
	}

	public function editar()
	{
		$dados['js'] = 'js/Marcacao.js';	
		
		/*carregando os Fabricantes  */ 
		$this->load->model('FabricanteModel');
		$this->FabricanteModel->buscaTodosFabricante(  );
		$dados['fabricantes'] = $this->FabricanteModel->dados;
		/*carregando os farmacos */ 
		$this->load->model('FarmacoModel');
		$this->FarmacoModel->buscaTodosFarmacos();
		$dados['farmaco'] = $this->FarmacoModel->dados;

		/* carregando a marcação */ 
		$this->load->model('MarcacaoModel');
		$this->MarcacaoModel->buscaMarcacao( $this->uri->segment(3) );
		$dados['retorno'] = $this->MarcacaoModel->dados;
		 
		 /*carregando as Eluições */ 
		$this->load->model('EluicaoModel');
		$this->EluicaoModel->buscaEluicoes( false, $dados['retorno'][0]['CODELUICAO']);
		$dados['eluicao'] = $this->EluicaoModel->dados;

 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('MarcacaoCadastroView');
		$this->load->view('template/footer');
		
	}

	public function gerarLoteMarcacao()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('EluicaoModel');
		//pegando a quantidade de eluições gerados com o gerador
		$lote = $this->EluicaoModel->qtdMarcacaoGerador( $post['codeluicao'], $post['codmarcacao']  );
        $lote += 1;	
		echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'lote' => $lote) ,  true );	
		echo jsonEncodeArray( $this->json ); 

	}
	public function excluir()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('MarcacaoModel');
		if($this->MarcacaoModel->MarcacaoPodeSerExcluido( $post['Codigo'] )){
			if($this->MarcacaoModel->excluirMarcacao( $post['Codigo'] )){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Excluido com Sucesso' ) ,  true );	
			}else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao excluir. <br/>[' . $this->MarcacaoModel->db->error() . ']' ) ,  true );	
			}				
		}else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Fracionameto Gerado' ) ,  true );	
		}		
		echo jsonEncodeArray( $this->json ); 
	}
}
