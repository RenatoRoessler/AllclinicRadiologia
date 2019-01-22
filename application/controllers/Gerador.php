<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gerador extends CI_Controller {

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
		$dados['js'] = 'js/Gerador.js';
		$dados['MSG'] = $this->session->MSG; 
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
		// se não existir
		if( !isset($post['FFATIVOFILTRO']) ){
			$post['FFATIVOFILTRO'] = 'S';
		}
		/*Carregando os Geradores*/
 		$this->load->model('GeradorModel');
 		$this->GeradorModel->index( $post , $_SESSION['CODINST'] );
 		$dados['gerador'] = $this->GeradorModel->dados;
		
		$this->load->view('template/header',$dados);
		$this->load->view('GeradorView');
		$this->load->view('template/footer');
	}

	public function novo()
	{
		$dados['js'] = 'js/Gerador.js';
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG; 

 		$this->load->model('FabricanteModel');
 		$this->FabricanteModel->buscaTodosFabricante();
 		$dados['fabricante'] = $this->FabricanteModel->dados;
		$this->load->view('template/header',$dados);
		$this->load->view('GeradorCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar(){
		$post = limpaVariavelArray( $this->input->post());
		//$this->load->library('form_validation');
		//$this->form_validation->set_rules('FFLOTE','Lote','required|min_length[1]|max_length[10]');
		//$this->form_validation->set_rules('FFDATAHORA','Data e Hora','required');
		//$this->form_validation->set_rules('FFATIVIDADECAL','Atividade de Calibração','required');
		//$this->form_validation->set_rules('FFNROELUICAO','Nro. Eluição','required|min_length[1]|max_length[7]');
		//$this->form_validation->set_rules('FFFABRICANTE','Fabricante','required');
		//$this->form_validation->set_rules('FFATIVO','Ativo','required');
		//$this->form_validation->set_rules('FFHORA','Hora','required');
		$post['CODINST'] = $_SESSION['CODINST'];
		$post['APELUSER'] = $_SESSION['APELUSER'];
		$this->load->model('GeradorModel');
		//if($this->form_validation->run() == FALSE){
			//$this->novo();
		//}else{		
			if($post){
				if($post['FFCODGERADOR']){
					$codigo =$this->GeradorModel->atualizar($post);
				}else{
					//criando a data de inativo
					$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATACALIBRACAO']))); 
					$post['DATAINATIVO'] = date('Y-m-d', strtotime("+15 days",strtotime($data)));
					//$post['DATAINATIVO'] =  strtotime("+15 days",strtotime($data));
					$codigo = $this->GeradorModel->inserir($post);
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Gerador. <br/>[' . $this->GeradorModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Gerador salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);
			
		//}			
	}

	public function editar()
	{
		$dados['js'] = 'js/Gerador.js';
		//caregando o fabricante
		$this->load->model('FabricanteModel');
 		$this->FabricanteModel->buscaTodosFabricante();
 		$dados['fabricante'] = $this->FabricanteModel->dados;
 		//caregando o gerador
 		$this->load->model('GeradorModel');
 		$this->GeradorModel->buscaGerador($this->uri->segment(3));
 		$dados['retorno'] = $this->GeradorModel->dados;
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('GeradorCadastroView');
		$this->load->view('template/footer');
	}

	public function excluir()
	{
		$id = $this->uri->segment(3);
		$this->load->model('GeradorModel');
		//validando se o gerador está vinculado
		if($this->GeradorModel->geradorPodeSerExcluido( $id )){
			$this->GeradorModel->excluir( $id );	
			$this->session->set_userdata('MSG', array( 's', 'Excluido com Sucesso' ));			
		}else{
			$this->session->set_userdata('MSG', array( 'e', 'Gerador vinculado em Eluição, Não é permitido a exclusão' ));
		}
		$this->index(); 		
	}
}
