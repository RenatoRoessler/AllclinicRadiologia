<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Eluicao extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logado')){
			redirect(base_url('usuarios/login'));
		}
	}

	public function index(){
		/*  Limpando variaveis  */
		$post = limpaVariavelArray( $this->input->post());
		$dados['js'] = 'js/Eluicao.js'; 
		$post['CODINST'] = $_SESSION['CODINST'];
		// se não existir
		if( !isset($post['FFDATAPESQUISA']) ){
			$post['FFDATAPESQUISA'] = date("d/m/Y");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAPESQUISA'] < 1){
			$post['FFDATAPESQUISA'] = date("d/m/Y");	
		}
		// se não existir
		if( !isset($post['FFDATAFINAL']) ){
			$post['FFDATAFINAL'] = date("d/m/Y");
		}
		//se tiver vazio -- criado por causa do Limpar
		if($post['FFDATAFINAL'] < 1){
			$post['FFDATAFINAL'] = date("d/m/Y");	
		}
		// se não existir
		if( !isset($post['FFATIVOFILTRO']) ){
			$post['FFATIVOFILTRO'] = 'S';
		}

		/*Carregando os Geradores Ativos*/
 		$this->load->model('GeradorModel');
 		$this->GeradorModel->buscaGeradorAtivos( $post['CODINST']  );
 		$dados['gerador'] = $this->GeradorModel->dados;

		/*Carregando as Eluições*/
 		$this->load->model('EluicaoModel');
 		$this->EluicaoModel->index( $post );
 		$dados['eluicao'] = $this->EluicaoModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('EluicaoView');
		$this->load->view('template/footer');
	}

	public function novo()
	{
		$dados['js'] = 'js/Eluicao.js';
 		$dados['retorno'] = null; 
 		$dados['MSG'] = $this->session->MSG;

 		/*Carregando os Geradores Ativos*/
 		$this->load->model('GeradorModel');
 		$this->GeradorModel->buscaGeradorAtivos( $_SESSION['CODINST']  );
 		$dados['gerador'] = $this->GeradorModel->dados;

		$this->load->view('template/header',$dados);
		$this->load->view('EluicaoCadastroView');
		$this->load->view('template/footer');
	}

	public function atualizar()
	{
		
		$post = limpaVariavelArray( $this->input->post());
		$codigo = null;
		$this->load->model('EluicaoModel');
			
			if($post){
				if( $post['FFCODELUICAO'] ){
					$this->EluicaoModel->atualizar($post);
					$codigo = $post['FFCODELUICAO'];
				}else{
					$codigo = $this->EluicaoModel->inserir($post);
					$this->EluicaoModel->updateNroEluicao( $post );
				}
			}
			if( !$codigo ){
				$this->session->set_userdata('MSG', array( 'e', 'Falha ao salvar Eluição. <br/>[' . $this->EluicaoModel->db->error() . ']' ));
			}else{
				$this->session->set_userdata('MSG', array( 's', 'Eluição salvo com sucesso' ));
			}
			redireciona('editar/' . $codigo);	
				
	}

	public function editar()
	{
		$dados['js'] = 'js/Eluicao.js';
		/* carregando as instituições */
 		$this->load->model('EluicaoModel');
 		/*Carregando os Geradores Ativos*/
 		$this->load->model('GeradorModel');
 		$this->GeradorModel->buscaGeradorAtivos( $_SESSION['CODINST']  );
 		$dados['gerador'] = $this->GeradorModel->dados;
 		/*  Carregando as Eluições */
 		$this->EluicaoModel->buscaEluicao( $this->uri->segment(3) );
 		$dados['retorno'] = $this->EluicaoModel->dados;
 		$dados['MSG'] = $this->session->MSG;
 		$this->load->view('template/header',$dados);
		$this->load->view('EluicaoCadastroView');
		$this->load->view('template/footer');
	}

	public function excluir()
	{
		//$this->load->model('EluicaoModel');
		//$this->EluicaoModel->excluir($this->uri->segment(3));
		//$this->index();	
		
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('EluicaoModel');
		if($this->EluicaoModel->EluicaoPodeSerExcluido( $post['Codigo'] )){
			if($this->EluicaoModel->excluir( $post['Codigo'] )){
				echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'Mensagem' => 'Excluido com Sucesso' ) ,  true );	
			}else{
				echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Erro ao excluir. <br/>[' . $this->EluicaoModel->db->error() . ']' ) ,  true );	
			}				
		}else{
			echo $this->msgSucesso( '', array( 'tipoMsg' => 'e' , 'Mensagem' => 'Eluicao Vinculado na marcação' ) ,  true );	
		}		
		echo jsonEncodeArray( $this->json ); 
	}

	public function gerarLoteEluicao()
	{
		$post = limpaVariavelArray( $this->input->post());
		$this->load->model('GeradorModel');
		//pegando a quantidade de eluições gerados com o gerador
		$lote = $this->GeradorModel->qtdEluicoesGerador( $post['codgerador'] );
		$lote += 1;	
		$this->GeradorModel->buscaGerador( $post['codgerador'] );
		$dados = $this->GeradorModel->dados;
		$atividadeGerador = $dados[0]['ATIVIDADE_CALIBRACAO'];	
		$atividade99mo = $dados[0]['ATIVIDADEMO99'];
		$dataGerador = $dados[0]['DATA_CALIBRACAO'] ;		
		$horaGerador = $dados[0]['HORA'];	
		$atvEluicao =  $this->GeradorModel->atividadeUltimaEluicao( $post['codgerador'] );
		$atividade = 0;
		$hora = $atvEluicao['HORA'] ;
		//$diferencaHoras = 0;
		$primeria = false;
		if($atvEluicao['ATIVIDADEMO99'] > 0){
			$atividade = $atvEluicao['ATIVIDADEMO99'];		
			$dataEluicao = $atvEluicao['DATA'] ; 
			//$diferencaHoras = Eluicao::horasDiferenca( $dataEluicao);
			$primeria = false;
		}else {
			$atividade = $atividadeGerador ;
			$primeria = true;
			$dataEluicao = $dataGerador;
			$hora = $horaGerador;
		}	
		echo $this->msgSucesso( '', array( 'tipoMsg' => 's' , 'lote' => $lote, 'atividade' => $atividade,
		'dataEluicao' => $dataEluicao , 'hora' => $hora , 'primeira' =>  $primeria, 'ativade99mo' => $atividade99mo,'dataGerador' => $dataGerador ,'horaGerador' => $horaGerador) ,  true );	
		echo jsonEncodeArray( $this->json );
	}

	


	public function horasDiferenca($datahora){
		date_default_timezone_set('America/Sao_Paulo');
		$dateAtual = date('Y-m-d H:i');
		$datatime1 = new DateTime($dateAtual);
		$datatime2 = new DateTime($datahora);

		$data1  = $datatime1->format('Y-m-d H:i:s');
		$data2  = $datatime2->format('Y-m-d H:i:s');

		$diff = $datatime1->diff($datatime2);
		$horas = $diff->h + ($diff->days * 24);

		return $horas;
	}

	
	

}
