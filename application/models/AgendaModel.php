<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Agenda
 * 
 *	@author Renato Roessler
 **/ 
class AgendaModel extends MY_Model {


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
			if(isset($post['FFAGENDA'])) {
				$FF .= ( $post['FFAGENDA'] ) ? "and a.CODAGTO = $post[FFAGENDA] " : '';
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

}