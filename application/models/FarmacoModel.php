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
							else 'Inativo' end ATIVODESC 
				
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
                        f.ATIVO    
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
			$this->db->query("insert into FARMACO(
								DESCRICAO,
                                PH,
                                SOLV_ORGANICO,
                                SOLV_INORGANICO,
                                CODINST,
                                ATIVO
								) value 
								(upper('$post[FFDESCRICAO]'),
                                $post[FFPH],
                                $post[FFSOLVORGANICO],
                                $post[FFSOLVINORGANICO],
                                $post[CODINST],
                                '$post[FFATIVO]'
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
				ATIVO = '$post[FFATIVO]'
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
    
    public function editar()
	{
		$dados['js'] = 'js/Farmaco.js';
 		//caregando o gerador
 		$this->load->model('FarmacoModel');
 		$this->FarmacoModel->buscaFarmaco($this->uri->segment(3));
 		$dados['retorno'] = $this->FarmacoModel->dados;
 		$dados['MSG'] = $this->session->MSG;
		$this->load->view('template/header',$dados);
		$this->load->view('FarmacoCadastroView');
		$this->load->view('template/footer');
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
                            f.ATIVO    
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
							else 'Inativo' end ATIVODESC 
				
				from 		farmaco f
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


}