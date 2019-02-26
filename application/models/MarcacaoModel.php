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
				//$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAPESQUISA']))); 
				$FF .= ( $post['FFDATAPESQUISA'] ) ? "and m.DATA >= '$post[FFDATAPESQUISA]' " : '';
			}
			if(isset($post['FFDATAFINAL'])) {
				//$dataf = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAFINAL']))); 
				$FF .= ( $post['FFDATAFINAL'] ) ? "and m.DATA <= '$post[FFDATAFINAL]' " : '';
			}
			if(isset($post['FFATIVOFILTRO'])) {
				$dataAtual = date("Y-m-d H:i:s");
				$FF .= ( $post['FFATIVOFILTRO'] == 'S') ? "and e.DATAINATIVO >= '$dataAtual' " : '';
				$FF .= ( $post['FFATIVOFILTRO'] == 'N') ? "and e.DATAINATIVO < '$dataAtual' " : '';
			}
			$this->dados = $this->query(
				"select 	m.CODMARCACAO, m.CODELUICAO, m.DATA, m.HORA, 
							m.CQ, m.ORGANICO, m.INORGANICO, m.APELUSER,
							DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1,
							u.NOME, f.DESCRICAO AS DESCKITFABRICANTE,fa.DESCRICAO AS DESCKITFARMACO,
							m.PH, m.CODFARMACO, m.LOTE, m.APROVADO
				from 		marcacao m
				left join usuario u on (m.apeluser = u.apeluser)				
				left join farmaco fa on (m.CODFARMACO = fa.CODFARMACO)
				left join fabricante f on (fa.CODFABRICANTE = f.CODFABRICANTE)
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
			if(!$post['FFORGANICOSUPERIOR'] > 0){
				$post['FFORGANICOSUPERIOR'] = 0;
			}
			if(!$post['FFORGANICOINFERIOR'] > 0){
				$post['FFORGANICOINFERIOR'] = 0;
			}
			if(!$post['FFORGANICO'] > 0){
				$post['FFORGANICO'] = 0;
			}
			if(!$post['FFINORGANICO'] > 0){
				$post['FFINORGANICO'] = 0;
			}
			if(!$post['FFINORGANICOSUPERIOR'] > 0){
				$post['FFINORGANICOSUPERIOR'] = 0;
			}
			if(!$post['FFINORGANICOINFERIOR'] > 0){
				$post['FFINORGANICOINFERIOR'] = 0;
			}
			if(!$post['FFMEDIA'] > 0){
				$post['FFMEDIA'] = 0;
			}			
			if(!$post['FFPH'] > 0){
				$post['FFPH'] = 0;
			}
			
			$this->db->trans_begin();
			$this->db->query("insert into MARCACAO(
								CODELUICAO,
								DATA,
								HORA,
								CQ,
								ORGANICO,
								INORGANICO,
								APELUSER,
								LOTE,
								CODFARMACO,
								PH,
								ORGANICO_SUPERIOR,
								ORGANICO_INFERIOR,
								INORGANICO_SUPERIOR,
								INORGANICO_INFERIOR,
								EFICIENCIA_MEDIA,
								APROVADO
								) value 
								($post[FFELUICAO],
								'$post[FFDATAHORA]',
								'$post[FFHORA]',
								'$post[FFCQ]',
								$post[FFORGANICO],
								$post[FFINORGANICO],
								'$post[APELUSER]',
								'$post[FFLOTE]',
								$post[FFFARMACO],
								$post[FFPH],
								$post[FFORGANICOSUPERIOR],
								$post[FFORGANICOINFERIOR],
								$post[FFINORGANICOSUPERIOR],
								$post[FFINORGANICOINFERIOR],
								$post[FFMEDIA],
								'$post[FFAPROVADO]'
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
			if(!$post['FFORGANICOSUPERIOR'] > 0){
				$post['FFORGANICOSUPERIOR'] = 0;
			}
			if(!$post['FFORGANICOINFERIOR'] > 0){
				$post['FFORGANICOINFERIOR'] = 0;
			}
			if(!$post['FFORGANICO'] > 0){
				$post['FFORGANICO'] = 0;
			}
			if(!$post['FFINORGANICO'] > 0){
				$post['FFINORGANICO'] = 0;
			}
			if(!$post['FFINORGANICOSUPERIOR'] > 0){
				$post['FFINORGANICOSUPERIOR'] = 0;
			}
			if(!$post['FFINORGANICOINFERIOR'] > 0){
				$post['FFINORGANICOINFERIOR'] = 0;
			}			
			if(!$post['FFPH'] > 0){
				$post['FFPH'] = 0;
			}
			if(!$post['FFMEDIA'] > 0){
				$post['FFMEDIA'] = 0;
			}
			$this->db->trans_begin();
			$this->db->query(" update marcacao set 
								DATA = '$post[FFDATAHORA]', 
								HORA = '$post[FFHORA]',
								CQ = '$post[FFCQ]',
								ORGANICO = $post[FFORGANICO],
								INORGANICO = $post[FFINORGANICO],
								PH = $post[FFPH],
								CODFARMACO =  $post[FFFARMACO],
								LOTE = '$post[FFLOTE]',
								ORGANICO_SUPERIOR = $post[FFORGANICOSUPERIOR],
								ORGANICO_INFERIOR = $post[FFORGANICOINFERIOR],
								INORGANICO_SUPERIOR = $post[FFINORGANICOSUPERIOR],
								INORGANICO_INFERIOR = $post[FFINORGANICOINFERIOR],	
								EFICIENCIA_MEDIA = $post[FFMEDIA],
								APROVADO = '$post[FFAPROVADO]'						
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
				"select 	m.CODMARCACAO, m.CODELUICAO, m.DATA, m.HORA, fa.CODFABRICANTE, 
				            m.CQ, m.ORGANICO, 
				            m.INORGANICO, m.APELUSER,DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1,
							m.PH, m.CODFARMACO, m.LOTE,
							DATE_FORMAT(m.HORA,'%H:%i') AS HORAMINUTO, f.DESCRICAO,
							fa.DESCRICAO AS DESCFARMACO,m.ORGANICO_SUPERIOR,
							m.ORGANICO_INFERIOR,m.INORGANICO_SUPERIOR,
							m.INORGANICO_INFERIOR, m.EFICIENCIA_MEDIA,m.APROVADO
				from 		marcacao m				
				left join  	farmaco fa on (m.CODFARMACO = fa.CODFARMACO)
				left join        fabricante f on (fa.CODFABRICANTE = f.CODFABRICANTE)		
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
	public function excluirMarcacao( $codmarcacao ) {

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
		$dataAtual = date("Y-m-d H:i:s");
		try {			
			$this->dados = $this->query(
				"select 	m.CODMARCACAO, m.CODELUICAO, m.DATA, m.HORA,  
				            m.CQ, m.ORGANICO, 
				            m.INORGANICO, m.APELUSER,DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1,
				            m.CODFARMACO
				from 		marcacao m
				join        eluicao e on (m.CODELUICAO = e.CODELUICAO)
				JOIN        gerador g on (e.CODGERADOR = g.CODGERADOR)
				where       g.CODINST = $_SESSION[CODINST]	
				and e.DATAINATIVO >= '$dataAtual'		
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

	/**
	 *  verifica se a marcação pode ser Excluida
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 * 	@return bollean
	 */
	public function MarcacaoPodeSerExcluido( $codmarcacao ){
		try {
			$this->dados =  $this->query(
				" select count(*) as QTD from itfracionamento where CODMARCACAO = $codmarcacao "
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