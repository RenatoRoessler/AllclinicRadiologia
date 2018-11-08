<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procedimentos extends CI_Controller {

		/**	Recebe nome do arquivo javascript default para ser carregado pelos views usados pelo controller
	 * 	@name $js
	 *	@access public
	 */
	public $js = array(
		'js/teste.js'
	);

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
		$dados['js'] = 'js/Procedimentos.js';
		/*Carregando as instituições*/
 		$this->load->model('ProcedimentosModel');
 		$this->ProcedimentosModel->index( $post  );
 		$dados['procedimentos'] = $this->ProcedimentosModel->dados;		
		$this->load->view('template/header',$dados);
		$this->load->view('ProcedimentosView');
		$this->load->view('template/footer');
	}

	public function novo()
	{
		$dados['js'] = 'js/Procedimentos.js';
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG; 
		$this->load->view('template/header',$dados);
		$this->load->view('ProcedimentosCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar(){
		$post = limpaVariavelArray( $this->input->post());
		//echo var_dump($post);				
		$this->load->library('form_validation');
		$this->form_validation->set_rules('FFDESCRICAO','Desrição','required|min_length[10]|max_length[69]');
		$this->form_validation->set_rules('FFATIVO','Ativo','required');
		$this->load->model('ProcedimentosModel');
		if($this->form_validation->run() == FALSE){
			$this->novo();
		}else{			
			if($post){
				if($post['FFCODIGO']){
					$codigo =$this->ProcedimentosModel->atualizar($post);
				}else{
					$codigo = $this->ProcedimentosModel->inserir($post);
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar o Procedimento. <br/>[' . $this->ProcedimentosModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Proceimento salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);
		}		
	}

	public function editar()
	{
		$dados['js'] = 'js/Procedimentos.js';
 		//caregando o procedimento
 		$this->load->model('ProcedimentosModel');
 		$this->ProcedimentosModel->buscaProcedimento($this->uri->segment(3));
 		$dados['retorno'] = $this->ProcedimentosModel->dados;
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('ProcedimentosCadastroView');
		$this->load->view('template/footer');
	}


}
