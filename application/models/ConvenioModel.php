<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Convênio
 * 
 *	@author Renato Roessler
 **/ 
class ConvenioModel extends MY_Model {


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
            if(isset($post['FFCodigo'])){
                $FF .= ( $post['FFCodigo'] ) ? "and c.CODCONV = $post[FFCodigo] " : '';
            }
            if(isset($post['FFFiltroDescricao'])){
                $FF .= ( $post['FFFiltroDescricao'] ) ? "and c.DESCRICAO LIKE upper('%$post[FFFiltroDescricao]%') " : '';
            }

			$this->dados = $this->query(
                "Select c.CODCONV, c.DESCRICAO, c.CODINST, i.RAZAO, i.FANTASIA
                from convenio c 
                join  instituicao i on (c.CODINST = i.CODINST)
                where c.codinst =  $post[CODINST] 
                $FF "
			);			
			$this->dados = $this->dados->result_array();			
			return true;
	
		} catch (Exception $e) {
			/*	Criando Log*/
			log_message('error', $this->db->error());
		}
		return false;
    }
    
    public function inserirConvenio( $post ){
        try{
			$this->db->trans_begin();
			$this->db->query("insert into convenio(DESCRICAO,CODINST) value ( upper('$post[FFDESCRICAO]'),$post[CODINST])"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();
			}
			//pegando o id
			$id = $this->retornaMaxColuna('convenio', 'codconv');

			$this->db->trans_commit();
			return $id[0]['codconv'];


		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
    }

    public function buscaConvenio( $codconv ){

        try {			
			$this->dados = $this->query(
				"select 	c.CODCONV, c.DESCRICAO, c.CODINST	
				from 		convenio c				
				where 		c.CODCONV = $codconv
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

    public function atualizarConvenio( $post ){
        try{
			$this->db->trans_begin();
			$this->db->query(" update convenio set 
								DESCRICAO = '$post[FFDESCRICAO]'			
							where  CODCONV = $post[FFCODCONV]"
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

    public function excluir( $codconv) {
        try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from convenio where CODCONV = $codconv "
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

    
    public function convenioVinculadoNoAgendamento( $codconv ) {
        try {
			$this->dados =  $this->query(
				" select count(*) as QTD from agendamento where CODCONV = $codconv "
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
	 * 	Metodo para buscar os Convênios  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *
	 * 	@return array
	 */
	public function buscaTodosConvenios( $codinst) {
	
		try {			
			$this->dados = $this->query(
				"select 	c.CODCONV, c.DESCRICAO		
				from 		convenio c 		
				where 	   1 =1 
				and        c.CODINST  = $codinst
				order by c.DESCRICAO 
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
