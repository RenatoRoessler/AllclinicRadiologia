<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Agenda extends CI_Controller {

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
		$dados['js'] = 'js/Agenda.js'; 
		/*  Busacndo as Configurações da agenda  */
		$this->load->model('ConfiguracoesAgendaModel');
		$this->ConfiguracoesAgendaModel->buscaTodasConfiguracaoAgenda( );
		$dados['ConfiguracoesAgendaModel'] = $this->ConfiguracoesAgendaModel->dados;

		if(isset($post['FFAGENDA'])){
			/*carregando os dados da agenda agendas */ 
			$this->load->model('AgendaModel');
			$this->AgendaModel->index( $post );
			$dados['agenda'] = $this->AgendaModel->dados;
			$dados['horarios'] = $this->geraHorariosAgenda($dados['agenda'][0]['INICIO'],$dados['agenda'][0]['FIM'],$dados['agenda'][0]['INTERVALO']);
			//$dados['tempo2'] = $this->gerandoAgenda($dados['agenda'][0]['FIM']);
		}else{
			$dados['agenda']['HORA'] = '';
			$dados['horarios'][0] = null;
		}

		$this->load->view('template/header',$dados);
		$this->load->view('AgendaView');
		$this->load->view('template/footer');
	}

	public function teste(){
		/*	Limpando variaveis	 */
		$post = limpaVariavelArray( $this->input->post() );
		echo var_dump($post);
	}

	public function converterHoraEmMinutos($tempo){
		$array = explode(":", $tempo); 
       	$hor = $array[0]; 
       	$min = $array[1]; 
       	$horas = $hor * 60; //transforma as horas em minutos

       $tempo_em_minutos = $horas + $min; //soma todos os Minutos
       return $tempo_em_minutos;
	}

	public function mintohora($minutos)
	{
		$hora = floor($minutos/60);
		$resto = $minutos%60;
		if($resto < 10){
			return $hora.':0'.$resto;
		}else{
			return $hora.':'.$resto;
		}
	}

	public function geraHorariosAgenda( $horaIncio, $horaFim,$intervalo){
		$inicio = $this->mintohora($this->converterHoraEmMinutos($horaIncio));
		$horaContagem = $this->converterHoraEmMinutos($horaIncio);
		$fim = $this->converterHoraEmMinutos($horaFim);
		$HorarioAgenda = array($inicio);
		while ($fim > $horaContagem){
			$horaContagem += $intervalo;
			array_push($HorarioAgenda, $this->mintohora($horaContagem));	
		}
		array_push($HorarioAgenda, $this->mintohora($fim) );
		return $HorarioAgenda;
	}

}