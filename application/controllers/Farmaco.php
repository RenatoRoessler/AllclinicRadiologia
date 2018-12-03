<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Farmaco extends MY_Controller {


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
		$dados['js'] = 'js/Farmaco.js';
		/*Carregando os Fabricantes*/
 		$this->load->model('FarmacoModel');
 		$this->FarmacoModel->index( $post );
		$dados['farmaco'] = $this->FarmacoModel->dados;
		
		$this->load->view('template/header',$dados);
		$this->load->view('FarmacoView');
		$this->load->view('template/footer');
	}
	public function novo()
	{
		$dados['js'] = 'js/Farmaco.js';
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG; 

 		$this->load->model('FarmacoModel');
 		$this->FarmacoModel->buscaFarmacosAtivos();
		$dados['farmaco'] = $this->FarmacoModel->dados;
		$this->load->view('template/header',$dados);
		$this->load->view('FarmacoCadastroView');
		$this->load->view('template/footer');
	}
	
	public function atualizar(){
		$post = limpaVariavelArray( $this->input->post());
		$this->load->library('form_validation');
		$this->form_validation->set_rules('FFDESCRICAO','Descricao','required|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('FFSOLVINORGANICO','Solvente Inorgânico','required');
		$this->form_validation->set_rules('FFSOLVORGANICO','Solvente Orgânico','required');
		$this->form_validation->set_rules('FFPH','PH','required');
		$this->form_validation->set_rules('FFATIVO','Ativo','required');
		$post['CODINST'] = $_SESSION['CODINST'];
		$this->load->model('FarmacoModel');
		if($this->form_validation->run() == FALSE){
			$this->novo();
		}else{			
			if($post){
				if($post['FFCODFARMACO']){
					$codigo =$this->FarmacoModel->atualizar($post);
				}else{
					//criando a data de inativo
					$codigo = $this->FarmacoModel->inserir($post);
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Farmaco. <br/>[' . $this->FarmacoModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Farmaco salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);
		}	
	}	

	public function editar()
	{
		$dados['js'] = 'js/Farmaco.js';
 		//caregando o Farmaco
 		$this->load->model('FarmacoModel');
		$this->FarmacoModel->buscaFarmaco($this->uri->segment(3));
 		$dados['retorno'] = $this->FarmacoModel->dados;
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('FarmacoCadastroView');
		$this->load->view('template/footer');
	}	

	public function excluir()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('FarmacoModel');
		if($this->FarmacoModel->FarmacoPodeSerExcluido( $post['Codigo'] )){
			if($this->FarmacoModel->excluirFarmaco( $post['Codigo'] )){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Excluido com Sucesso' ) ,  true );	
			}else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao excluir. <br/>[' . $this->FarmacoModel->db->error() . ']' ) ,  true );	
			}				
		}else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Farmaco Vinculado' ) ,  true );	
		}		
		echo jsonEncodeArray( $this->json ); 
	}

	
}
