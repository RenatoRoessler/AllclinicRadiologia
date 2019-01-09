<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Gerador
 * 
 *	@author Renato Roessler
 **/ 
class FabricanteModel extends MY_Model {


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
			if(isset($post['Codigo'])) {
				$FF .= ( $post['Codigo'] ) ? "and f.CODFABRICANTE = $post[Codigo] " : '';
			}
			if(isset($post['Descricao'])) {
				$post['Descricao'] = strtoupper($post['Descricao']);
				$FF .= ( $post['Descricao'] ) ? "and f.DESCRICAO like '%$post[Descricao]%' " : '';
			}
			
			$this->dados = $this->query(
				"select 	f.CODFABRICANTE, f.DESCRICAO,f.ESPECIFICACAO, f.TIPO,
				case when f.tipo = '1' then 'Gerador'
				     when f.tipo = '2' then 'Radiofarmaco' end TIPODESC		
				from 		fabricante f
				where 		f.CODINST = $_SESSION[CODINST]
							$FF
				order by 	f.DESCRICAO"
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
	 * 	Metodo para inserir um Fabricante
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query("insert into fabricante(DESCRICAO,ESPECIFICACAO,TIPO,CODINST) value ( '$post[FFDESCRICAO]','$post[FFESPECIFICACAO]','2',$_SESSION[CODINST])"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();
			}
			//pegando o id
			$id = $this->retornaMaxColuna('fabricante', 'codfabricante');

			$this->db->trans_commit();
			return $id[0]['codfabricante'];


		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para atulizar um Fabricante
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizar( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query(" update fabricante set 
				DESCRICAO = '$post[FFDESCRICAO]',
				ESPECIFICACAO = '$post[FFESPECIFICACAO]',
				TIPO = '2'
				where  CODFABRICANTE = $post[FFCODFABRICANTE]"
			);
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}

			$this->db->trans_commit();
			return true;

		}catch (Exception $e){
			log_message('error', $this->db->error());
		}
		return false;
	} 

	/**
	 * 	Metodo para buscar um Fornecedor  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codfabricante integer - integer com o codfabricante
	 *  1 = Gerador //  2 = Radiofarmaco
	 * 	@return array
	 */
	public function buscaFabricante( $codfabricante ) {

		try {
			
			$FF = '';
			
			$this->dados = $this->query(
				"select 	f.CODFABRICANTE, f.DESCRICAO,f.ESPECIFICACAO, f.TIPO				
				from 		fabricante f
				where 		f.codfabricante = $codfabricante
							$FF
				order by 	f.DESCRICAO"
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
	 * 	Metodo para excluir um Fabricante
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codfabricante integer - integer com o codfabricante
	 *
	 * 	@return array
	 */
	public function excluir( $codfabricante ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from fabricante where codfabricante = $codfabricante "
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

	/**
	 * 	Metodo para buscar  Fabricante pelo Tipo  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codfabricante integer - integer com o codfabricante
	 *  
	 * 	@return array
	 */
	public function buscaFabricantePeloTipo( $tipo ) {

		try {
			
			$FF = '';

			$this->dados = $this->query(
				"select 	f.CODFABRICANTE, f.DESCRICAO,f.ESPECIFICACAO, f.TIPO				
				from 		fabricante f
				where 		f.TIPO = $tipo
				and 		f.CODINST = $_SESSION[CODINST]
							$FF
				order by 	f.DESCRICAO"
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
	 * 	Metodo para buscar  Fabricante pelo Tipo  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codfabricante integer - integer com o codfabricante
	 *
	 * 	@return array
	 */
	public function buscaTodosFabricante( ) {

		try {			
			$this->dados = $this->query(
				"select 	f.CODFABRICANTE, f.DESCRICAO,f.ESPECIFICACAO, f.TIPO				
				from 		fabricante f
				where 		f.CODINST = $_SESSION[CODINST]
				order by 	f.DESCRICAO"
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
	 *  verifica se o fabricante pode ser Excluido
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 * 	@return bollean
	 */
	public function fabricantePodeSerExcluido( $codfabricante ){
		try {
			$this->dados =  $this->query(
				" select count(*) as QTD from GERADOR where CODFABRICANTE = $codfabricante "
			);
			$this->dados = $this->dados->result_array();
			//se a quantidade for maior que zero não pode excluir
			if ($this->dados[0]['QTD'] > 0 ){
				return false;
			}else{
				return true;
			}	 
		} catch (Exception $e) {
			/*	Criando Log*/
			log_message('error', $this->db->error());
		}
		return false;
	}


}