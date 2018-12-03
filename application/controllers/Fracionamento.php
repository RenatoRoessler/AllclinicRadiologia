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

	public function novo()
	{
		$dados['js'] = 'js/Fracionamento.js';
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG;
 			/*  Carregando as marcação */
		$this->load->model('MarcacaoModel');
		$this->MarcacaoModel->buscaTodasMarcacao();
		$dados['marcacao'] = $this->MarcacaoModel->dados;
		/* Carregando os Pacientes */ 
		$this->load->model('PacienteModel');
		$this->PacienteModel->buscaTodosPaciente();
		$dados['paciente'] = $this->PacienteModel->dados;

		$dados['pacientesAdicionados'] = '';

		$this->load->view('template/header',$dados);
		$this->load->view('FracionamentoCadastroView');
		$this->load->view('template/footer');
	}

	public function adicionar(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());

		$this->load->model('FracionamentoModel');

		if($post['CODFRACIONAMENTO']){
			$codigo = $post['CODFRACIONAMENTO'];
		}else{
			$post['CODINST'] = $_SESSION['CODINST'];
			$codigo = $this->FracionamentoModel->inserir($post);
		}
		if( $codigo ){
			$post['CODFRACIONAMENTO'] = $codigo;
			$coditem = $this->FracionamentoModel->inserirItemFracionamento($post);
			if( $coditem ){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Adicionado com Sucesso','codfracionamento' => $codigo ) ,  true );	
			}else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao adicionar 1','codfracionamento' => '1' ) ,  true );	
			}	
		}	
		else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao Adicioar 2','codfracionamento' => '2' ) ,  true );
		}
		echo jsonEncodeArray( $this->json );  		
	}
	
	public function editar( $cod = null)
	{
		$dados['js'] = 'js/Fracionamento.js';
		/*  Carregando as marcação */
		$this->load->model('MarcacaoModel');
		$this->MarcacaoModel->buscaTodasMarcacao();
		$dados['marcacao'] = $this->MarcacaoModel->dados;
		/* Carregando os Pacientes */ 
		$this->load->model('PacienteModel');
		$this->PacienteModel->buscaTodosPaciente();
		$dados['paciente'] = $this->PacienteModel->dados;
		
		$codfracionamento = $cod > 0 ? $cod : $this->uri->segment(3);
		/* carregando o fracionamento */
 		$this->load->model('FracionamentoModel');
 		$this->FracionamentoModel->buscaFracionamento( $codfracionamento );
 		$dados['retorno'] = $this->FracionamentoModel->dados;
 		/* carregando os Pacientes Fracionados */
 		$this->FracionamentoModel->buscaItensFracionamento( $codfracionamento );
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

	public function administrarIndex($cod = null) 
	{
		$dados['js'] = 'js/Fracionamento.js';
		$codfracionamento = $cod > 0 ? $cod : $this->uri->segment(3);
		/* carregando o fracionamento */
 		$this->load->model('FracionamentoModel');
 		$this->FracionamentoModel->buscaItemFracionamento( $codfracionamento );
 		$dados['retorno'] = $this->FracionamentoModel->dados;

		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('FracionamentoAdministrarCadastroView');
		$this->load->view('template/footer');
	}

	public function administrar() 
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->library('form_validation');
		$this->form_validation->set_rules('FFATIVIDADE','Atividade','required');
		$this->form_validation->set_rules('FFHORAINICIO','Hora Inicio','required');
		$this->form_validation->set_rules('FFATVADMINISTRADA','Atividade Administrada','required|decimal');
		$this->form_validation->set_rules('FFHORAADMINISTRADA','Hora Administrada','required');
		$this->load->model('FracionamentoModel');
		$codigo = null;  
		if($this->form_validation->run() == FALSE){
			$this->administrarIndex($post['FFCODITFRACIONAMENTO']);
		}else{			
			if($post){
				$this->FracionamentoModel->administrar($post);
				$codigo = $post['FFCODITFRACIONAMENTO'];			
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao Administrar. <br/>[' . $this->FracionamentoModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Administrado com sucesso' ));
			}
			$this->administrarIndex( $post['FFCODITFRACIONAMENTO'] );
		}	
	}
}