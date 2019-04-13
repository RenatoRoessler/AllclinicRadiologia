<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Farmaco
 * 
 *	@author Renato Roessler
 **/ 
class FarmacoModel extends MY_Model {


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
	public function index( $post  ) {

		try {			
			$FF = '';
			if(isset($post['FFCodigo'])) {
				$FF .= ( $post['FFCodigo'] ) ? "and f.CODFARMACO = $post[FFCodigo] " : '';
			}
			if(isset($post['FILTRO_ATIVO'])) {
				if($post['FILTRO_ATIVO'] != 'T'){
					$FF .= ( $post['FILTRO_ATIVO'] ) ? "and f.ATIVO = '$post[FILTRO_ATIVO]' " : '';
				}
			}
	
			$this->dados = $this->query(
                "select 	f.CODFARMACO, f.DESCRICAO, f.PH, f.SOLV_ORGANICO, f.SOLV_INORGANICO,
							f.ATIVO, case when f.ATIVO = 'S' then 'Ativo' 
							else 'Inativo' end ATIVODESC, f.PH_INFERIOR, f.CODFARMACO,
							fa.descricao as DESCFA
				
				from 		farmaco f
				left join fabricante fa on (f.codfabricante = fa.codfabricante)
				where 		f.CODINST = $_SESSION[CODINST]
							$FF
				order by 	f.DESCRICAO"
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
	 * 	Metodo para buscar todos os Farmacos Ativos da Instituicao
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *
	 * 	@return array
	 */
	public function buscaFarmacosAtivos( ) {

		try {			
			$FF = '';
			$this->dados = $this->query(
				"select 	f.CODFARMACO, f.DESCRICAO, f.PH, f.SOLV_ORGANICO, f.SOLV_INORGANICO,
                        f.ATIVO, f.CODFABRICANTE
								from 		farmaco f
                where 		f.CODINST = $_SESSION[CODINST]
                $FF
                order by 	f.DESCRICAO"
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
	 * 	Metodo para inserir um farmaco
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query("insert into farmaco(
								DESCRICAO,
                                PH,
                                SOLV_ORGANICO,
                                SOLV_INORGANICO,
                                CODINST,
								ATIVO,
								PH_INFERIOR,
								CODFABRICANTE
								) value 
								(upper('$post[FFDESCRICAO]'),
                                $post[FFPH],
                                $post[FFSOLVORGANICO],
                                $post[FFSOLVINORGANICO],
                                $post[CODINST],
								'$post[FFATIVO]',
								$post[PHINFERIOR],
								$post[FFFABRICANTE]
								)"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('farmaco', 'codfarmaco');

			$this->db->trans_commit();
			return $id[0]['codfarmaco'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
    }
    
    	/**
	 * 	Metodo para atulizar um farmaco
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizar( $post ){
		try{

			$this->db->trans_begin();
			$this->db->query(" update farmaco set 
				DESCRICAO = upper('$post[FFDESCRICAO]'),
				PH = $post[FFPH],
				SOLV_ORGANICO = $post[FFSOLVORGANICO],
				SOLV_INORGANICO = $post[FFSOLVINORGANICO],
				ATIVO = '$post[FFATIVO]',
				PH_INFERIOR =  $post[PHINFERIOR],
				CODFABRICANTE =  $post[FFFABRICANTE]
				where  CODFARMACO = $post[FFCODFARMACO]"
			);
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}
			$this->db->trans_commit();
			return $post[FFCODFARMACO];

		}catch (Exception $e){
			log_message('error', $this->db->error());
		}
		return false;
    } 
    
    
    	/**
	 * 	Metodo para buscar um Farmaco  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function buscaFarmaco( $codfarmaco ) {

		try {			
			$FF = '';
			$this->dados = $this->query(
				"select 	f.CODFARMACO, f.DESCRICAO, f.PH, f.SOLV_ORGANICO, f.SOLV_INORGANICO,
                            f.ATIVO, f.PH_INFERIOR, f.CODFABRICANTE
                        from 		farmaco f				
				where 		f.CODFARMACO = $codfarmaco
				order by 	f.DESCRICAO"
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
	 * 	Metodo Farmaco 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function buscaTodosFarmacos(  ) {

		try {					
	
			$this->dados = $this->query(
                "select 	f.CODFARMACO, f.DESCRICAO, f.PH, f.SOLV_ORGANICO, f.SOLV_INORGANICO,
							f.ATIVO, case when f.ATIVO = 'S' then 'Ativo' 
							else 'Inativo' end ATIVODESC , fa.DESCRICAO AS DESCFABRICANTE
				
				from 		farmaco f
				left join fabricante fa on(f.CODFABRICANTE = fa.CODFABRICANTE)
				where 		f.CODINST = $_SESSION[CODINST]
				and         f.ATIVO= 'S'

				order by 	f.DESCRICAO"
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
	 * 	Metodo para excluir um farmaco
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codfabricante integer - inteiro com o código do fabricante
	 *	@param $codfarmaco integer - inteiro com o código do farmaco
	 *
	 * 	@return array
	 */
	public function excluirFarmaco( $codfarmaco ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from farmaco 
				where  codfarmaco = $codfarmaco "
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

	public function FarmacoPodeSerExcluido($codfarmaco) {
		try {
			$this->dados =  $this->query(
				" select count(*) as QTD from marcacao where CODFARMACO  = $codfarmaco "
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

}
