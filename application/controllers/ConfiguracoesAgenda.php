<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ConfiguracoesAgenda extends CI_Controller {

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
		$dados['js'] = 'js/ConfiguracoesAgenda.js'; 
		/*carregando os fabricantes */ 
		$this->load->model('ConfiguracoesAgendaModel');
		$this->ConfiguracoesAgendaModel->index( $post );
		$dados['configuracoes'] = $this->ConfiguracoesAgendaModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('ConfiguracoesAgendaView');
		$this->load->view('template/footer');
	}
	public function novo()
	{
		$dados['js'] = 'js/ConfiguracoesAgenda.js';
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('ConfiguracoesAgendaCadastroView');
		$this->load->view('template/footer');
	}
	public function atualizar()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->library('form_validation');
		$this->form_validation->set_rules('FFDESCRICAO','Descrição','required|min_length[10]|max_length[149]');
		$this->form_validation->set_rules('FFINICIO','Hora Inícial','required');
		$this->form_validation->set_rules('FFINTERVALO','Intervalo','required');
		$this->form_validation->set_rules('FFFIM','Hora Final','required');
		$post['SEGUNDA']  = (isset($post['ckSegunda'])) ? 1 : 0;
		$post['TERCA']  = (isset($post['ckTerca'])) ? 1 : 0;
		$post['QUARTA']  = (isset($post['ckQuarta'])) ? 1 : 0;
		$post['QUINTA']  = (isset($post['ckQuinta'])) ? 1 : 0;
		$post['SEXTA']  = (isset($post['ckSexta'])) ? 1 : 0;
		$post['SABADO']  = (isset($post['ckSabado'])) ? 1 : 0;
		$post['DOMINGO']  = (isset($post['ckDomingo'])) ? 1 : 0;
		$post['CODINST'] = $_SESSION['CODINST'];
		$codigo = null;
		$this->load->model('ConfiguracoesAgendaModel');
		if($this->form_validation->run() == FALSE){
			$this->novo();
		}else{			
			if($post){
				if($post['FFCODAGTO']){
					$this->ConfiguracoesAgendaModel->atualizar($post);
					$codigo = $post['FFCODAGTO'];
				}else{
					$codigo = $this->ConfiguracoesAgendaModel->inserir($post);
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Agenda. <br/>[' . $this->ConfiguracoesAgendaModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Agenda salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);
		}	
	}
	public function editar()
	{
		$dados['js'] = 'js/ConfiguracoesAgenda.js';
		/* carregando as instituições */
 		$this->load->model('ConfiguracoesAgendaModel');
 		$this->ConfiguracoesAgendaModel->buscaConfiguracaoAgenda( $this->uri->segment(3) );
 		$dados['retorno'] = $this->ConfiguracoesAgendaModel->dados;
 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('ConfiguracoesAgendaCadastroView');
		$this->load->view('template/footer');
	}

}