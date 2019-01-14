<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Radioisotopo
 * 
 *	@author Renato Roessler
 **/ 
class RadioisotopoModel extends MY_Model {


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
	public function index( $post  ) {

		try {			
			$FF = '';
			if(isset($post['FILTROCODICO'])) {
				$FF .= ( $post['FILTROCODICO'] ) ? "and p.CODRADIOISOTOPO = $post[FILTROCODICO] " : '';
			}
			if(isset($post['FILTRODESCRICAO'])) {
				$FF .= ( $post['FILTRODESCRICAO'] ) ? "and p.DESCRICAO like '%$post[FILTRODESCRICAO]%' " : '';
			}
			$this->dados = $this->query(
                "select 	p.CODRADIOISOTOPO, p.DESCRICAO, p.GAMAO, p.MEIAVIDA
				
				from 		radioisotopo p
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
	 * 	Metodo para inserir um Radioisotopo
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ){
		try{			

			$this->db->trans_begin();
			$this->db->query("insert into RADIOISOTOPO(
								DESCRICAO,
								CODINST,
								GAMAO,
								MEIAVIDA
								) value 
								(upper('$post[FFDESCRICAO]'),
								$post[CODINST],
								$post[FFGAMAO],
								$post[FFMEIAVIDA]
								)"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('radioisotopo', 'codradioisotopo');		

			$this->db->trans_commit();
			return $id[0]['codradioisotopo'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para buscar um Radioisotopo  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function buscaRadioisotopo( $codradioisotopo ) {

		try {			
			$this->dados = $this->query(
				"select 	p.CODRADIOISOTOPO, p.DESCRICAO, p.GAMAO, p.MEIAVIDA
				from 		RADIOISOTOPO p				
				where 		p.CODRADIOISOTOPO = $codradioisotopo
				"
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
	 * 	Metodo para atulizar um Radioisotopo
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizar( $post ){
		try{

			$this->db->trans_begin();
			$this->db->query(" update RADIOISOTOPO set 
								DESCRICAO = upper('$post[FFDESCRICAO]'),
								GAMAO = $post[FFGAMAO],
								MEIAVIDA =$post[FFMEIAVIDA]
											
							where  CODRADIOISOTOPO = $post[FFCODRADIOISOTOPO]"
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
	 *  verifica se o Radioisotopo está vinculado num agendamento 
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 * 	@return bollean //returna true se tiver vinculado
	 */
	public function RadioisotopoVinculadoAgendamento( $codradioisotopo ){
		try{
			$this->dados = $this->query(
				" select count(*) as QTD from AGTOEXAME where CODRADIOISOTOPO = $codradioisotopo"
			);
			$this->dados = $this->dados->result_array();			
			if($this->dados[0]['QTD'] > 0){
				return false;
			}else{
				return true;
			}
			
		}catch(Excepetion $e){
			/* Criando Log */
			log_message('error', $this->db->error());
		}
		return false;

	}

	/**
	 * 	Metodo para excluir um Radioisotopo
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codradioisotopo integer - integer com do Radioisotopo
	 *
	 * 	@return array
	 */
	public function excluir( $codradioisotopo ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from RADIOISOTOPO where codradioisotopo = $codradioisotopo "
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
	 * 	Metodo para buscar todos os  Radioisotopos  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *
	 * 	@return array
	 */
	public function buscaTodosRadioisotopos( ) {

		try {			
			$FF = '';			
			$this->dados = $this->query(
				"select 	r.CODRADIOISOTOPO,r.DESCRICAO		
				from 		RADIOISOTOPO r	
				where       r.CODINST = $_SESSION[CODINST]			
				order by 	r.DESCRICAO"
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