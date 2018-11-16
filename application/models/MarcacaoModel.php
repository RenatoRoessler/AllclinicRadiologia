<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo da Marcação
 * 
 *	@author Renato Roessler
 **/ 
class MarcacaoModel extends MY_Model {


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
				$FF .= ( $post['Codigo'] ) ? "and m.CODMARCACAO = $post[Codigo] " : '';
			}
			if(isset($post['FFDATAPESQUISA'])) {
				$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAPESQUISA']))); 
				$FF .= ( $post['FFDATAPESQUISA'] ) ? "and m.DATA = '$data' " : '';
			}
			if(isset($post['FFATIVOFILTRO'])) {
				//$FF .= ( $post['FFATIVOFILTRO'] ) ? "and e.ATIVO = '$post[FFATIVOFILTRO]' " : '';
			}
			$this->dados = $this->query(
				"select 	m.CODMARCACAO, m.CODELUICAO, m.DATA, m.HORA, m.KIT_CODFABRICANTE, m.KIT_LOTE,
							m.NCI_CODFABRICANTE, m.NACI_LOTE, m.CQ, m.ORGANICO, m.QUIMICO, m.APELUSER,
							m.KIT_CODRADIOFARMACO	,DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1,
							u.NOME, f.DESCRICAO AS DESCKITFABRICANTE,fa.DESCRICAO AS DESCKITFARMACO
				from 		marcacao m
				left join usuario u on (m.apeluser = u.apeluser)
				left join fabricante f on (m.KIT_CODFABRICANTE = f.CODFABRICANTE)
				left join fabricante fa on (m.KIT_CODRADIOFARMACO = fa.CODFABRICANTE)
				join      eluicao e on (m.CODELUICAO = e.CODELUICAO)
				join      gerador g on (e.CODGERADOR = g.CODGERADOR)
				where 	  g.CODINST = $_SESSION[CODINST]
							$FF
				order by 	m.CODMARCACAO desc"
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
	 * 	Metodo para inserir uma Marcação
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
			$this->db->query("insert into MARCACAO(
								CODELUICAO,
								DATA,
								HORA,
								KIT_CODFABRICANTE,
								KIT_CODRADIOFARMACO,
								KIT_LOTE,
								NCI_CODFABRICANTE,
								NACI_LOTE,
								CQ,
								ORGANICO,
								QUIMICO,
								APELUSER
								) value 
								($post[FFELUICAO],
								'$data',
								'$post[FFHORA]',
								$post[FFKITFABRICANTE],
								$post[FFKITRADIOFARMACO],
								$post[FFKITLOTE],
								$post[FFNACIFABRICANTE],
								$post[FFNACILOTE],
								'$post[FFCQ]',
								$post[FFORGANICO],
								$post[FFQUIMICO],
								'$post[APELUSER]'
								)"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id CODMARCACAO
			$id = $this->retornaMaxColuna('marcacao', 'codmarcacao');

			$this->db->trans_commit();
			return $id[0]['codmarcacao'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}


	/**
	 * 	Metodo para atualizar uma Marcação
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
			$this->db->query(" update marcacao set 
								DATA ='$data', 
								HORA = '$post[FFHORA]',
								CODELUICAO = $post[FFELUICAO],
								KIT_CODFABRICANTE = $post[FFKITFABRICANTE],
								KIT_CODRADIOFARMACO = $post[FFKITRADIOFARMACO],
								KIT_LOTE = $post[FFKITLOTE],
								NCI_CODFABRICANTE  = $post[FFNACIFABRICANTE],
								NACI_LOTE = $post[FFNACILOTE],
								CQ = '$post[FFCQ]',
								ORGANICO = $post[FFORGANICO],
								QUIMICO = $post[FFQUIMICO]
															
							where  	CODMARCACAO = $post[FFCODMARCACAO]"
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

		/**
	 * 	Metodo para buscar uma Eluição  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function buscaMarcacao( $codmarcacao ) {

		try {			
			$this->dados = $this->query(
				"select 	m.CODMARCACAO, m.CODELUICAO, m.DATA, m.HORA, m.KIT_CODFABRICANTE, 
				            m.KIT_LOTE,	m.NCI_CODFABRICANTE, m.NACI_LOTE, m.CQ, m.ORGANICO, 
				            m.QUIMICO, m.APELUSER,DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1,
				            m.KIT_CODRADIOFARMACO
				from 		marcacao m			
				where 		m.codmarcacao = $codmarcacao
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
	 * 	Metodo para excluir uma Marcaçaõ
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codmarcacao integer - integer com da Marcação
	 *
	 * 	@return array
	 */
	public function excluir( $codmarcacao ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from marcacao where codmarcacao = $codmarcacao "
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
	 * 	Metodo para buscar todoas as marcações  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *
	 * 	@return array
	 */
	public function buscaTodasMarcacao() {

		try {			
			$this->dados = $this->query(
				"select 	m.CODMARCACAO, m.CODELUICAO, m.DATA, m.HORA, m.KIT_CODFABRICANTE, 
				            m.KIT_LOTE,	m.NCI_CODFABRICANTE, m.NACI_LOTE, m.CQ, m.ORGANICO, 
				            m.QUIMICO, m.APELUSER,DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1,
				            m.KIT_CODRADIOFARMACO
				from 		marcacao m
				join        eluicao e on (m.CODELUICAO = e.CODELUICAO)
				JOIN        gerador g on (e.CODGERADOR = g.CODGERADOR)
				where       g.CODINST = $_SESSION[CODINST]			
				order by m.DATA desc
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