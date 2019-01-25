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
				$FF .= ( $post['FFDATAPESQUISA'] ) ? "and m.DATA >= '$data' " : '';
			}
			if(isset($post['FFDATAFINAL'])) {
				$dataf = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAFINAL']))); 
				$FF .= ( $post['FFDATAFINAL'] ) ? "and m.DATA <= '$dataf' " : '';
			}
			if(isset($post['FFATIVOFILTRO'])) {
				$dataAtual = date("Y-m-d H:i:s");
				$FF .= ( $post['FFATIVOFILTRO'] == 'S') ? "and e.DATAINATIVO >= '$dataAtual' " : '';
				$FF .= ( $post['FFATIVOFILTRO'] == 'N') ? "and e.DATAINATIVO < '$dataAtual' " : '';
			}
			$this->dados = $this->query(
				"select 	m.CODMARCACAO, m.CODELUICAO, m.DATA, m.HORA, m.KIT_CODFABRICANTE, m.KIT_LOTE,
							m.CQ, m.ORGANICO, m.INORGANICO, m.APELUSER,
							DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1,
							u.NOME, f.DESCRICAO AS DESCKITFABRICANTE,fa.DESCRICAO AS DESCKITFARMACO,
							m.PH, m.CODFARMACO, m.LOTE
				from 		marcacao m
				left join usuario u on (m.apeluser = u.apeluser)
				left join fabricante f on (m.KIT_CODFABRICANTE = f.CODFABRICANTE)
				left join farmaco fa on (m.CODFARMACO = fa.CODFARMACO)
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
			//$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATAHORA']))); 
			if($post['FFCQ'] == 'N'){
				if(isset($post['FFORGANICO'])){
					$post['FFORGANICO'] = 0;
				} 
				if(isset($post['FFINORGANICO'])){
					$post['FFINORGANICO'] = 0;
				}
				if(isset($post['FFPH'])){
					$post['FFPH'] = 0;
				}
			}
			if(isset($post['ORGANICO_SUPERIOR'])){
				$post['ORGANICO_SUPERIOR'] = 0;
			}
			if(isset($post['ORGANICO'])){
				$post['ORGANICO'] = 0;
			}
			if(isset($post['INORGANICO'])){
				$post['INORGANICO'] = 0;
			}
			if(isset($post['ORGANICO_INFERIOR'])){
				$post['ORGANICO_INFERIOR'] = 0;
			}
			if(isset($post['INORGANICO_SUPERIOR'])){
				$post['INORGANICO_SUPERIOR'] = 0;
			}
			if(isset($post['INORGANICO_INFERIOR'])){
				$post['INORGANICO_INFERIOR'] = 0;
			}
			if(isset($post['EFICIENCIA_MEDIA'])){
				$post['EFICIENCIA_MEDIA'] = 0;
			}
			

			$this->db->trans_begin();
			$this->db->query("insert into MARCACAO(
								CODELUICAO,
								DATA,
								HORA,
								KIT_CODFABRICANTE,
								KIT_LOTE,
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
								EFICIENCIA_MEDIA
								) value 
								($post[FFELUICAO],
								'$post[FFDATAHORA]',
								'$post[FFHORA]',
								$post[FFKITFABRICANTE],
								'$post[FFKITLOTE]',
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
								$post[FFMEDIA]
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
			//$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATAHORA'])));  

			if(isset($post['ORGANICO_SUPERIOR'])){
				$post['ORGANICO_SUPERIOR'] = 0;
			}
			if(isset($post['ORGANICO'])){
				$post['ORGANICO'] = 0;
			}
			if(isset($post['INORGANICO'])){
				$post['INORGANICO'] = 0;
			}
			if(isset($post['ORGANICO_INFERIOR'])){
				$post['ORGANICO_INFERIOR'] = 0;
			}
			if(isset($post['INORGANICO_SUPERIOR'])){
				$post['INORGANICO_SUPERIOR'] = 0;
			}
			if(isset($post['INORGANICO_INFERIOR'])){
				$post['INORGANICO_INFERIOR'] = 0;
			}
			if(isset($post['EFICIENCIA_MEDIA'])){
				$post['EFICIENCIA_MEDIA'] = 0;
			}

			$this->db->trans_begin();
			$this->db->query(" update marcacao set 
								DATA = '$post[FFDATAHORA]', 
								HORA = '$post[FFHORA]',
								CODELUICAO = $post[FFELUICAO],
								KIT_CODFABRICANTE = $post[FFKITFABRICANTE],
								KIT_LOTE = '$post[FFKITLOTE]',
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
								EFICIENCIA_MEDIA = $post[FFMEDIA]										
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
				            m.KIT_LOTE, m.CQ, m.ORGANICO, 
				            m.INORGANICO, m.APELUSER,DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATA1,
							m.PH, m.CODFARMACO, m.LOTE,
							DATE_FORMAT(m.HORA,'%H:%i') AS HORAMINUTO, f.DESCRICAO,
							fa.DESCRICAO AS DESCFARMACO,m.ORGANICO_SUPERIOR,
							m.ORGANICO_INFERIOR,m.INORGANICO_SUPERIOR,
							m.INORGANICO_INFERIOR, m.EFICIENCIA_MEDIA
				from 		marcacao m
				join        fabricante f on (m.KIT_CODFABRICANTE = f.CODFABRICANTE)	
				left join  	farmaco fa on (m.CODFARMACO = fa.CODFARMACO)	
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
				"select 	m.CODMARCACAO, m.CODELUICAO, m.DATA, m.HORA, m.KIT_CODFABRICANTE, 
				            m.KIT_LOTE, m.CQ, m.ORGANICO, 
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