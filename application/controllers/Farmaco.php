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

		/** Carregando os Fabricantes */
		$this->load->model('FabricanteModel');
		$this->FabricanteModel->buscaTodosFabricante();
		$dados['fabricante'] = $this->FabricanteModel->dados;
		 
 		$this->load->model('FarmacoModel');
		$this->FarmacoModel->buscaFarmacosAtivos();
		 /*  Carregando os fabricantesFarmacos*/
		$dados['farmacoFabricante'] = null;
		$dados['farmaco'] = $this->FarmacoModel->dados;
		$this->load->view('template/header',$dados);
		$this->load->view('FarmacoCadastroView');
		$this->load->view('template/footer');
	}
	
	public function atualizar(){
		$post = limpaVariavelArray( $this->input->post());
	
		$post['CODINST'] = $_SESSION['CODINST'];
		$this->load->model('FarmacoModel');
					
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

	public function editar()
	{
		$dados['js'] = 'js/Farmaco.js';
 		//caregando o Farmaco
 		$this->load->model('FarmacoModel');		

		/** Carregando os Fabricantes */
		$this->load->model('FabricanteModel');
		$this->FabricanteModel->buscaTodosFabricante();
		$dados['fabricante'] = $this->FabricanteModel->dados;

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
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Farmaco Vinculado - Remova primeiro os Vinculos' ) ,  true );	
		}		
		echo jsonEncodeArray( $this->json ); 
	}

	public function vincular(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());

		$this->load->model('FarmacoModel');	
		
		if($this->FarmacoModel->farmacoFabricanteJaVinculado( $post['CODFABRICANTE'], $post['CODFARMACO'])){
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Fabricante e Farmaco ja vinculados' ) ,  true );	
		}else {
			$codigo = $this->FarmacoModel->inserirFarmacoFabricante($post['CODFABRICANTE'], $post['CODFARMACO']);
			if( $codigo ){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Adicionado com Sucesso' ) ,  true );	
			}	
			else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao Adicioar' ) ,  true );
			}
		}		
		echo jsonEncodeArray( $this->json );		
	}

	public function excluirVinculo()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('FarmacoModel');
		if($this->FarmacoModel->excluirVinculo( $post['CODFABRICANTE'], $post['CODFARMACO'] )){
			echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Excluido com Sucesso' ) ,  true );
		}else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao Adicioar' ) ,  true );
		}
		echo jsonEncodeArray( $this->json ); 	
	}

	public function getLimitesFarmaco(){
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('FarmacoModel');
		$this->FarmacoModel->buscaFarmaco( $post['codfarmaco'] );
		$farmaco = $this->FarmacoModel->dados;
		if($farmaco){
			echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 
												'Mensagem' => 'Excluido com Sucesso',
												'ph_superior' =>  $farmaco[0]['PH'] ,
												'ph_inferior' => $farmaco[0]['PH_INFERIOR'],
												'solv_organico' => $farmaco[0]['SOLV_ORGANICO'],
												'solv_inorganico' => $farmaco[0]['SOLV_INORGANICO']
			) ,  true );
		}else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao buscar Limites' ) ,  true );
		}

		echo jsonEncodeArray( $this->json ); 


	}

	
}
