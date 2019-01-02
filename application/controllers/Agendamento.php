<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Agendamento extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}

	public function index(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());
		$dados['js'] = 'js/Agendamento.js'; 
		$post['CODINST'] = $_SESSION['CODINST'];
		$dados['MSG'] = $this->session->MSG; 
		// se não existir
		if( !isset($post['Data']) ){
			$post['Data'] = date("d/m/Y");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['Data'] < 1){
			$post['Data'] = date("d/m/Y");	
		}
		/*Carregando os Agendamentos */
 		$this->load->model('AgendamentoModel');
 		$this->AgendamentoModel->index( $post );
 		$dados['agendamento'] = $this->AgendamentoModel->dados;
 		/* Carregnado os Pacientes */
 		$this->load->model('PacienteModel');
 		$this->PacienteModel->buscaTodosPaciente();
 		$dados['pacientes'] = $this->PacienteModel->dados;
 		/* Carregnado os Procedimentos */
 		$this->load->model('ProcedimentosModel');
 		$this->ProcedimentosModel->buscaTodosProcedimento();
 		$dados['procedimentos'] = $this->ProcedimentosModel->dados;
 		
		$this->load->view('template/header',$dados);
		$this->load->view('AgendamentoView');
		$this->load->view('template/footer');
	}

	public function novo()
	{
		$dados['js'] = 'js/Agendamento.js';
		
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG;

 		/* Carregnado os Pacientes */
 		$this->load->model('PacienteModel');
 		$this->PacienteModel->buscaTodosPaciente();
 		$dados['paciente'] = $this->PacienteModel->dados;
 			/* Carregnado os Procedimentos */
 		$this->load->model('ProcedimentosModel');
 		$this->ProcedimentosModel->buscaTodosProcedimento();
		$dados['procedimento'] = $this->ProcedimentosModel->dados;
		 
		/* Carregando os Convênios*/
		$this->load->model('ConvenioModel');
		$this->ConvenioModel->buscaTodosConvenios( $_SESSION['CODINST']  );
		$dados['convenio'] = $this->ConvenioModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('AgendamentoCadastroView');
		$this->load->view('template/footer');
	}

		public function atualizar()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('FFHORA','Hora','required');
		$this->form_validation->set_rules('FFDATAHORA','Data','required');	
		$this->form_validation->set_rules('FFPROCEDIMENTO','Procedimento','required');
		$this->form_validation->set_rules('FFNOMEPAC','Nome do Paciente','required|min_length[3]|max_length[99]');	
		$this->form_validation->set_rules('FFSOBRENOMEPAC','Sobrenome do Paciente','required|min_length[3]|max_length[99]');
		$this->form_validation->set_rules('FFCPF','CPF','required');	
		$this->form_validation->set_rules('FFDATANASCIMENTO','Nascimento','required');	
		$this->form_validation->set_rules('FFPESO','Peso','required');
		$this->form_validation->set_rules('FFCONVENIO','Convênio','required');		
	
		$codigo = null;
		$this->load->model('AgendamentoModel');
		if($this->form_validation->run() == FALSE){
			$this->novo();
		}else{			
			if($post){
				if( $post['FFCODAGTO'] ){
					$this->AgendamentoModel->atualizar($post);
					$codigo = $post['FFCODAGTO'];
				}else{
					$codigo = $this->AgendamentoModel->inserir($post);
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Agendamento. <br/>[' . $this->AgendamentoModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Agendamento salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);
		}					
	}

	public function editar()
	{
		$dados['js'] = 'js/Agendamento.js'; 
		/* Carregnado os Pacientes */
 		$this->load->model('PacienteModel');
 		$this->PacienteModel->buscaTodosPaciente();
 		$dados['paciente'] = $this->PacienteModel->dados;
 		/* Carregnado os Procedimentos */
 		$this->load->model('ProcedimentosModel');
 		$this->ProcedimentosModel->buscaTodosProcedimento();
		$dados['procedimento'] = $this->ProcedimentosModel->dados;
		 /* Carregando os Convênios*/
		$this->load->model('ConvenioModel');
		$this->ConvenioModel->buscaTodosConvenios( $_SESSION['CODINST']  );
		$dados['convenio'] = $this->ConvenioModel->dados;
 		/* Carregnado o Atendimento */
 		$this->load->model('AgendamentoModel');
 		$this->AgendamentoModel->buscaAgendamento( $this->uri->segment(3) );
 		$dados['retorno'] = $this->AgendamentoModel->dados;
 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('AgendamentoCadastroView');
		$this->load->view('template/footer');
	}

	/*
	public function excluir()
	{
		$id = $this->uri->segment(3);
		$this->load->model('AgendamentoModel');
		//validando se o agendamento já foi fracionado
		if($this->AgendamentoModel->agendamentoPodeSerExcluido( $id )){
			$this->AgendamentoModel->excluir( $id );	
			$this->session->set_userdata('MSG', array( 's', 'Excluido com Sucesso' ));			
		}else{
			$this->session->set_userdata('MSG', array( 'e', 'Agendamento Fracionado, Não é permitido a exclusão' ));
		}
		$this->index(); 		
	}
	*/
	public function excluir()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('AgendamentoModel');
		if($this->AgendamentoModel->agendamentoPodeSerExcluido( $post['Codigo'] )){
			if($this->AgendamentoModel->excluir( $post['Codigo'] )){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Excluido com Sucesso' ) ,  true );	
			}else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao excluir. <br/>[' . $this->AgendamentoModel->db->error() . ']' ) ,  true );	
			}				
		}else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Agendamento Fracionado, Não é permitido a exclusão' ) ,  true );	
		}		
		echo jsonEncodeArray( $this->json ); 
	}

	/**
	 * 	Método para listar os Agendamentos para filtro
	 *
	 *	@author renato roessler
	 * 	@return void
	 */
	public function listarAgendamentoFiltro(){	
		$post = limpaVariavelArray( $this->input->post());	
		//	Carregando Modelo
		$this->load->model( 'AgendamentoModel' );		
		//	Buscando laudos a partir dos filtros usados
		$this->AgendamentoModel->buscaAgendamentoFiltro( $post );
		
		$trs = '';
		foreach ( $this->AgendamentoModel->dados as $k => $v ){
			$trs .= 
				"<tr data-codagtoexa='$v[CODAGTOEXA]' data-nome='$v[NOME]' data-descricao='$v[DESCRICAO]'><td>$v[CODAGTOEXA]</td><td>$v[DATA1]</td><td>$v[HORA]</td><td>$v[NOME]</td><td>$v[DESCRICAO]</td></tr>";
		}
		echo $trs;
	}
}