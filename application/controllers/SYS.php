<?php
/**	
 * 	Controller do sistema geral
 * 
 **/ 
class Sys extends MY_Controller{
	

	
	/**
	 * 	Metodo construct
	 *
	 * 	@return void
	 */
	public function __construct(){
		/* Carregando Main Controller */
		parent::__construct();
	}
	
	
	/**
	 * 	Método para popular automaticamente campos do tipo select. 
	 *
	 * 	@return void
	 */
	public function selectFill(){
		
		/*	Carregando Modelo*/
		$this->load->model( 'SysModel' );
		
		//$post = $_POST;
		$post = limpaVariavelArray( $this->input->post());
		/*	"Descriptografando" dados */
        $post['sft'] = criptLow( $post['sft'], 'D' ); // Tabela
		$post['sfci'] = criptLow( $post['sfci'], 'D' ); // Coluna ID
		$post['sfcl'] = criptLow( $post['sfcl'], 'D' ); // Coluna Label
		$post['sfw'] = criptLow( $post['sfw'], 'D' ); // Query where para dado seleciona 
		$post['sfwa'] = criptLow( $post['sfwa'], 'D' ); // Query where generica
        $post['sft'] = limpaVariavel( $post['sft'] ); // Tabela
		$post['sfci'] = limpaVariavel( $post['sfci'], 'D' ); // Coluna ID
		$post['sfcl'] = limpaVariavel( $post['sfcl'], 'D' ); // Coluna Label
		
		if( !preg_match( "/^where/" , substr( $post['sfw'], 0, 5) ) || !preg_match( "/^where/" , substr( $post['sfwa'], 0, 5) ) ){
			show_error( 'Error on validation of data $_POST', 500, 'Error' );
		}
		$this->SysModel->selectFill( $post );
		echo jsonEncodeArray( utf8DecodeArray( selectFillArray( $this->SysModel->dados ) ) );
	}
}