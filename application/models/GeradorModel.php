<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Gerador
 * 
 *	@author Renato Roessler
 **/ 
class GeradorModel extends MY_Model {


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
	public function index( $post ,$codinst ) {

		try {			
			$FF = '';
			if(isset($post['FFCodigo'])) {
				$FF .= ( $post['FFCodigo'] ) ? "and g.CODGERADOR = $post[FFCodigo] " : '';
			}
			if(isset($post['Lote'])) {
				$FF .= ( $post['Lote'] ) ? "and g.LOTE =  $post[Lote] " : '';
			}
			if(isset($post['FFDATAPESQUISA'])) {
				$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAPESQUISA']))); 
				$FF .= ( $post['FFDATAPESQUISA'] ) ? "and g.DATA >= '$data' " : '';
			}
			if(isset($post['FFDATAFINALPESQUISA'])) {
				$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAFINALPESQUISA']))); 
				$FF .= ( $post['FFDATAFINALPESQUISA'] ) ? "and g.DATA <= '$data' " : '';
			}
			if(isset($post['FFATIVOFILTRO'])) {
				$dataAtual = date("Y-m-d");
				$FF .= ( $post['FFATIVOFILTRO'] == 'S') ? "and g.DATAINATIVO >= '$dataAtual' " : '';
				$FF .= ( $post['FFATIVOFILTRO'] == 'N') ? "and g.DATAINATIVO < '$dataAtual' " : '';
			}	
			$FF .= "and g.CODINST = $codinst";
			$this->dados = $this->query(
				"select 	g.CODGERADOR, g.LOTE,g.HORA, g.NRO_ELUICAO,g.ATIVO, g.DATA_CALIBRACAO,g.ATIVIDADE_CALIBRACAO,
							g.CODINST,g.APELUSER,g.CODFABRICANTE,g.DATA,i.FANTASIA,a.DESCRICAO as DESCFABRICANTE,
							u.NOME, DATE_FORMAT(g.DATA, '%d/%c/%Y') as DATA1,
										 DATE_FORMAT(g.DATAINATIVO, '%d/%c/%Y') as DATAFIM
				
				from 		gerador g
				left join   instituicao i on (g.codinst = i.codinst)
				left join   fabricante a on (g.codfabricante = a.codfabricante)
				left join   Usuario u on (g.apeluser = u.apeluser)
				where 		g.CODINST = $_SESSION[CODINST]
							$FF
				order by 	g.CODGERADOR"
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
	 * 	Metodo para inserir um Gerador
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ){
		try{
			//tratando a dara
			$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAHORA'])));  
			$dataCa = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATACALIBRACAO']))); 
			$dataInativo = date("Y-m-d",strtotime(str_replace('/','-',$post['DATAINATIVO']))); 

			$this->db->trans_begin();
			$this->db->query("insert into gerador(
								LOTE,DATA,NRO_ELUICAO,DATA_CALIBRACAO,ATIVIDADE_CALIBRACAO,
								CODINST,APELUSER,CODFABRICANTE, HORA, DATAINATIVO) value 
								('$post[FFLOTE]','$data', $post[FFNROELUICAO],'$dataCa', $post[FFATIVIDADECAL],
								$post[CODINST],'$post[APELUSER]',$post[FFFABRICANTE],'$post[FFHORA]','$dataInativo')"
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

	/**
	 * 	Metodo para atulizar um Gerador
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizar( $post ){
		try{
			//tratando a dara
			$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATAHORA'])));  
			$dataCa = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATACALIBRACAO']))); 
			$this->db->trans_begin();
			$this->db->query(" update gerador set 
				LOTE = '$post[FFLOTE]',
				DATA = '$data',
				NRO_ELUICAO = $post[FFNROELUICAO],
				DATA_CALIBRACAO = '$dataCa',
				ATIVIDADE_CALIBRACAO = $post[FFATIVIDADECAL],
				CODINST = $post[CODINST],
				APELUSER = '$post[APELUSER]',
				CODFABRICANTE = $post[FFFABRICANTE],
				HORA = '$post[FFHORA]'
				where  CODGERADOR = $post[FFCODGERADOR]"
			);
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}

			$this->db->trans_commit();
			return $post[FFCODGERADOR];

		}catch (Exception $e){
			log_message('error', $this->db->error());
		}
		return false;
	} 

	/**
	 * 	Metodo para buscar um gerador  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function buscaGerador( $codgerador ) {

		try {			
			$FF = '';
			//$FF .= ( $post['FFCodigo'] ) ? "and B.codbco = $post[FFCodigo] " : '';
			//$FF .= ( $post['FFNome'] ) ? "and B.Nome like upper('%$post[FFNome]%') " : '';
			$this->dados = $this->query(
				"select 	g.CODGERADOR, g.LOTE,g.HORA, g.NRO_ELUICAO, g.DATA_CALIBRACAO,g.ATIVIDADE_CALIBRACAO,
							g.CODINST,g.APELUSER,g.CODFABRICANTE,g.DATA	,DATE_FORMAT(DATA, '%d/%c/%Y') as DATAF,
							DATE_FORMAT(DATA_CALIBRACAO, '%d/%c/%Y') as DATA_CALIBRACAOF			
				from 		gerador g				
				where 		g.codgerador = $codgerador
				order by 	g.CODGERADOR"
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
	 * 	Metodo para excluir um Gerador
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codgerador integer - inteiro com o código do gerador
	 *
	 * 	@return array
	 */
	public function excluir( $codgerador ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from gerador where codgerador = $codgerador"
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
	 * 	Metodo para buscar todos Geradores Ativos da Instituicao
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *
	 * 	@return array
	 */
	public function buscaGeradorAtivos( $codinst ) {

		try {			
			$FF = '';
			$dataAtual = date("Y-m-d");
			$this->dados = $this->query(
				"select 	g.CODGERADOR, g.LOTE,g.HORA, g.NRO_ELUICAO, DATE_FORMAT(g.DATA, '%d/%c/%Y') as DATA1		
				from 		gerador g				
				where 		g.DATAINATIVO >=  '$dataAtual'
				and         g.CODINST = $codinst
				order by 	g.LOTE"
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
	 *  verifica se o gerador pode ser Excluido
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 * 	@return bollean
	 */
	public function geradorPodeSerExcluido( $codgerador ){
		try {
			$this->dados =  $this->query(
				" select count(*) as QTD from eluicao where CODGERADOR = $codgerador "
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