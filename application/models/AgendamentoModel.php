<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Agendamento
 * 
 *	@author Renato Roessler
 **/ 
class AgendamentoModel extends MY_Model {


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
			$this->dados = $this->query(
				"select 	a.CODAGTO, ae.CODPROCEDIMENTO, e.DESCRICAO, p.NOME ,p.CPF, a.PRONTUARIO, a.HORA, a.DATA, DATE_FORMAT(A.DATA, '%d/%c/%Y') as DATA1
				from 		AGENDAMENTO a
				Join   AGTOEXAME ae on (a.CODAGTO = ae.CODAGTO)
				left join PROCEDIMENTOS e on (ae.CODPROCEDIMENTO = e.CODPROCEDIMENTO)
				join PACIENTE p on (a.PRONTUARIO = p.PRONTUARIO)
				where 		1=1
							$FF
				order by 	a.DATA, a.hora DESC"
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
	 * 	Metodo para inserir um Agendamento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ){
		try{
			//tratando a data
			$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATAHORA'])));  

			$this->db->trans_begin();
			$this->db->query("insert into AGENDAMENTO(
								DATA,
								HORA,
								PRONTUARIO								
								) value 
								('$data',
								'$post[FFHORA]',
								$post[FFPRONTUARIO]								
								)"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('Agendamento', 'CODAGTO');
			$codagto = $id[0]['CODAGTO'];
			/* Inserindo o Exame */
			$this->db->trans_commit();
			$this->db->trans_begin();
			$this->db->query("insert into AGTOEXAME(
								CODPROCEDIMENTO,
								CODAGTO								
								) value 
								($post[FFPROCEDIMENTO],
								$codagto		
								)"
			);
			$this->db->trans_commit();
			return $id[0]['CODAGTO'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para atulizar um Agendamento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizar( $post ){
		try{
			//tratando a data
			$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATAHORA'])));  
			$this->db->trans_begin();
			$this->db->query(" update AGENDAMENTO set 
								DATA ='$data', 
								HORA = '$post[FFHORA]',
								PRONTUARIO = $post[FFPRONTUARIO]								
							where  CODAGTO = $post[FFCODAGTO];
							update AGTOEXAME set 
								CODPROCEDIMENTO = $post[FFPROCEDIMENTO]
							where CODAGTO = $post[FFCODAGTO]
							"
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
	}

	/**
	 * 	Metodo Index 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codagto integer - itneger com o código
	 *
	 * 	@return array
	 */
	public function buscaAgendamento( $codagto ) {

		try {			
			
			$this->dados = $this->query(
				"select 	a.CODAGTO, ae.CODPROCEDIMENTO, e.DESCRICAO, p.NOME ,p.CPF, a.PRONTUARIO, a.HORA, a.DATA,
							DATE_FORMAT(A.DATA, '%d/%c/%Y') as DATA1
				from 		AGENDAMENTO a
				Join   AGTOEXAME ae on (a.CODAGTO = ae.CODAGTO)
				left join PROCEDIMENTOS e on (ae.CODPROCEDIMENTO = e.CODPROCEDIMENTO)
				join PACIENTE p on (a.PRONTUARIO = p.PRONTUARIO)
				where 		a.CODAGTO = $codagto
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
		

}