<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Farmaco extends CI_Controller {


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
		$this->load->view('template/header',$dados);
		$this->load->view('FabricanteCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->library('form_validation');
		$this->form_validation->set_rules('FFDESCRICAO','Descrição','required|min_length[10]|max_length[45]');
		$this->form_validation->set_rules('FFESPECIFICACAO','Especificação','required|min_length[10]|max_length[45]');
		$this->form_validation->set_rules('FFTIPO','TIPO','required');
		$codigo = null;
		$this->load->model('FabricanteModel');
		if($this->form_validation->run() == FALSE){
			$this->novo();
		}else{			
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
	}

	public function editar()
	{
		$dados['js'] = 'js/Fabricante.js';
		/* carregando as instituições */
 		$this->load->model('FabricanteModel');
 		$this->FabricanteModel->buscaFabricante( $this->uri->segment(3) );
 		$dados['retorno'] = $this->FabricanteModel->dados;
 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('FabricanteCadastroView');
		$this->load->view('template/footer');
	}

	public function excluir()
	{
		$this->load->model('FabricanteModel');
		$this->FabricanteModel->excluir($this->uri->segment(3));
		$this->index();		
	}

	
}
