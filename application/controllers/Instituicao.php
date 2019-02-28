<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instituicao extends CI_Controller {

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
		//dados a serem enviados para o cabecalho
		$dados['js'] = 'js/Instituicao.js';

		/*Carregando as instituições*/
 		$this->load->model('InstituicaoModel');
 		$this->InstituicaoModel->index();
 		$dados['instituicao'] = $this->InstituicaoModel->dados;
		
		$this->load->view('template/header',$dados);
		$this->load->view('InstituicaoView');
		$this->load->view('template/footer');
	}

	public function novo()
	{
		$dados['js'] = 'js/Instituicao.js';
		/*Carregando as instituições*/
 		$this->load->model('InstituicaoModel');
 		$this->InstituicaoModel->index();
 		$dados['retorno'] = null; //$this->InstituicaoModel->dados;
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('InstituicaoCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar()
	{
		/*	Limpando variaveis*/		
		$post = limpaVariavelArray( $this->input->post() );
		$this->load->model('InstituicaoModel');
	
		if( $post ){
		    //Se já tiver codinst faz update			
			if( $post['FFCODINST'] ){				
				$id = $this->InstituicaoModel->atualizar( $post ) ;
			}else{				
				$id = $this->InstituicaoModel->inserir( $post ) ;
				$post['FFCODINST'] = $id;
			}
		}
		if( !$id ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Conta Corrente. <br/>[' . $this->InstituicaoModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Mensagem salva com sucesso' ));
			}
		redireciona('editar/' . $post['FFCODINST']);
				
	}

	public function editar()
	{
		$dados['js'] = 'js/Instituicao.js';
		/*Carregando as instituições*/
 		$this->load->model('InstituicaoModel');
 		$this->InstituicaoModel->buscaInstituicao($this->uri->segment(3));
 		$dados['retorno'] = $this->InstituicaoModel->dados;
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('InstituicaoCadastroView');
		$this->load->view('template/footer');
	}

	public function excluir()
	{
		$this->load->model('InstituicaoModel');
 		$this->InstituicaoModel->excluir($this->uri->segment(3));

 		//dados a serem enviados para o cabecalho
		$dados['js'] = 'js/Instituicao.js';
 		$this->InstituicaoModel->index();
 		$dados['instituicao'] = $this->InstituicaoModel->dados;		
		$this->index();
	}

	
}
