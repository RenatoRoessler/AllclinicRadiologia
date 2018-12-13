<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Fracionamento extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}

	public function index(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());
		$dados['js'] = 'js/Fracionamento.js'; 
		$post['CODINST'] = $_SESSION['CODINST'];

		if( !isset($post['FFDATAPESQUISA']) ){
			$post['FFDATAPESQUISA'] = date("d/m/Y");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAPESQUISA'] < 1){
			$post['FFDATAPESQUISA'] = date("d/m/Y");	
		}
		if( !isset($post['FFDATAFINALPESQUISA']) ){
			$post['FFDATAFINALPESQUISA'] = date("d/m/Y");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAFINALPESQUISA'] < 1){
			$post['FFDATAFINALPESQUISA'] = date("d/m/Y");	
		}

		/*Carregando o Fracionamento */
 		$this->load->model('FracionamentoModel');
 		$this->FracionamentoModel->index( $post  );
 		$dados['fracionamento'] = $this->FracionamentoModel->dados;
 		
		$this->load->view('template/header',$dados);
		$this->load->view('FracionamentoView');
		$this->load->view('template/footer');
	}

	public function adicionar(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());

		$this->load->model('FracionamentoModel');

		if( $post['CODMARCACAO'] ){
			$codigo = $post['CODMARCACAO'];
			$coditem = $this->FracionamentoModel->inserirItemFracionamento($post);
			if( $coditem ){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Adicionado com Sucesso','codmarcacao' => $codigo ) ,  true );	
			}else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao adicionar ','codmarcacao' => $codigo ) ,  true );	
			}	
		}	
		else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao Adicioar ','codfracionamento' => $codigo ) ,  true );
		}
		echo jsonEncodeArray( $this->json );  		
	}
	
	public function editar( $cod = null)
	{
		$dados['js'] = 'js/Fracionamento.js';
		$codmarcacao = $cod > 0 ? $cod : $this->uri->segment(3);
		/* Carregando os Pacientes */ 
		$this->load->model('PacienteModel');
		$this->PacienteModel->buscaTodosPaciente();
		$dados['paciente'] = $this->PacienteModel->dados;

		/*  Carregando as marcação */
		$this->load->model('MarcacaoModel');
		$this->MarcacaoModel->buscaMarcacao($codmarcacao);
		$dados['marcacao'] = $this->MarcacaoModel->dados;
		 
		 // carregando os Pacientes Fracionados 
		$this->load->model('FracionamentoModel');
 		$this->FracionamentoModel->buscaItensFracionamento( $codmarcacao );
		$dados['pacientesAdicionados'] =  $this->FracionamentoModel->dados;		

 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('FracionamentoCadastroView');
		$this->load->view('template/footer');
	}

	public function excluirItem()
	{
		/* carregando o fracionamento */
 		$this->load->model('FracionamentoModel');
 		/* pegando o codfracionamento */ 
 		$codfracionamento = $this->FracionamentoModel->getCodfracionamento( $this->uri->segment(3) );
 		/* Excluindo Item */
 		$this->FracionamentoModel->excluirItem( $this->uri->segment(3) );

 		$this->editar($codfracionamento);
	}

	public function excluir()
	{
		/* carregando o fracionamento */
 		$this->load->model('FracionamentoModel');
 		/* Excluindo Item */
 		$this->FracionamentoModel->excluir( $this->uri->segment(3) );
 		$this->index();
	}
}


