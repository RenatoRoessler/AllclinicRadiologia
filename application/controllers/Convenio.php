<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Convenio extends MY_Controller {


	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}


	public function index()
	{		
        $post = limpaVariavelArray( $this->input->post());
        $dados['js'] = 'js/Convenio.js'; 
        $post['CODINST'] = $_SESSION['CODINST'];

        /*Carregando as Convênios Ativos*/
 		$this->load->model('ConvenioModel');
 		$this->ConvenioModel->index( $post  );
        $dados['convenio'] = $this->ConvenioModel->dados;
        /* carregando a tela  */ 
        $this->load->view('template/header',$dados);
        $this->load->view('ConvenioView');
        $this->load->view('template/footer');
    }
    
    public function novo(){
        $dados['js'] = 'js/Convenio.js'; 
        $dados['retorno'] = null; 
        $dados['MSG'] = $this->session->MSG;
         
        $this->load->view('template/header',$dados);
        $this->load->view('ConvenioCadastroView');
        $this->load->view('template/footer');
    }

    public function atualizar() {
        $post = limpaVariavelArray( $this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('FFDESCRICAO','Descrição','required|min_length[3]|max_length[99]');
        $codconv = null;
        $post['CODINST'] = $_SESSION['CODINST'];

        if($this->form_validation->run() == false){
            $this->novo();
        }else{
            $this->load->model('ConvenioModel');
            if($post){
                if($post['FFCODCONV']){
                    $this->ConvenioModel->atualizarConvenio( $post );
                    $codconv = $post['FFCODCONV'];
                }else{
                    $codconv  = $this->ConvenioModel->inserirConvenio( $post );
                }
            }
            if( !$codconv ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Convênio. <br/>[' . $this->ConvenioModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Convênio salvo com sucesso' ));
            }
            redireciona('editar/' . $codconv);
        }
    }

    public function editar() {
        $dados['js'] = 'js/Convenio.js';
		/* carregando o modelo do convênio */
        $this->load->model('ConvenioModel');
        $this->ConvenioModel->buscaConvenio( $this->uri->segment(3));
        $dados['retorno'] = $this->ConvenioModel->dados;
         
 		$this->load->view('template/header',$dados);
		$this->load->view('ConvenioCadastroView');
		$this->load->view('template/footer');
    }

    public function excluir(){
        $post = limpaVariavelArray( $this->input->post());
		$this->load->model('ConvenioModel');
		if($this->ConvenioModel->convenioVinculadoNoAgendamento( $post['Codigo'] )){
			if( $this->ConvenioModel->excluir( $post['Codigo'] ) ){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Excluido com Sucesso' ) ,  true );	
			}else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao excluir. <br/>[' . $this->ConvenioModel->db->error() . ']' ) ,  true );	
			}				
		}else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Conv&ecirc;nio sendo Usado' ) ,  true );	
		}		
		echo jsonEncodeArray( $this->json ); 
    }

}
