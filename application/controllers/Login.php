<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();

	}


	public function index()
	{
		
		//dados a serem enviados para o cabecalho
		$dados['titulo'] = 'Página Inicial';
		$dados['subtitulo'] = 'Postagens Recentes';

		//$this->load->view('template/html-header', );
		$this->load->view('template/header',$dados);
		$this->load->view('home');
		$this->load->view('template/footer');
		//$this->load->view('template/html-footer');
	}
	public function testedb()
	{
		$dados['mensagem'] = $this->db->get('INSTITUICAO')->result();
		echo "<pre>";
		print_r($dados);
	}
}
