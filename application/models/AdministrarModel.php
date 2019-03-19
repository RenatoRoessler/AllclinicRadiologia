<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Administrar
 * 
 *	@author Renato Roessler
 **/ 
class AdministrarModel extends MY_Model {


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
			if(isset($post['FILTROPRONTUARIO'])) {
				$FF .= ( $post['FILTROPRONTUARIO'] ) ? "and p.PRONTUARIO = $post[FILTROPRONTUARIO] " : '';
			}			
			if(isset($post['FILTROLOTE'])) {
				$FF .= ( $post['FILTROLOTE'] ) ? "and m.LOTE = '$post[FILTROLOTE]' " : '';
			}
			//só filtra por data se não tiver prontuario ou lote
			if( $FF == ''){
				if(isset($post['FFDATAPESQUISA'])) {
					//$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAPESQUISA']))); 
					$FF .= ( $post['FFDATAPESQUISA'] ) ? "and a.DATA >= '$post[FFDATAPESQUISA]' " : '';
				}
				if(isset($post['FFDATAFINALPESQUISA'])) {
					//$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAFINALPESQUISA']))); 
					$FF .= ( $post['FFDATAFINALPESQUISA'] ) ? "and a.DATA <= '$post[FFDATAFINALPESQUISA]' " : '';
				}
			}
			if(isset($post['FILTRONOME'])) {
				$FF .= ( $post['FILTRONOME'] ) ? "and a.NOME LIKE '%$post[FILTRONOME]%' " : '';
			}		
		
			$this->dados = $this->query(
                "select  i.CODITFRACIONAMENTO, i.CODMARCACAO, i.CODAGTOEXA, i.ATIVIDADE_INICIAL, i.HORA_INICIAL,
                         i.ATIVIDADE_ADMINISTRADA , i.HORA_ADMINISTRADA,a.NOME as NOMEPACIENTE,
                         pr.DESCRICAO,DATE_FORMAT(a.DATA, '%d/%c/%Y') as DATA1, a.HORA,
						 pr.DESCRICAO,DATE_FORMAT(a.HORA,'%H:%i') AS HORAMINUTO,
						 m.LOTE as LOTEMARCACAO, e.LOTE as LOTEELUICAO,
						 g.LOTE as LOTEGERADOR,
						 e.PUREZA_RADIONUCLIDICA
						 
                from 	itfracionamento i
                left join    agtoexame ag on (i.CODAGTOEXA = ag.CODAGTOEXA)  
                left join    agendamento a on (ag.codagto = a.codagto)
				left join    procedimentos pr on (ag.codprocedimento = pr.codprocedimento)
				left join    marcacao m on (i.CODMARCACAO =  m.CODMARCACAO)
				left join    eluicao e on (m.CODELUICAO = e.CODELUICAO)
				left join    gerador g on (e.CODGERADOR = g.CODGERADOR)
				where 1=1			$FF
				order by 	i.CODITFRACIONAMENTO
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
			$this->db->query("update  itfracionamento set 
								ATIVIDADE_INICIAL = $post[FFATIVIDADE],
								HORA_INICIAL = '$post[FFHORAINICIO]',
								ATIVIDADE_ADMINISTRADA = $post[FFATVADMINISTRADA],
								HORA_ADMINISTRADA = '$post[FFHORAADMINISTRADA]'
								where CODITFRACIONAMENTO =  $post[FFCODITFRACIONAMENTO]"
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

	/*
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
				"select 	i.CODMARCACAO, i.CODITFRACIONAMENTO, 
							ag.NOME , ag.CPF,pr.DESCRICAO as NOMEPROCEDIMENTO,
							i.ATIVIDADE_INICIAL, i.HORA_INICIAL, i.ATIVIDADE_ADMINISTRADA, i.HORA_ADMINISTRADA,
							DATE_FORMAT(ag.DATA, '%d/%c/%Y') as DATA1, ag.HORA
				from 		itfracionamento i 
				join agtoexame age on (i.CODAGTOEXA = age.CODAGTOEXA)
				join agendamento ag on ( ag.CODAGTO = age.CODAGTO)
				join procedimentos pr on (age.CODPROCEDIMENTO = pr.CODPROCEDIMENTO)
				where  i.CODITFRACIONAMENTO = 		$coditfracionamento
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
