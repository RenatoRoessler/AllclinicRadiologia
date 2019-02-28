<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fabricante extends MY_Controller {


	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}

	public function index()
	{		
		/*	Limpando variaveis	 */
		$post = limpaVariavelArray( $this->input->post() );
		//dados a serem enviados para o cabecalho
		$dados['js'] = 'js/Fabricante.js';
		$dados['MSG'] = $this->session->MSG; 
		/*Carregando os Fabricantes*/
 		$this->load->model('FabricanteModel');
 		$this->FabricanteModel->index( $post );
 		$dados['fabricante'] = $this->FabricanteModel->dados;
		
		$this->load->view('template/header',$dados);
		$this->load->view('FabricanteView');
		$this->load->view('template/footer');
	}

	public function novo()
	{
		$dados['js'] = 'js/Fabricante.js';
 		$dados['retorno'] = null; 
		$dados['MSG'] = $this->session->MSG;
		$dados['fabricanteFarmaco']  = 0;
		/*  CARREGANDO OS FARMACOS */
		$this->load->model('FarmacoModel');
		$this->FarmacoModel->buscaTodosFarmacos();
		$dados['farmaco'] = $this->FarmacoModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('FabricanteCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar()
	{
		$post = limpaVariavelArray( $this->input->post());
		$codigo = null;
		$this->load->model('FabricanteModel');
				
		if($post){
			if($post['FFCODFABRICANTE']){
				$this->FabricanteModel->atualizar($post);
				$codigo = $post['FFCODFABRICANTE'];
			}else{
				$codigo = $this->FabricanteModel->inserir($post);
			}
		}
		if( !$codigo ){
			$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Fabricante. <br/>[' . $this->FabricanteModel->db->error() . ']' ));
		}else{
			$this->session->set_userdata('MSG', array( 's', 'Fabricante salvo com sucesso' ));
		}
		redireciona('editar/' . $codigo);
				
	}

	public function editar( $cod = null )
	{
		$dados['js'] = 'js/Fabricante.js';
		$codmarcacao = $cod > 0 ? $cod : $this->uri->segment(3);
		/* carregando as instituições */
 		$this->load->model('FabricanteModel');
		$this->FabricanteModel->buscaFabricante( $codmarcacao );
		$dados['retorno'] = $this->FabricanteModel->dados;

		/*  CARREGANDO OS FARMACOS */
		$this->load->model('FarmacoModel');
		$this->FarmacoModel->buscaTodosFarmacos();
		$dados['farmaco'] = $this->FarmacoModel->dados; 		
 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('FabricanteCadastroView');
		$this->load->view('template/footer');
	}

	public function excluir()
	{
		$id = $this->uri->segment(3);
		$this->load->model('FabricanteModel');
		//$this->FabricanteModel->excluir($id);
		//$this->index();	
		//validando se o gerador está vinculado
		if($this->FabricanteModel->fabricantePodeSerExcluido( $id )){
			$this->FabricanteModel->excluir( $id );	
			$this->session->set_userdata('MSG', array( 's', 'Excluido com Sucesso' ));			
		}else{
			$this->session->set_userdata('MSG', array( 'e', 'Fabricante em uso, Não é permitido a exclusão' ));
		}
		$this->index(); 
	}
	
}
