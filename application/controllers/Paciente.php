<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paciente extends MY_Controller {


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
		$dados['js'] = 'js/Paciente.js';
		/*Carregando os Fabricantes*/
 		$this->load->model('PacienteModel');
 		$this->PacienteModel->index( $post );
 		$dados['paciente'] = $this->PacienteModel->dados;		
		$this->load->view('template/header',$dados);
		$this->load->view('PacienteView');
		$this->load->view('template/footer');
	}

	public function novo()
	{
		$dados['js'] = 'js/Paciente.js';
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('PacienteCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar(){
		$post = limpaVariavelArray( $this->input->post());
		echo var_dump($post);		
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('FFNOME','Nome','required|min_length[5]|max_length[70]');
		$this->form_validation->set_rules('FFCPF','CPF','required|min_length[11]');
		$this->form_validation->set_rules('FFTELEFONE','Telefone','required|min_length[10]');
		$this->form_validation->set_rules('FFDTNASC','Data','required');
		$this->form_validation->set_rules('FFPESO','Peso','required|min_length[1]');
		$this->form_validation->set_rules('FFALTURA','Altura','required');
		$this->load->model('PacienteModel');
		$post['CODINST'] = $_SESSION['CODINST'];
		if($this->form_validation->run() == FALSE){
			$this->novo();
		}else{			
			if($post){
				if($post['FFPRONTUARIO1']){
					$codigo =$this->PacienteModel->atualizar($post);
				}else{
					$codigo = $this->PacienteModel->inserir($post);
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Paciente. <br/>[' . $this->PacienteModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Paciente salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);
		}	
	}

	public function editar()
	{
		$dados['js'] = 'js/Paciente.js';
 		//caregando o Paciente
 		$this->load->model('PacienteModel');
 		$this->PacienteModel->buscaPaciente($this->uri->segment(3));
 		$dados['retorno'] = $this->PacienteModel->dados;
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('PacienteCadastroView');
		$this->load->view('template/footer');
	}

		public function excluir()
	{
		$this->load->model('PacienteModel');
 		$this->PacienteModel->excluir($this->uri->segment(3));	
		$this->index();
	}


	/**
	 * 	Método para listar os pacientes
	 *
	 *	@author renato roessler
	 * 	@return void
	 */
	public function listarPacientesTela(){
		
		//	Carregando Modelo
		$this->load->model( 'PacienteModel' );
		
		//	Buscando laudos a partir dos filtros usados
		$this->PacienteModel->buscaTodosPaciente( $this->input->post() );
		
		$trs = '';
		foreach ( $this->PacienteModel->dados as $k => $v ){
			$trs .= 
				"<tr data-prontuario='$v[PRONTUARIO]' data-nome='$v[NOME]'><td>$v[PRONTUARIO]</td><td>$v[NOME]</td><td>$v[CPF]</td><td>$v[DATANASCIMENTO]</td></tr>";
		}
		echo $trs;
	}

	/* 
$trs .= 
				"<tr data-idlaudo='$v[CODLAU]' data-codrea='$v[CODREA]' data-codexa='$v[CODEXA]' data-usuario='$v[USUARIO]' data-alterou='$v[ALTEROU]'><td>$v[TITULO]</td><td>$v[REALIZANTE]</td><td>$v[EXAME]</td></tr>";
	*/
	
}
