<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {

	public function __construct(){
		parent::__construct();

	}

	 /**
	 * 	Metodo Index 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function index( $post = null )
	{
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
		/*	Limpando variaveis	 */
		$post = limpaVariavelArray( $this->input->post() );
		//dados a serem enviados para o cabecalho
		$dados['js'] = 'js/Usuario.js';
		/*Carregando as instituições*/
 		$this->load->model('UsuarioModel');
 		$this->UsuarioModel->index( $post );
 		$dados['usuario'] = $this->UsuarioModel->dados;

		/* carregando as instituições  */ 
		$this->load->model('InstituicaoModel');
 		$this->InstituicaoModel->index();
		$dados['instituicao'] = $this->InstituicaoModel->dados;	
		
		$this->load->view('template/header',$dados);
		$this->load->view('UsuariosView');
		$this->load->view('template/footer');
	}

	public function pag_login(){
		$dados['titulo'] = 'Painel de Controle';
		$dados['subtitulo'] = 'Entrar no sistema';

		$this->load->view('template/html-header', $dados);
		$this->load->view('login');
		$this->load->view('template/html-footer');

	}

	public function logout(){
		//$dadosSessao['userlogado']= NULL;
		$dadosSessao['CODINST'] =  NULL;
		$dadosSessao['NOME'] =  NULL;
		$dadosSessao['APELUSER'] =  NULL;
		$dadosSessao['logado'] = FALSE;
		$dadosSessao['INST_FANTASIA'] = NULL;
		$this->session->set_userdata($dadosSessao);
		redirect(base_url(''));	
	}
	
	public function login() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txt-user','Usuário','required|min_length[3]');
		$this->form_validation->set_rules('txt-senha','Senha','required|min_length[3]');
		if($this->form_validation->run() == FALSE){
			$this->pag_login();
		}else{
			$usuario = $this->input->post('txt-user');
			$senha = $this->input->post('txt-senha');
			$this->db->where('apeluser',$usuario);
			$this->db->where('senha',md5($senha));
			$userLogado = $this->db->get('usuario')->result_array();
			if(count($userLogado)==1){
				//$dadosSessao['userLogado'] = $userLogado[0];				
				$dadosSessao['logado'] =  TRUE;
				$dadosSessao['CODINST'] =  $userLogado[0]['CODINST'];
				$dadosSessao['NOME'] =  $userLogado[0]['NOME'];
				$dadosSessao['APELUSER'] =  $userLogado[0]['APELUSER'];
				$this->db->where('codinst',$userLogado[0]['CODINST']);
				$instituicao =  $this->db->get('instituicao')->result_array();
				$dadosSessao['INST_FANTASIA'] =  $instituicao[0]['FANTASIA'];
				$this->session->set_userdata($dadosSessao);
				redirect(base_url());
			}else{
				//$dadosSessao['userLogado'] = NULL;
				$dadosSessao['logado'] =  FALSE;
				$dadosSessao['CODINST'] =  NULL;
				$dadosSessao['NOME'] =  NULL;
				$dadosSessao['APELUSER'] =  NULL;
				$this->session->set_userdata($dadosSessao);
				redirect(base_url('login'));
			}
		}
	}

	public function todosUsuarios() {
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
		//dados a serem enviados para o cabecalho
		$dados['titulo'] = 'Página Inicial';
		$dados['subtitulo'] = 'Postagens Recentes';
		
		//$this->load->view('template/html-header');
		$this->load->view('template/header', $dados);
		$this->load->view('manutencaoUsuarioIndex');
		$this->load->view('template/footer');
		//$this->load->view('template/html-footer');
		
	}

	public function novo()
	{
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
		$this->load->model('InstituicaoModel');
 		$this->InstituicaoModel->index();
		$dados['instituicao'] = $this->InstituicaoModel->dados;

		$dados['js'] = 'js/Usuario.js';
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('UsuarioCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar()
	{
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
		/*	Limpando variaveis	 */
		$post = limpaVariavelArray( $this->input->post() );
		//echo var_dump($post);
		$this->load->model('UsuarioModel');

		//$this->load->library('form_validation');
		//$this->form_validation->set_rules('FFNOME','Nome','required|min_length[10]');
		//$this->form_validation->set_rules('FFEMAIL','Email','required|valid_email');
		//$this->form_validation->set_rules('FFINSTITUICAO','Instituição','required');
		// só atualiza a senha se for novo usuario ou se for no editar e a senha tiver preenchida
		//if($post['FFAPELUSER1'] && $post['txt-senha'] ) {
			//$this->form_validation->set_rules('txt-senha','Senha',
			//'required|min_length[3]');
			//$this->form_validation->set_rules('txt-confir-senha','Confirmar Senha',
			//'required|matches[txt-senha]');

		//}
		
		//if($this->form_validation->run() == FALSE){
		//	if ($post['FFAPELUSER1']){
		//		$dados['js'] = 'js/Usuario.js';
		//		/* carregando as instituições */
		//		$this->load->model('InstituicaoModel');
		// 		$this->InstituicaoModel->index();
		// 		$dados['instituicao'] =  $this->InstituicaoModel->dados;
		// 		/* carregando o Usuário */
		// 		$this->load->model('UsuarioModel');
		// 		$this->UsuarioModel->buscaUsuario( $post['FFAPELUSER1'] );
		// 		$dados['retorno'] = $this->UsuarioModel->dados;
		// 		$dados['MSG'] = $this->session->MSG;
		// 		$this->load->view('template/header',$dados);
		//		$this->load->view('UsuarioCadastroView');
		//		$this->load->view('template/footer');			
		//	}else{				
		///		$this->novo();		
		//	}
		//}else{
		
			if( $post ){
			    //Se já tiver codinst faz update			
				if( $post['FFAPELUSER1'] ){				
					$apeluser = $this->UsuarioModel->atualizar( $post ) ;
					if($post['FFAPELUSER1'] && $post['txt-senha'] ) {
						$this->UsuarioModel->atualizarSenha( $post ) ;
					}
				}else{				
					$apeluser = $this->UsuarioModel->inserir( $post ) ;
					//$post['FFAPELUSER'] = $id;
				}
			}
			if( !$apeluser ){
					$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Usuario. <br/>[' . $this->UsuarioModel->db->error() . ']' ));
				}else{
					$this->session->set_userdata('MSG', array( 's', 'Usuário salvo com sucesso' ));
				}
			redireciona('editar/' . $post['FFAPELUSER']);
		//}	
	}

	public function editar()
	{
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
		$dados['js'] = 'js/Usuario.js';
		/* carregando as instituições */
		$this->load->model('InstituicaoModel');
 		$this->InstituicaoModel->index();
 		$dados['instituicao'] =  $this->InstituicaoModel->dados;
 		/* carregando o Usuário */
 		$this->load->model('UsuarioModel');
 		$this->UsuarioModel->buscaUsuario( $this->uri->segment(3) );
 		$dados['retorno'] = $this->UsuarioModel->dados;
 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('UsuarioCadastroView');
		$this->load->view('template/footer');
	}

	public function excluir()
	{
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
		$this->load->model('UsuarioModel');
		$this->UsuarioModel->excluir($this->uri->segment(3));
		$this->index();		
	}

	public function usuarioJaCadastrado()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('UsuarioModel');
		$this->UsuarioModel->usuarioJaCadastrado( $post['apeluser'], $post['codinst']);
		//$usuarioCadastrado = $this->UsuarioModel->dados;
		echo $this->msgSucesso('', array( 'usuarioCadastrado' => '$usuarioCadastrado' ), true );	
		echo jsonEncodeArray( $this->json );
	}


}
