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
				$FF .= ( $post['Codigo'] ) ? "and m.CODMARCACAO = $post[Codigo] " : '';
			}
			if(isset($post['Lote'])) {
				$FF .= ( $post['Lote'] ) ? "and m.LOTE =  '$post[Lote]' " : '';
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
				"select 	m.CODMARCACAO, m.CODELUICAO, m.DATA, m.HORA, m.KIT_CODFABRICANTE, m.KIT_LOTE,
							m.CQ, m.ORGANICO, m.QUIMICO, m.APELUSER,
							DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1,
							u.NOME, f.DESCRICAO AS DESCKITFABRICANTE,fa.DESCRICAO AS DESCKITFARMACO,
							m.PH, m.CODFARMACO, m.LOTE
				from 		marcacao m
				left join usuario u on (m.apeluser = u.apeluser)
				left join fabricante f on (m.KIT_CODFABRICANTE = f.CODFABRICANTE)
				left join farmaco fa on (m.CODFARMACO = fa.CODFARMACO)
				join      eluicao e on (m.CODELUICAO = e.CODELUICAO)
				join      gerador g on (e.CODGERADOR = g.CODGERADOR)
				where 	  g.CODINST = $_SESSION[CODINST]
							$FF
				order by 	m.CODMARCACAO desc
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
			$this->db->query("insert into ITFRACIONAMENTO(
								CODMARCACAO,
								CODAGTOEXA,
								ATIVIDADE_INICIAL,
								HORA_INICIAL,
								VOLUME
								) value 
								($post[CODMARCACAO],
								$post[CODAGTOEXA],
								$post[ATIVIDADE],
								'$post[HORAINICIO]',
								$post[VOLUME]
								)"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('itfracionamento', 'coditfracionamento');

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
	 *	@param $codmarcacao integer 
	 *
	 * 	@return array
	 */
	public function buscaItensFracionamento( $codmarcacao ) {

		try {
			$this->dados = $this->query(
				"select 	i.CODMARCACAO, i.CODITFRACIONAMENTO,   
							ag.NOME , ag.CPF,pr.DESCRICAO as NOMEPROCEDIMENTO,
							i.ATIVIDADE_INICIAL, i.HORA_INICIAL, i.ATIVIDADE_ADMINISTRADA, i.HORA_ADMINISTRADA,
							i.VOLUME
				from 		ITFRACIONAMENTO i 
				join AGTOEXAME age on (i.CODAGTOEXA = age.CODAGTOEXA)
				join AGENDAMENTO ag on ( ag.CODAGTO = age.CODAGTO)
				join PROCEDIMENTOS pr on (age.CODPROCEDIMENTO = pr.CODPROCEDIMENTO)
				where  i.CODMARCACAO = 	$codmarcacao
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
				"select 	f.CODMARCACAO
				from 		ITFRACIONAMENTO f
				where  f.CODITFRACIONAMENTO = 	$coditfracionamento
				"
			);			
			$this->dados = $this->dados->result_array();			
			return $this->dados[0]['CODMARCACAO'];
	
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
				"delete from itfracionamento where coditfracionamento = $coditfracionamento "
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
