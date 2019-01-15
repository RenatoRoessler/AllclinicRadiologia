<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Eluicao extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}

	public function index(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());
		$dados['js'] = 'js/Eluicao.js'; 
		$post['CODINST'] = $_SESSION['CODINST'];
		// se não existir
		if( !isset($post['FFDATAPESQUISA']) ){
			$post['FFDATAPESQUISA'] = date("d/m/Y");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAPESQUISA'] < 1){
			$post['FFDATAPESQUISA'] = date("d/m/Y");	
		}
		// se não existir
		if( !isset($post['FFDATAFINAL']) ){
			$post['FFDATAFINAL'] = date("d/m/Y");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAFINAL'] < 1){
			$post['FFDATAFINAL'] = date("d/m/Y");	
		}
		// se não existir
		if( !isset($post['FFATIVOFILTRO']) ){
			$post['FFATIVOFILTRO'] = 'S';
		}

		/*Carregando os Geradores Ativos*/
 		$this->load->model('GeradorModel');
 		$this->GeradorModel->buscaGeradorAtivos( $post['CODINST']  );
 		$dados['gerador'] = $this->GeradorModel->dados;

		/*Carregando as Eluições*/
 		$this->load->model('EluicaoModel');
 		$this->EluicaoModel->index( $post );
 		$dados['eluicao'] = $this->EluicaoModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('EluicaoView');
		$this->load->view('template/footer');
	}

	public function novo()
	{
		$dados['js'] = 'js/Eluicao.js';
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG;

 		/*Carregando os Geradores Ativos*/
 		$this->load->model('GeradorModel');
 		$this->GeradorModel->buscaGeradorAtivos( $_SESSION['CODINST']  );
 		$dados['gerador'] = $this->GeradorModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('EluicaoCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('FFHORA','Hora','required');
		$this->form_validation->set_rules('FFLOTE','LOTE','required');	
		$this->form_validation->set_rules('FFDATAHORA','Data','required');	
		$this->form_validation->set_rules('FFGERADOR','Gerador','required');
		$this->form_validation->set_rules('FFVOLUME','Volume','required');	
		$this->form_validation->set_rules('FFATIVIDADE_MCI','Atividade Mci','required');	
		if($post['FFCQ'] == 'S'){
			$this->form_validation->set_rules('FFATIVIDADETEORICA','Eficiência Teórica','required');
			$this->form_validation->set_rules('FFATIVIDADE_MEDIDA','Medida','required');
			$this->form_validation->set_rules('FFRESULTADO','Resultado','required');	
			$this->form_validation->set_rules('FFPUREZA_RADIONUCLIDICA','Pureza Radionuclidica','required');
			$this->form_validation->set_rules('FFPUREZA_QUIMICA','Pureza Quimica','required');	
			$this->form_validation->set_rules('FFCQ','PH','required');	
		}
		
		$codigo = null;
		$this->load->model('EluicaoModel');
		if($this->form_validation->run() == FALSE){
			$this->novo();
		}else{			
			if($post){
				if( $post['FFCODELUICAO'] ){
					$this->EluicaoModel->atualizar($post);
					$codigo = $post['FFCODELUICAO'];
				}else{
					$codigo = $this->EluicaoModel->inserir($post);
					$this->EluicaoModel->updateNroEluicao( $post );
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Eluição. <br/>[' . $this->EluicaoModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Eluição salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);
		}				
	}

	public function editar()
	{
		$dados['js'] = 'js/Eluicao.js';
		/* carregando as instituições */
 		$this->load->model('EluicaoModel');
 		/*Carregando os Geradores Ativos*/
 		$this->load->model('GeradorModel');
 		$this->GeradorModel->buscaGeradorAtivos( $_SESSION['CODINST']  );
 		$dados['gerador'] = $this->GeradorModel->dados;
 		/*  Carregando as Eluições */
 		$this->EluicaoModel->buscaEluicao( $this->uri->segment(3) );
 		$dados['retorno'] = $this->EluicaoModel->dados;
 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('EluicaoCadastroView');
		$this->load->view('template/footer');
	}

	public function excluir()
	{
		//$this->load->model('EluicaoModel');
		//$this->EluicaoModel->excluir($this->uri->segment(3));
		//$this->index();	
		
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('EluicaoModel');
		if($this->EluicaoModel->EluicaoPodeSerExcluido( $post['Codigo'] )){
			if($this->EluicaoModel->excluir( $post['Codigo'] )){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Excluido com Sucesso' ) ,  true );	
			}else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao excluir. <br/>[' . $this->EluicaoModel->db->error() . ']' ) ,  true );	
			}				
		}else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Eluicao Vinculado na marcação' ) ,  true );	
		}		
		echo jsonEncodeArray( $this->json ); 
	}

	public function gerarLoteEluicao()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('GeradorModel');
		//pegando a quantidade de eluições gerados com o gerador
		$lote = $this->GeradorModel->qtdEluicoesGerador( $post['codgerador'] );
		$lote += 1;	
		$this->GeradorModel->buscaGerador( $post['codgerador'] );
		$dados = $this->GeradorModel->dados;
		$atividade = $dados[0]['ATIVIDADE_CALIBRACAO'];
		
		echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'lote' => $lote, 'atividade' => $atividade) ,  true );	
		echo jsonEncodeArray( $this->json );
	}
}