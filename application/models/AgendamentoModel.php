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
			if(isset($post['Data'])) {
				$data = date("Y-m-d",strtotime(str_replace('/','-',$post['Data'])));  
				$FF .= ( $post['Data'] ) ? "and a.DATA = '$data'  " : '';
			}
			if(isset($post['FFPROCEDIMENTO'])) {
				$FF .= ( $post['FFPROCEDIMENTO'] ) ? "and ae.CODPROCEDIMENTO =  $post[FFPROCEDIMENTO]  " : '';
			}
			if(isset($post['FILTERNOME'])) {
				$FF .= ( $post['FILTERNOME'] ) ? "and a.NOME like  '%$post[FILTERNOME]%'  " : '';
			}
			if(isset($post['FILTERSOBRENOME'])) {
				$FF .= ( $post['FILTERSOBRENOME'] ) ? "and a.SOBRENOME like  '%$post[FILTERSOBRENOME]%'  " : '';
			}
	
			$this->dados = $this->query(
				"select 	a.CODAGTO, ae.CODPROCEDIMENTO, e.DESCRICAO, a.NOME, a.SOBRENOME ,a.CPF , a.HORA, a.DATA, 
				DATE_FORMAT(A.DATA, '%d/%c/%Y') as DATA1, DATE_FORMAT(a.NASCIMENTO, '%d/%c/%Y') as DNASCIMENTO,
				a.PESO, a.ALTURA
				from 		AGENDAMENTO a
				Join   AGTOEXAME ae on (a.CODAGTO = ae.CODAGTO)
				left join PROCEDIMENTOS e on (ae.CODPROCEDIMENTO = e.CODPROCEDIMENTO)
				where   a.CODINST = $_SESSION[CODINST]
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
			$dataNascimento = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATANASCIMENTO'])));  

			$this->db->trans_begin();
			$this->db->query("insert into AGENDAMENTO(
								DATA,
								HORA,
								NOME,
								SOBRENOME,
								CPF,
								NASCIMENTO,
								CODINST,
								PESO,
								ALTURA,
								CODCONV							
								) value 
								('$data',
								'$post[FFHORA]',
								upper('$post[FFNOMEPAC]'),
								upper('$post[FFSOBRENOMEPAC]'),
								'$post[FFCPF]',
								'$dataNascimento',
								$_SESSION[CODINST],
								$post[FFPESO],
								$post[FFALTURA],
								$post[FFCONVENIO]				
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
			$dataNascimento = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATANASCIMENTO']))); 
			$this->db->trans_begin();
			$this->db->query(" update AGENDAMENTO set 
								DATA = '$data', 
								HORA = '$post[FFHORA]',
								NOME = upper('$post[FFNOMEPAC]'),	
								SOBRENOME = upper('$post[FFSOBRENOMEPAC]'),
								CPF = '$post[FFCPF]',
								NASCIMENTO = '$dataNascimento',
								PESO = $post[FFPESO],
								ALTURA = $post[FFALTURA],
								CODCONV = $post[FFCONVENIO]
					
							where  CODAGTO = $post[FFCODAGTO];
							"
			);
			$this->db->query(" update AGTOEXAME set 
								CODPROCEDIMENTO = $post[FFPROCEDIMENTO]
							where CODAGTO = $post[FFCODAGTO]; "
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
				"select 	a.CODAGTO, ae.CODPROCEDIMENTO, e.DESCRICAO, a.NOME, a.SOBRENOME ,a.CPF, a.HORA, a.DATA,
							DATE_FORMAT(A.DATA, '%d/%c/%Y') as DATA1, DATE_FORMAT(a.NASCIMENTO, '%d/%c/%Y') as DNASCIMENTO,
							a.PESO, a.ALTURA, a.CODCONV
				from 		AGENDAMENTO a
				Join   AGTOEXAME ae on (a.CODAGTO = ae.CODAGTO)
				left join PROCEDIMENTOS e on (ae.CODPROCEDIMENTO = e.CODPROCEDIMENTO)
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
	
	/**
	 *  verifica se o agendamento pode ser Excluido
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 * 	@return bollean
	 */
	public function agendamentoPodeSerExcluido( $codagto ){
		try {
			$this->dados =  $this->query(
				" select count(*) as QTD from itfracionamento 
						where CODAGTOEXA in(select CODAGTOEXA FROM agtoexame where CODAGTO = $codagto ) "
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

	/**
	 * 	Metodo para excluir um Agendamento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codagto integer - inteiro com o código do agendamento
	 *
	 * 	@return array
	 */
	public function excluir( $codagto ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from agtoexame where codagto = $codagto"
			);
			$this->db->query(
				"delete from agendamento where codagto = $codagto"
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
	 * 	Metodo para buscar os agendamentos 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codagto integer - itneger com o código
	 *
	 * 	@return array
	 */
	public function buscaAgendamentoFiltro( $post ) {

		try {				
			$FF = '';
			if(isset($post['data'])) {
				$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['data'])));  
				$FF .= ( $post['data'] ) ? "and a.DATA = '$data' " : '';
			}
			if(isset($post['nome'])) {
				$FF .= ( $post['nome'] ) ? "and p.nome like '%" . strtoupper( $post['nome'] ) . "%'" : "";
			}
			
			$this->dados = $this->query(
				"select 	a.CODAGTO, ae.CODPROCEDIMENTO, e.DESCRICAO, a.NOME ,p.CPF, a.PRONTUARIO, a.HORA, a.DATA,
							DATE_FORMAT(A.DATA, '%d/%c/%Y') as DATA1, ae.CODAGTOEXA, a.SOBRENOME
				from 		AGENDAMENTO a
				Join   AGTOEXAME ae on (a.CODAGTO = ae.CODAGTO)
				left join PROCEDIMENTOS e on (ae.CODPROCEDIMENTO = e.CODPROCEDIMENTO)
				where 		1 = 1
				$FF
				order by a.DATA, a.HORA desc
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