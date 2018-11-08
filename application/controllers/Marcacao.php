<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Marcacao extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}

	public function index(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());
		$post['CODINST'] = $_SESSION['CODINST'];
		$dados['js'] = 'js/Marcacao.js'; 
		/*carregando os fabricantes */ 
		$this->load->model('MarcacaoModel');
		$this->MarcacaoModel->index( $post );
		$dados['marcacao'] = $this->MarcacaoModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('MarcacaoView');
		$this->load->view('template/footer');
	}


	public function novo()
	{
		$dados['js'] = 'js/Marcacao.js';
		
 		$dados['retorno'] = null; //$this->InstituicaoModel->dados;
 		$dados['MSG'] = $this->session->MSG;

 		/*carregando as Eluições */ 
		$this->load->model('EluicaoModel');
		$this->EluicaoModel->buscaEluicoesAtivas();
		$dados['eluicao'] = $this->EluicaoModel->dados;

		/*carregando os Fabricantes  */ 
		$this->load->model('FabricanteModel');
		$this->FabricanteModel->buscaFabricantePeloTipo( 1 );
		$dados['fabricantes'] = $this->FabricanteModel->dados;
 		/* Radiofarmacos */
		$this->FabricanteModel->buscaFabricantePeloTipo( 2 );
		$dados['radiofarmacos'] = $this->FabricanteModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('MarcacaoCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('FFELUICAO','Eluição','required');
		$this->form_validation->set_rules('FFDATAHORA','Data','required');	
		$this->form_validation->set_rules('FFHORA','Hora','required');
		$this->form_validation->set_rules('FFNACIFABRICANTE','NaCI Fabricante ','required');
		$this->form_validation->set_rules('FFNACILOTE','NaCI lote','required');	
		$this->form_validation->set_rules('FFKITFABRICANTE','Kit Fabricnte','required');
		$this->form_validation->set_rules('FFKITRADIOFARMACO','Kit Radiofarmaco','required');	
		$this->form_validation->set_rules('FFKITLOTE','Kit lote','required');		
		if($post['FFCQ'] == 'S'){
			$this->form_validation->set_rules('FFORGANICO','Eficiência Organico','required');
			$this->form_validation->set_rules('FFQUIMICO','Eficiência Quimico','required');
		}		
		$codigo = null;
		$post['APELUSER'] = $_SESSION['APELUSER'];
		$this->load->model('MarcacaoModel');
		if($this->form_validation->run() == FALSE){
			$this->novo();
		}else{			
			if($post){
				if( $post['FFCODMARCACAO'] ){
					$this->MarcacaoModel->atualizar($post);
					$codigo = $post['FFCODMARCACAO'];
				}else{
					$codigo = $this->MarcacaoModel->inserir($post);
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Marcação. <br/>[' . $this->MarcacaoModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Marcação salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);
		}					
	}

	public function editar()
	{
		$dados['js'] = 'js/Marcacao.js';
		
		/*carregando as Eluições */ 
		$this->load->model('EluicaoModel');
		$this->EluicaoModel->buscaEluicoesAtivas();
		$dados['eluicao'] = $this->EluicaoModel->dados;
		/*carregando os Fabricantes  */ 
		$this->load->model('FabricanteModel');
		$this->FabricanteModel->buscaFabricantePeloTipo( 1 );
		$dados['fabricantes'] = $this->FabricanteModel->dados;
 		/* Radiofarmacos */
		$this->FabricanteModel->buscaFabricantePeloTipo( 2 );
		$dados['radiofarmacos'] = $this->FabricanteModel->dados;
		/* carregando a marcação */ 
		$this->load->model('MarcacaoModel');
		$this->MarcacaoModel->buscaMarcacao( $this->uri->segment(3) );
 		$dados['retorno'] = $this->MarcacaoModel->dados;

 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('MarcacaoCadastroView');
		$this->load->view('template/footer');
	}

	public function excluir()
	{
		$this->load->model('MarcacaoModel');
		$this->MarcacaoModel->excluir($this->uri->segment(3));
		$this->index();		
	}
}