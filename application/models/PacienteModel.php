<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Gerador
 * 
 *	@author Renato Roessler
 **/ 
class PacienteModel extends MY_Model {


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
		    
			if(isset($post['Prontuario'])) {
				$FF .= ( $post['Prontuario'] ) ? "and p.PRONTUARIO = $post[Prontuario] " : '';
			}
			if(isset($post['Nome'])) {
				$post['Nome'] = strtoupper($post['Nome']);
				$FF .= ( $post['Nome'] ) ? "and p.Nome like '%$post[Nome]%' " : '';
			}
			if(isset($post['CPF'])) {
				$FF .= ( $post['CPF'] ) ? "and p.CPF like '%$post[CPF]%' " : '';
			}			
			
			$this->dados = $this->query(
				"select 	p.PRONTUARIO,p.NOME,p.CODINST,p.CPF,p.DTNASCIMENTO,p.TELEFONE,p.PESO,p.EMAIL,
							DATE_FORMAT(p.DTNASCIMENTO, '%d/%c/%Y') as DATANASCIMENTO
				from 		PACIENTE p
				where 		1=1
							$FF
				order by 	p.nome"
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
	 * 	Metodo para inserir um Paciente
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ){
		try{
			$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDTNASC'])));  

			$this->db->trans_begin();
			$this->db->query("insert into PACIENTE(
								NOME,TELEFONE,PESO,CPF,EMAIL,DTNASCIMENTO,CODINST,ALTURA) value 
								(upper('$post[FFNOME]'),'$post[FFTELEFONE]',$post[FFPESO],'$post[FFCPF]','$post[FFEMAIL]','$data', $post[CODINST],$post[FFALTURA])"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('paciente', 'prontuario');

			$this->db->trans_commit();
			return $id[0]['prontuario'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}


	/**
	 * 	Metodo para atulizar um Paciente
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizar( $post ){
		try{
			$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDTNASC'])));  
			$this->db->trans_begin();
			$this->db->query(" update paciente set 
				NOME = upper('$post[FFNOME]'),
				TELEFONE = '$post[FFTELEFONE]',
				PESO = $post[FFPESO],
				CPF =  '$post[FFCPF]',
				EMAIL = '$post[FFEMAIL]',
				ALTURA = $post[FFALTURA],
				DTNASCIMENTO = '$data',
				CODINST = $post[CODINST]
				where  PRONTUARIO = $post[FFPRONTUARIO]"
			);
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}

			$this->db->trans_commit();
			return $post[FFPRONTUARIO];

		}catch (Exception $e){
			log_message('error', $this->db->error());
		}
		return false;
	} 

	/**
	 * 	Metodo para buscar um Paciente  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $prontuario itneger - integer com o prontuario
	 *
	 * 	@return array
	 */
	public function buscaPaciente( $prontuario ) {

		try {			
			$FF = '';
			$this->dados = $this->query(
				"select 	p.PRONTUARIO, DATE_FORMAT(p.DTNASCIMENTO, '%d/%c/%Y') as DATANASCIMENTO,
						    p.NOME, p.TELEFONE,p.PESO,p.CPF,p.EMAIL,p.EMAIL,p.CODINST,p.ALTURA
				from 		PACIENTE p				
				where 		p.PRONTUARIO = $prontuario
				order by 	p.NOME"
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
	 * 	Metodo para excluir um Paciente
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $Prontuario integer - inteiro com o prontuario
	 *
	 * 	@return array
	 */
	public function excluir( $prontuario ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from paciente where prontuario = $prontuario"
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
	 * 	Metodo para buscar todos os Pacientes  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *
	 * 	@return array
	 */
	public function buscaTodosPaciente( $post = null ) {

		try {			
			$filtros = array();
			if(isset($post['prontuario'])) {
				( $post['prontuario'] ) ? $filtros[] = "and p.prontuario = $post[prontuario]" : null; 
			}
			if(isset($post['cpf'])) {
				( $post['cpf'] ) ? $filtros[] = "and p.cpf = $post[cpf]" : null; 
			}
			( $post['nome'] ) ? $filtros[] = "and p.nome like '%" . strtoupper( $post['nome'] ) . "%'" : null; 
			
			$param = implode( ' ', $filtros );

			$this->dados = $this->query(
				"select 	p.PRONTUARIO, DATE_FORMAT(p.DTNASCIMENTO, '%d/%c/%Y') as DATANASCIMENTO,
						    p.NOME, p.TELEFONE,p.PESO,p.CPF,p.EMAIL,p.EMAIL,p.CODINST,p.ALTURA
				from 		PACIENTE p
				where		1 = 1
							$param 				
				order by 	p.NOME"
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