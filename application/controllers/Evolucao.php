<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Evolucao extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}

	public function index(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());
		$dados['js'] = 'js/Evolucao.js'; 
		$post['CODINST'] = $_SESSION['CODINST'];

		if( !isset($post['FFDATAPESQUISA']) ){
			$post['FFDATAPESQUISA'] = date("Y-m-d");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAPESQUISA'] < 1){
			$post['FFDATAPESQUISA'] = date("Y-m-d");	
		}
		if( !isset($post['FFDATAFINALPESQUISA']) ){
			$post['FFDATAFINALPESQUISA'] = date("Y-m-d");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAFINALPESQUISA'] < 1){
			$post['FFDATAFINALPESQUISA'] = date("Y-m-d");
		}

		/*Carregando as Evoluções */
 		$this->load->model('EvolucaoModel');
 		$this->EvolucaoModel->index( $post  );
 		$dados['evolucao'] = $this->EvolucaoModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('EvolucaoView');
		$this->load->view('template/footer');
	}
	

}