<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo de procedimentos
 * 
 *	@author Renato Roessler
 **/ 
class ProcedimentosModel extends MY_Model {


	public function __construct() {
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
	public function index( $post ) {

		try {			
			$FF = '';
			if(isset($post['FFCodigo'])) {
				$FF .= ( $post['FFCodigo'] ) ? "and p.CODPROCEDIMENTO = $post[FFCodigo] " : '';
			}
			if(isset($post['Descricao'])) {
				$FF .= ( $post['Descricao'] ) ? "and p.DESCRICAO like  '%$post[Descricao]%' " : '';
			}
			$this->dados = $this->query(
				"select 	p.CODPROCEDIMENTO, p.DESCRICAO, 
							case when p.ATIVO = 'S'  then 'Ativo'
								 when p.ATIVO = 'N' then 'Inativo' end DESCATIVO
				
				from 		procedimentos p
				where 		p.CODINST = $_SESSION[CODINST]
							$FF
				order by 	p.DESCRICAO"
			);			
			$this->dados = $this->dados->result_array();			
			return true;
	
		} catch (Exception $e) {
			/*	Criando Log*/
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para inserir um Procedimento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post) {
		try{
			$this->db->trans_begin();
			$this->db->query(" insert into procedimentos (DESCRICAO, ATIVO, CODINST) value (
							 	upper('$post[FFDESCRICAO]'),'$post[FFATIVO]' , $_SESSION[CODINST]) "
							 );
			if( $this->db->trans_status() === false){
				$this->db->trans_roolback();
			}
			//pegando o id
			$id = $this->retornaMaxColuna('procedimentos','CODPROCEDIMENTO');
			$this->db->trans_commit();
			return $id[0]['CODPROCEDIMENTO'];
		} catch (Exception $e){
			log_message('error', $this->db->error());	
		}
		return false;
	}

	/**
	 * 	Metodo para atulizar um Procedimento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizar( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query(" update procedimentos set 
							   DESCRICAO = upper('$post[FFDESCRICAO]'),
							   ATIVO = '$post[FFATIVO]'
							   where CODPROCEDIMENTO = $post[FFCODIGO];
				");
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollvack();
				return false;
			}
			$this->db->trans_commit();
			return $post[FFCODIGO];
		} catch(Exception $e){
			log_message('error', $this->db->error());	
		}
		return false;
	}

	/**
	 * 	Metodo para buscar um procedimento  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function buscaProcedimento( $codprocedimento ) {

		try {			
			$FF = '';
			//$FF .= ( $post['FFCodigo'] ) ? "and B.codbco = $post[FFCodigo] " : '';
			//$FF .= ( $post['FFNome'] ) ? "and B.Nome like upper('%$post[FFNome]%') " : '';
			$this->dados = $this->query(
				"select 	p.CODPROCEDIMENTO,p.DESCRICAO, p.ATIVO			
				from 		procedimentos p				
				where 		p.CODPROCEDIMENTO = $codprocedimento
				order by 	p.DESCRICAO"
			);			
			$this->dados = $this->dados->result_array();			
			return true;
	
		} catch (Exception $e) {
			/*	Criando Log*/
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para buscar todos os  procedimentos  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *
	 * 	@return array
	 */
	public function buscaTodosProcedimento( $post = null) {

		try {			
			$FF = '';
			//$FF .= ( $post['FFCodigo'] ) ? "and B.codbco = $post[FFCodigo] " : '';
			if(isset($post['descricao'])) {
				$FF .= ( $post['descricao'] ) ? "and p.DESCRICAO like upper('%$post[descricao]%') " : '';
			}
			
			$this->dados = $this->query(
				"select 	p.CODPROCEDIMENTO,p.DESCRICAO, p.ATIVO			
				from 		procedimentos p	
				where       p.ATIVO = 'S'
				and         p.CODINST = $_SESSION[CODINST]
				 $FF			
				order by 	p.DESCRICAO"
			);			
			$this->dados = $this->dados->result_array();			
			return true;
	
		} catch (Exception $e) {
			/*	Criando Log*/
			log_message('error', $this->db->error());
		}
		return false;
	}

}
