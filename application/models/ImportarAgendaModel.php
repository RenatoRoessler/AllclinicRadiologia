<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo Para Importar agenda
 * 
 *	@author Renato Roessler
 **/ 
class ImportarAgendaModel extends MY_Model {


	public function __construct() {
		parent::__construct();
	}
	
    /**
	 * 	Metodo para inserir um agendamento
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ){
		try{
			//tratando a dara
			//$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAHORA'])));  
			//$dataCa = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATACALIBRACAO']))); 
			//$dataInativo = date("Y-m-d",strtotime(str_replace('/','-',$post['DATAINATIVO']))); 

			$this->db->trans_begin();
			$this->db->query("insert into gerador(
								LOTE,DATA,NRO_ELUICAO,DATA_CALIBRACAO,ATIVIDADE_CALIBRACAO,
								CODINST,APELUSER,CODFABRICANTE, HORA, DATAINATIVO,ATIVIDADEMO99) value 
								('$post[FFLOTE]','$post[FFDATAHORA]', $post[FFNROELUICAO],'$post[FFDATACALIBRACAO]', $post[FFATIVIDADECAL],
								$post[CODINST],'$post[APELUSER]',$post[FFFABRICANTE],'$post[FFHORA]','$post[DATAINATIVO]', $post[FFATIVIDADEMO99])"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('gerador', 'codgerador');

			$this->db->trans_commit();
			return $id[0]['codgerador'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

}
