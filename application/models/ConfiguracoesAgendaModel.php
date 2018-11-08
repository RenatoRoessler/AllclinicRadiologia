<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do ConfiguracoesAgendaModel
 * 
 *	@author Renato Roessler
 **/ 
class ConfiguracoesAgendaModel extends MY_Model {


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
				$FF .= ( $post['Codigo'] ) ? "and a.CODAGTO = $post[Codigo] " : '';
			}
			if(isset($post['Descricao'])) {
				$FF .= ( $post['Descricao'] ) ? "and a.DESCRICAO like '%$post[Descricao]%' " : '';
			}
			if(isset($post['CODINST'])) {
				$FF .= ( $post['CODINST'] ) ? "and a.CODINST = $post[CODINST] " : '';
			}
			$this->dados = $this->query(
				"select 	a.CODAGTO, a.DESCRICAO, a.INICIO, a.FIM, a.SEGUNDA, a.TERCA, a.QUARTA, a.QUINTA, a.SEXTA, a.SABADO, a.DOMINGO, a.CODINST,i.RAZAO,a.INTERVALO				
				from 		AGENDA a
				left join   INSTITUICAO i on (a.codinst = i.codinst)
				where 		1=1
							$FF
				order by 	a.DESCRICAO"
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
	 * 	Metodo para inserir uma Agenda
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query("insert into agenda (DESCRICAO, INICIO ,FIM, SEGUNDA, TERCA, QUARTA, QUINTA, 
										SEXTA, SABADO, DOMINGO, CODINST ,INTERVALO) value 
										( '$post[FFDESCRICAO]','$post[FFINICIO]','$post[FFFIM]',$post[SEGUNDA], $post[TERCA], $post[QUARTA], $post[QUINTA], $post[SEXTA], $post[SABADO], $post[DOMINGO], $post[CODINST], $post[FFINTERVALO])"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();
			}
			//pegando o id
			$id = $this->retornaMaxColuna('agenda', 'codagto');

			$this->db->trans_commit();
			return $id[0]['codagto'];

		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para atulizar uma Agenda
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizar( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query(" update agenda set 
				DESCRICAO = '$post[FFDESCRICAO]',
				INICIO = '$post[FFINICIO]',
				FIM = '$post[FFFIM]',
				SEGUNDA = $post[SEGUNDA],
				TERCA = $post[TERCA],
				QUARTA = $post[QUARTA],
				QUINTA = $post[QUINTA],
				SEXTA = $post[SEXTA],
				SABADO = $post[SABADO],
				DOMINGO = $post[DOMINGO],
				INTERVALO =  $post[FFINTERVALO]
				where  CODAGTO = $post[FFCODAGTO]"
			);
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}
			$this->db->trans_commit();
			return $post[FFCODAGTO];
		}catch (Exception $e){
			log_message('error', $this->db->error());
		}
		return false;
	} 

	/**
	 * 	Metodo para buscar um Agenda  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codagto integer = inteiro com o codagto
	 *
	 * 	@return array
	 */
	public function buscaConfiguracaoAgenda( $codagto ) {

		try {			
			$FF = '';
			//$FF .= ( $post['FFCodigo'] ) ? "and B.codbco = $post[FFCodigo] " : '';
			//$FF .= ( $post['FFNome'] ) ? "and B.Nome like upper('%$post[FFNome]%') " : '';
			$this->dados = $this->query(
				"select 	a.CODAGTO, a.DESCRICAO, a.INICIO, a.FIM, a.SEGUNDA, a.TERCA, a.QUARTA, a.QUINTA, a.SEXTA, a.SABADO, a.DOMINGO, a.CODINST, a.INTERVALO		
				from 		Agenda a				
				where 		a.codagto = $codagto
				order by 	a.DESCRICAO"
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
	 * 	Metodo para buscar um Agenda  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *
	 * 	@return array
	 */
	public function buscaTodasConfiguracaoAgenda(  ) {

		try {			
			$FF = '';
			//$FF .= ( $post['FFCodigo'] ) ? "and B.codbco = $post[FFCodigo] " : '';
			//$FF .= ( $post['FFNome'] ) ? "and B.Nome like upper('%$post[FFNome]%') " : '';
			$this->dados = $this->query(
				"select 	a.CODAGTO, a.DESCRICAO, a.INICIO, a.FIM, a.SEGUNDA, a.TERCA, a.QUARTA, a.QUINTA, a.SEXTA, a.SABADO, a.DOMINGO, a.CODINST, a.INTERVALO		
				from 		Agenda a				
				order by 	a.DESCRICAO"
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