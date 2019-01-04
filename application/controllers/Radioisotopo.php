<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Radioisotopo extends MY_Controller {


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
		$dados['js'] = 'js/Radioisotopo.js';
		$dados['MSG'] = $this->session->MSG; 
		/*Carregando os Radioisotopo*/
 		$this->load->model('RadioisotopoModel');
 		$this->RadioisotopoModel->index( $post );
 		$dados['radioisotopo'] = $this->RadioisotopoModel->dados;
		
		$this->load->view('template/header',$dados);
		$this->load->view('RadioisotopoView');
		$this->load->view('template/footer');
    }
    
    public function novo()
    {
        $dados['js'] = 'js/Radioisotopo.js';
        $dados['radioisotopo'] = null;
        $dados['MSG'] = $this->session->MSG;

        //carregando a tela
        $this->load->view('template/header', $dados);
        $this->load->view('RadioisotopoCadastroView');
        $this->load->view('template/footer');
    }

    public function atualizar()
    {
		$post = limpaVariavelArray( $this->input->post());
		//biblioteca de validação do codegineter
		$this->load->library('form_validation');
		$this->form_validation->set_rules('FFDESCRICAO', 'Descrição' , 'required|min_length[3]|max_length[99]') ;
		$codigo =  null;
		$this->load->model('RadioisotopoModel');
		if($this->form_validation->run() == FALSE ){
			$this->novo();
		}else{
			if($post){
				$post['CODINST'] = $_SESSION['CODINST'];
				if( $post['FFCODRADIOISOTOPO'] ) {
					$this->RadioisotopoModel->atualizar( $post );
					$codigo = $post['FFCODRADIOISOTOPO'];
				}else{
					$codigo = $this->RadioisotopoModel->inserir( $post );
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Radioisotopo. <br/>[' . $this->RadioisotopoModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Radioisotopo salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);
		}
	}
	
	public function editar(){
		$dados['js'] = 'js/Radioisotopo.js';
		$dados['MSG'] = $this->session->MSG;
		/* Carregando o Radioisotopo */
		$this->load->model('RadioisotopoModel');
		$this->RadioisotopoModel->buscaRadioisotopo( $this->uri->segment(3) );
		$dados['radioisotopo'] = $this->RadioisotopoModel->dados;
		/** abrindo a tela */
		$this->load->view('template/header', $dados);
		$this->load->view('RadioisotopoCadastroView');
		$this->load->view('template/footer');		
	}

	public function excluir()
	{
		
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('RadioisotopoModel');
		if( $this->RadioisotopoModel->RadioisotopoVinculadoAgendamento( $post['Codigo'] ) ){
			if($this->RadioisotopoModel->excluir( $post['Codigo'] )){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Excluido com Sucesso' ) ,  true );	
			}else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao excluir. <br/>[' . $this->RadioisotopoModel->db->error() . ']' ) ,  true );	
			}				
		}else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Radioisotopo Vinculado no Agendamento' ) ,  true );	
		}		
		echo jsonEncodeArray( $this->json ); 
	}
	
}
