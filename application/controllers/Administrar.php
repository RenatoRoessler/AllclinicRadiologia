<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Administrar extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}

	public function index(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());
		$dados['js'] = 'js/Administrar.js'; 
		$post['CODINST'] = $_SESSION['CODINST'];
		
		//se tiver vazio -- criado por causa do Limpar
		if( !isset($post['FFDATAPESQUISA']) ){
			$post['FFDATAPESQUISA'] = date("d/m/Y");
		}
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
		
        
        /* carregando  */
 		$this->load->model('AdministrarModel');
 		$this->AdministrarModel->index($post);
 		$dados['administrar'] = $this->AdministrarModel->dados;
 		
		$this->load->view('template/header',$dados);
		$this->load->view('AdministrarView');
		$this->load->view('template/footer');
	}

	public function administracao($cod = null){
		$dados['js'] = 'js/Administrar.js';
		$coditfracionamento = $cod > 0 ? $cod : $this->uri->segment(3);
		 
		// carregando os Pacientes Fracionados 
		$this->load->model('AdministrarModel');
 		$this->AdministrarModel->buscaItemFracionamento( $coditfracionamento );
		$dados['itfracionamento'] =  $this->AdministrarModel->dados;		

 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('AdministrarCadastroView');
		$this->load->view('template/footer');
	}

	public function administrar() 
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->library('form_validation');
		$this->form_validation->set_rules('FFATIVIDADE','Atividade','required');
		$this->form_validation->set_rules('FFHORAINICIO','Hora Inicio','required');
		$this->form_validation->set_rules('FFATVADMINISTRADA','Atividade Administrada','required');
		$this->form_validation->set_rules('FFHORAADMINISTRADA','Hora Administrada','required');
		$this->load->model('AdministrarModel');
				
		$codigo = null;  
		if($this->form_validation->run() == FALSE){
			$this->administracao( $post['FFCODITFRACIONAMENTO'] );
		}else{			
			if($post){
				$this->AdministrarModel->administrar($post);
				$codigo = $post['FFCODITFRACIONAMENTO'];			
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao Administrar. <br/>[' . $this->AdministrarModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Administrado com sucesso' ));
			}
			$this->administracao( $post['FFCODITFRACIONAMENTO'] );
		}			
	}

}