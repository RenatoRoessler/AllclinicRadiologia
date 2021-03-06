<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImportarAgenda extends MY_Controller {


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
		$dados['js'] = 'js/ImportarAgenda.js';
		/*Carregando os Fabricantes*/
 		$this->load->model('FarmacoModel');
 		$this->FarmacoModel->index( $post );
		$dados['farmaco'] = $this->FarmacoModel->dados;
		$dados['MSG'] = $this->session->MSG;
		
		$this->load->view('template/header',$dados);
		$this->load->view('ImportarAgendaView');
		$this->load->view('template/footer');
	}

	public function Importar() {
		$this->load->model('AgendamentoModel');
		$count = 0;

		$caminho =  'C:\allclinic\agenda\\' .$_FILES['file']['name'] ;

		try {

			if (isset($_FILES)) {
		
				$fileName = $_FILES["file"]["tmp_name"];
				
				if ($_FILES["file"]["size"] > 0) {
					
					$file = fopen($fileName, "r");
					$dados = array();
					
					while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
						
						$dados[0]['FFDATAHORA'] = date("Y-m-d",strtotime(str_replace('/','-',$column[10])));
						$dados[0]['FFHORA'] = $column[11];
						$dados[0]['FFNOMEPAC'] = $column[2];
						$dados[0]['FFSOBRENOMEPAC'] = ' ';
						$dados[0]['FFCPF'] = $column[4];
						$dados[0]['FFDATANASCIMENTO'] =$column[3];
						$dados[0]['CODINST'] = $_SESSION['CODINST'];
						$dados[0]['FFPESO'] = $column[8];
						$dados[0]['FFALTURA'] = $column[9];
						$dados[0]['FFCONVENIO'] = $column[14];
						$dados[0]['FFATIVIDADE'] = '';
						$dados[0]['FFCODPAC'] = '';
						$dados[0]['FFPROCEDIMENTO'] = $column[13];					
						$dados[0]['FFRADIOISOTOPO'] = '';
						$dados[0]['FFREPETICAO'] = 'N';
						$dados[0]['FFPERMANENCIA'] = 0;
						$dados[0]['FFCODPAC'] = $column[0];
						//para não inserir Cabeçalho
						if($count >  0){
							$codigo = $this->AgendamentoModel->inserir($dados[0]);
						}
						$count++;	
					}
					unlink($caminho);
					$this->session->set_userdata('MSG', array( 's', 'Importado com Sucesso' ));
							
				}else {
					$this->session->set_userdata('MSG', array( 's', 'Arquivo Inválido' ));
				}
			}else {
				$this->session->set_userdata('MSG', array( 's', 'Arquivo Inválido' ));
			}
		}catch (Exception $e){
			$this->session->set_userdata('MSG', array( 'e', 'Erro ao importar' ));
		}
		redireciona('index');	
	}

	public function importarTodasPasta(){

		try {
	    	$diretorio = dir("C:\allclinic\agenda");
	    	$this->load->model('AgendamentoModel');
			$arquivos = array();

			while($arquivo = $diretorio -> read()){	
				$extensao = pathinfo($arquivo);
				$extensao = $extensao['extension'];
				if( $extensao == 'csv'){
					$caminho =  'C:\allclinic\agenda\\'.$arquivo;
					$file = fopen($caminho, "r");
					$dados = array();
					$count = 0;
					while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
						$dados[0]['FFDATAHORA'] = date("Y-m-d",strtotime(str_replace('/','-',$column[10])));
						$dados[0]['FFHORA'] = $column[11];
						$dados[0]['FFNOMEPAC'] = $column[2];
						$dados[0]['FFSOBRENOMEPAC'] = ' ';
						$dados[0]['FFCPF'] = $column[4];
						$dados[0]['FFDATANASCIMENTO'] =$column[3];
						$dados[0]['CODINST'] = $_SESSION['CODINST'];
						$dados[0]['FFPESO'] = $column[8];
						$dados[0]['FFALTURA'] = $column[9];
						$dados[0]['FFCONVENIO'] = $column[14];
						$dados[0]['FFATIVIDADE'] = '';
						$dados[0]['FFCODPAC'] = '';
						$dados[0]['FFPROCEDIMENTO'] = $column[13];					
						$dados[0]['FFRADIOISOTOPO'] = '';
						$dados[0]['FFREPETICAO'] = 'N';
						$dados[0]['FFPERMANENCIA'] = 0;
						$dados[0]['FFCODPAC'] = $column[0];
						//para não inserir Cabeçalho
						if($count >  0){
							$codigo = $this->AgendamentoModel->inserir($dados[0]);
						}
						$count++;	
					}
					array_push($arquivos, $caminho);
					fclose($file);
				
				}
			}
			$diretorio -> close();
			foreach ( $arquivos as $a){
				unlink($a);
			}
		}catch (Exception $e) {

		}
	}
}
