<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo da Instituição
 * 
 *	@author Renato Roessler
 **/ 
class InstituicaoModel extends MY_Model {


	public function __construct() {
		parent::__construct();
	}
	
    /**
	 * 	Metodo Index 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $url integer - inteiro com o código da conta
	 *
	 * 	@return array
	 */
	public function index( ) {

		try {
			
			$FF = '';
			//$FF .= ( $post['FFCodigo'] ) ? "and B.codbco = $post[FFCodigo] " : '';
			//$FF .= ( $post['FFNome'] ) ? "and B.Nome like upper('%$post[FFNome]%') " : '';
			$this->dados = $this->query(
				"select 	a.CODINST, a.RAZAO,a.FANTASIA, a.CNPJ
				
				from 		instituicao a
				where 		1=1
							$FF
				order by 	a.razao"
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
	 * 	Metodo para atulizar uma instituição
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizar( $post ) {
	
		try {			
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"update 	instituicao
				 set  RAZAO = upper('$post[FFRazao]'),
				 	  FANTASIA = upper('$post[FFFantasia]'),
				 	  CNPJ = '$post[FFCNPJ]'

				where 		codinst = $post[FFCODINST]"
			);
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}

			$this->db->trans_commit();
			return true;
	
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	 /**
	 * 	Metodo para inserir uma instituição
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ) {	
		try {			
			$this->db->trans_begin();			
			$this->db->query(
				"insert into instituicao (razao,fantasia,cnpj) values (upper('$post[FFRazao]'),upper('$post[FFFantasia]'),'$post[FFCNPJ]')"
			);
			/*	Erro*/
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}
			/*	Pegando id*/
			$id = $this->retornaMaxColuna('instituicao', 'codinst');

			$this->db->trans_commit();
			return $id[0]['codinst'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para buscar uma instituição
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codinst integer - inteiro com o código da conta
	 *
	 * 	@return array
	 */
	public function buscaInstituicao( $codinst ) {

		try {
			$this->dados = $this->query(
				"select 	a.CODINST, a.RAZAO,a.FANTASIA, a.CNPJ
				
				from 		instituicao a
				where 		a.codinst = $codinst
				order by 	a.razao"
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
	 * 	Metodo para excluir uma instituição
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codinst integer - inteiro com o código da conta
	 *
	 * 	@return array
	 */
	public function excluir( $codinst ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from instituicao where codinst = $codinst"
			);

			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}
	 		$this->db->trans_commit();
			return true;

		} catch (Exception $e) {
			/*	Criando Log*/
			log_message('error', $this->db->error());
		}
		return false;
	}

}