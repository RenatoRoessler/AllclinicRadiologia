<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Fracionamento
 * 
 *	@author Renato Roessler
 **/ 
class FracionamentoModel extends MY_Model {


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
				$FF .= ( $post['Codigo'] ) ? "and f.CODFRACIONAMENTO = $post[Codigo] " : '';
			}
			if(isset($post['Lote'])) {
				$FF .= ( $post['Lote'] ) ? "and m.KIT_LOTE =  $post[Lote] " : '';
			}
			if(isset($post['FFDATAPESQUISA'])) {
				$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAPESQUISA']))); 
				$FF .= ( $post['FFDATAPESQUISA'] ) ? "and m.DATA >= '$data' " : '';
			}
			if(isset($post['FFDATAFINALPESQUISA'])) {
				$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAFINALPESQUISA']))); 
				$FF .= ( $post['FFDATAFINALPESQUISA'] ) ? "and m.DATA <= '$data' " : '';
			}
			$this->dados = $this->query(
				"select 	f.CODFRACIONAMENTO, f.CODMARCACAO, i.CODITFRACIONAMENTO, i.PRONTUARIO,  
							i.ATIVIDADE, p.NOME , p.CPF, m.Data, m.HORA, m.KIT_LOTE,
							DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1
				from 		FRACIONAMENTO f
				left join ITEMFRACIONAMENTO i on (f.CODFRACIONAMENTO = i.CODFRACIONAMENTO)
				left join PACIENTE p on (i.PRONTUARIO = p.PRONTUARIO)
				left join MARCACAO m on (f.CODMARCACAO = m.CODMARCACAO)
				join ELUICAO e on (m.CODELUICAO = e.CODELUICAO)
				join GERADOR g on (e.CODGERADOR = g.CODGERADOR)
				where 		1=1
				and         g.CODINST = $_SESSION[CODINST]
							$FF
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
	 * 	Metodo para inserir um Fracionamento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query("insert into FRACIONAMENTO(
								CODMARCACAO,
								CODINST
								) value 
								($post[CODMARCACAO],
								$post[CODINST]
								)"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('fracionamento', 'codfracionamento');

			$this->db->trans_commit();
			return $id[0]['codfracionamento'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para inserir um Item de Fracionamento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserirItemFracionamento( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query("insert into ITEMFRACIONAMENTO(
								CODFRACIONAMENTO,
								CODAGTOEXA
								) value 
								($post[CODFRACIONAMENTO],
								$post[CODAGTOEXA]
								)"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('itemfracionamento', 'coditfracionamento');

			$this->db->trans_commit();
			return $id[0]['coditfracionamento'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para pegar um fracionamento 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codfracionamento integer 
	 *
	 * 	@return array
	 */
	public function buscaFracionamento( $codfracionamento ) {

		try {			

			$this->dados = $this->query(
				"select 	f.CODFRACIONAMENTO, f.CODMARCACAO
				from 		FRACIONAMENTO f 
				where  f.CODFRACIONAMENTO = 	$codfracionamento
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
	 * 	Metodo para pegar os item de um fracionamento 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codfracionamento integer 
	 *
	 * 	@return array
	 */
	public function buscaItensFracionamento( $codfracionamento ) {

		try {
			$this->dados = $this->query(
				"select 	f.CODFRACIONAMENTO, f.CODMARCACAO, i.CODITFRACIONAMENTO, i.PRONTUARIO,  
							i.ATIVIDADE, p.NOME , p.CPF,pr.DESCRICAO as NOMEPROCEDIMENTO,
							i.ATIVIDADE, i.HORAINICIO, i.ATV_ADMINISTRADA, i.HORA_ADMINISTRADA
				from 		FRACIONAMENTO f
				join ITEMFRACIONAMENTO i on (f.CODFRACIONAMENTO = i.CODFRACIONAMENTO)
				join AGTOEXAME age on (i.CODAGTOEXA = age.CODAGTOEXA)
				join AGENDAMENTO ag on ( ag.CODAGTO = age.CODAGTO)
				left join PACIENTE p on (ag.PRONTUARIO = p.PRONTUARIO)
				join PROCEDIMENTOS pr on (age.CODPROCEDIMENTO = pr.CODPROCEDIMENTO)
				where  f.CODFRACIONAMENTO = 	$codfracionamento
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
	 * 	Metodo para pegar o codfracionamento a partir do coditfracionamento 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $coditfracionamento integer 
	 *
	 * 	@return array
	 */
	public function getCodfracionamento( $coditfracionamento ) {

		try {
			$this->dados = $this->query(
				"select 	f.CODFRACIONAMENTO
				from 		ITEMFRACIONAMENTO f
				where  f.CODITFRACIONAMENTO = 	$coditfracionamento
				"
			);			
			$this->dados = $this->dados->result_array();			
			return $this->dados[0]['CODFRACIONAMENTO'];
	
		} catch (Exception $e) {
			/*	Criando Log*/
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para excluir um item do fracionamento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $coditfracionamento integer - integer com do item do fracionamento
	 *
	 * 	@return array
	 */
	public function excluirItem( $coditfracionamento ) {

		try {
			$this->db->trans_begin();
			$this->db->query(
				"delete from itemfracionamento where coditfracionamento = $coditfracionamento "
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
	 * 	Metodo para excluir um fracionamento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codfracionamento integer - integer  fracionamento
	 *
	 * 	@return array
	 */
	public function excluir( $codfracionamento ) {

		try {
			$this->db->trans_begin();
			$this->db->query(
				"delete from itemfracionamento where codfracionamento = $codfracionamento;
				 "
			);

			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}
	 		$this->db->trans_commit();
	 		$this->db->trans_begin();
			$this->db->query(
				" delete from fracionamento where codfracionamento = $codfracionamento; "
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
	 * 	Metodo para pegar um ITEMfracionamento 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $coditemfracionamento integer 
	 *
	 * 	@return array
	 */
	public function buscaItemFracionamento( $coditfracionamento ) {

		try {	
			$this->dados = $this->query(
				"select 	f.CODFRACIONAMENTO, f.HORAINICIO,f.ATIVIDADE,
							f.ATV_ADMINISTRADA,f.HORA_ADMINISTRADA,
							f.CODITFRACIONAMENTO
				from 		ITEMFRACIONAMENTO f
				where       f.CODITFRACIONAMENTO = 	$coditfracionamento
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
	 * 	Metodo para administar
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function administrar( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query("update  ITEMFRACIONAMENTO set 
								ATIVIDADE = $post[FFATIVIDADE],
								HORAINICIO = '$post[FFHORAINICIO]',
								ATV_ADMINISTRADA = $post[FFATVADMINISTRADA],
								HORA_ADMINISTRADA = '$post[FFHORAADMINISTRADA]'
								where CODITFRACIONAMENTO =  $post[FFCODITFRACIONAMENTO]"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('itemfracionamento', 'coditfracionamento');

			$this->db->trans_commit();
			return $id[0]['coditfracionamento'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}


	

}
