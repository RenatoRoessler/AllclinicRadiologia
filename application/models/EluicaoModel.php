<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Eluição
 * 
 *	@author Renato Roessler
 **/ 
class EluicaoModel extends MY_Model {


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
				$FF .= ( $post['Codigo'] ) ? "and e.CODELUICAO = $post[Codigo] " : '';
			}
			if(isset($post['FFDATAPESQUISA'])) {
				$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAPESQUISA']))); 
				$FF .= ( $post['FFDATAPESQUISA'] ) ? "and e.DATA >= '$data' " : '';
			}
			if(isset($post['FFDATAFINAL'])) {
				$dataf = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAFINAL']))); 
				$FF .= ( $post['FFDATAFINAL'] ) ? "and e.DATA <= '$dataf' " : '';
			}
			if(isset($post['FFATIVOFILTRO'])) {
				$dataAtual = date("Y-m-d H:i:s");
				$FF .= ( $post['FFATIVOFILTRO'] == 'S') ? "and e.DATAINATIVO >= '$dataAtual' " : '';
				$FF .= ( $post['FFATIVOFILTRO'] == 'N') ? "and e.DATAINATIVO < '$dataAtual' " : '';
			}	
			$this->dados = $this->query(
				"select 	e.CODELUICAO,e.DATA,e.HORA, e.VOLUME, e.ATIVIDADE_MCI,e.ATIVO, e.CQ,
							e.EFI_ATV_TEORICA, e.EFI_ATV_MEDIDA, e.EFI_VOLUME, e.PUREZA_RADIONUCLIDICA,	
							e.PUREZA_QUIMICA, e.CODGERADOR,e.EFI_RESULTADO,e.LIMPIDA, e.LOTE,
							DATE_FORMAT(e.DATA, '%d/%c/%Y') as DATA1, e.PUREZA_RADIOQUIMICA
				from 		Eluicao e
				join        Gerador g on (e.CODGERADOR = g.CODGERADOR)
				where 		g.CODINST =  $_SESSION[CODINST]
							$FF
				order by 	e.CODELUICAO"
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
	 * 	Metodo para inserir uma Eluição
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
			$datahora= $post['FFDATAHORA'] . ' ' . $post['FFHORA'];
			$datafim = date('Y-m-d H:i:s', strtotime($datahora .' +15 hour'));
			$post['FFRESULTADO'] =  str_replace('%' , '' , $post['FFRESULTADO'] );
			$post['FFRADIOQUIMICA'] =  str_replace('% Reprovado' , '' , $post['FFRADIOQUIMICA'] );
			$post['FFRADIOQUIMICA'] =  str_replace('% Aprovado' , '' , $post['FFRADIOQUIMICA'] );

			$post['FFRADIONUCLIDICA'] = 0;
			
			if($post['FFCQ'] == 'N'){
				if(isset($post['FFATIVIDADETEORICA'])){
					$post['FFATIVIDADETEORICA'] = 0;
				} 
				if(isset($post['FFATIVIDADE_MEDIDA'])){
					$post['FFATIVIDADE_MEDIDA'] = 0;
				}
				if(isset($post['FFRESULTADO'])){
					$post['FFRESULTADO'] = 0;
				}
					
				if(isset($post['FFSUPERIOR'])){
					$post['FFSUPERIOR'] = 0;
				}
				if(isset($post['FFINFERIOR'])){
					$post['FFINFERIOR'] = 0;
				}
				if(isset($post['FFRADIOQUIMICA'])){
					$post['FFRADIOQUIMICA'] = 0;
				}
				if(isset($post['FFATV'])){
					$post['FFATV'] = 0;
				} 
				if(isset($post['FFATVTECNEZIO'])){
					$post['FFATVTECNEZIO'] = 0;
				} 
				if(isset($post['FFATVFUNDO'])){
					$post['FFATVFUNDO'] = 0;
				} 
				if(isset($post['FFRADIOQUIMICA'])){
					$post['FFRADIOQUIMICA'] = 0;
				} 
				if(isset($post['FFPH'])){
					$post['FFPH'] = 0;
				} 
				if(isset($post['FFRADIONUCLIDICA'])){
					$post['FFRADIONUCLIDICA'] = 0;
				}
			}
			

			$this->db->trans_begin();
			$this->db->query("insert into ELUICAO(
								DATA,
								HORA,
								VOLUME,
								ATIVIDADE_MCI,
								CQ,
								EFI_ATV_TEORICA,
								EFI_ATV_MEDIDA,
								EFI_RESULTADO,

								SUPERIOR,
								INFERIOR,
								PUREZA_RADIOQUIMICA,

								ATV,
								ATVTECNEZIO,
								ATVFUNDO,
								PUREZA_RADIONUCLIDICA,

								PH,
								LIMPIDA,								
								CODGERADOR,
								LOTE,
								DATAINATIVO,
								DATAHORA								
								) value 
								('$post[FFDATAHORA]',
								'$post[FFHORA]',
								$post[FFVOLUME],
								$post[FFATIVIDADE_MCI],
								'$post[FFCQ]',
								$post[FFATIVIDADETEORICA],
								$post[FFATIVIDADE_MEDIDA],
								$post[FFRESULTADO],

								$post[FFSUPERIOR],
								$post[FFINFERIOR],
								$post[FFRADIOQUIMICA],

								$post[FFATV],
								$post[FFATVTECNEZIO],
								$post[FFATVFUNDO],
								$post[FFRADIONUCLIDICA],

								$post[FFPH],
								'$post[FFLIMPIDA]',
								$post[FFGERADOR],
								'$post[FFLOTE]',
								'$datafim',
								'$datahora'
								
								)"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}
			//pegando o id
			$id = $this->retornaMaxColuna('eluicao', 'codeluicao');		

			$this->db->trans_commit();
			return $id[0]['codeluicao'];
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}	

	/**
	 * 	Metodo para atulizar uma Eluição
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
			$datahora= $post['FFDATAHORA'] . ' ' . $post['FFHORA'];
			$datafim = date('Y-m-d H:i:s', strtotime($datahora .' +4 hour'));
			$post['FFRESULTADO'] =  str_replace('%' , '' , $post['FFRESULTADO'] );
			$post['FFRADIOQUIMICA'] =  str_replace('% Reprovado' , '' , $post['FFRADIOQUIMICA'] );
			$post['FFRADIOQUIMICA'] =  str_replace('% Aprovado' , '' , $post['FFRADIOQUIMICA'] );
			$this->db->trans_begin();
			$this->db->query(" update eluicao set 
								DATA ='$post[FFDATAHORA]', 
								HORA = '$post[FFHORA]',
								VOLUME = $post[FFVOLUME],
								ATIVIDADE_MCI = $post[FFATIVIDADE_MCI],
								CQ = '$post[FFCQ]',
								EFI_ATV_TEORICA = $post[FFATIVIDADETEORICA],
								EFI_ATV_MEDIDA = $post[FFATIVIDADE_MEDIDA],
								EFI_RESULTADO = $post[FFRESULTADO],
								SUPERIOR = $post[FFSUPERIOR],
								INFERIOR = $post[FFINFERIOR],	
								PUREZA_RADIONUCLIDICA = $post[FFRADIONUCLIDICA],
								ATV = $post[FFATV],
								ATVTECNEZIO = $post[FFATVTECNEZIO],
								ATVFUNDO = $post[FFATVFUNDO],
								PUREZA_RADIONUCLIDICA = $post[FFRADIONUCLIDICA],
								LIMPIDA = '$post[FFLIMPIDA]',
								CODGERADOR = $post[FFGERADOR],
								LOTE = 	'$post[FFLOTE]',
								DATAHORA = '$datahora',
								DATAINATIVO	= '$datafim',
								PH = $post[FFPH]			
							where  CODELUICAO = $post[FFCODELUICAO]"
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
	public function buscaEluicao( $codeluicao ) {

		try {			
			$this->dados = $this->query(
				"select 	e.CODELUICAO,e.DATA,e.HORA, e.VOLUME, e.ATIVIDADE_MCI,e.ATIVO, e.CQ,
							e.EFI_ATV_TEORICA, e.EFI_ATV_MEDIDA, e.EFI_VOLUME, e.PUREZA_RADIONUCLIDICA,	
							e.PUREZA_QUIMICA, e.CODGERADOR,e.EFI_RESULTADO,e.LIMPIDA,e.PH,
							DATE_FORMAT(e.data, '%d/%c/%Y') as DATA1, e.LOTE, e.PUREZA_RADIOQUIMICA,
							e.SUPERIOR, e.INFERIOR, e.ATV, e.ATVTECNEZIO, e.ATVFUNDO
				from 		eluicao e				
				where 		e.codeluicao = $codeluicao
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
	 * 	Metodo para excluir uma Eluição
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $codeluicao integer - integer com da eluicao
	 *
	 * 	@return array
	 */
	public function excluir( $codeluicao ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from eluicao where codeluicao = $codeluicao "
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
	 * 	Metodo para buscar as Eluições Ativas  
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *
	 * 	@return array
	 */
	public function buscaEluicoes( $ativo = true, $codeluicao = 0 ) {
		$FF = '';
		if($ativo =='S'){
			$dataAtual = date("Y-m-d H:i:s");
			$FF .= " and e.DATAINATIVO >= '$dataAtual'";
		}
		if($codeluicao > 0){
			$FF .= " and  e.CODELUICAO = $codeluicao "; 
		}		
		try {			
			$this->dados = $this->query(
				"select 	e.CODELUICAO,e.DATA,e.HORA, e.VOLUME, e.ATIVIDADE_MCI,e.ATIVO, e.CQ,
							e.EFI_ATV_TEORICA, e.EFI_ATV_MEDIDA, e.EFI_VOLUME, e.PUREZA_RADIONUCLIDICA,	
							e.PUREZA_QUIMICA, e.CODGERADOR,e.EFI_RESULTADO,e.LIMPIDA,e.PH,
							DATE_FORMAT(e.data, '%d/%c/%Y') as DATA1, e.LOTE, g.LOTE AS LOTEGERADOR			
				from 		eluicao e	
				join        gerador g on (e.CODGERADOR = g.CODGERADOR)			
				where 	   1 =1 
				and        g.CODINST  = $_SESSION[CODINST]
				$FF
				order by e.DATA desc
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
	 *  Pegando a quantidade e marcações gerado a partir da eluição
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 * 	@return int
	 */
	public function qtdMarcacaoGerador( $codeluicao, $codmarcacao = 0 ){
		try {
			$FF = "";
			if($codmarcacao  > 0){
				$FF .= " and CODMARCACAO  <> $codmarcacao  ";
			}
			$this->dados =  $this->query(
				" select count(*) as QTD from marcacao where CODELUICAO = $codeluicao $FF "
			);
			$this->dados = $this->dados->result_array();
			//se a quantidade for maior que zero não pode excluir
			return $this->dados[0]['QTD'];
			 
		} catch (Exception $e) {
			/*	Criando Log*/
			log_message('error', $this->db->error());
		}
		return 0;
	}

	/**
	 * 	Metodo para aumentar o contador de eluições
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function updateNroEluicao( $post ){
		try{
			$this->db->trans_begin();
			$this->db->query("update gerador g set  g.NRO_ELUICAO = (select count(*) from eluicao e  where e.CODGERADOR = 								g.CODGERADOR )
							where g.CODGERADOR =  $post[FFGERADOR]
								"
			);
			if( $this->db->trans_status() === false){
				$this->db->trans_rollback();				
			}			

			$this->db->trans_commit();
			return true;
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 *  verifica se a Eluicao pode ser Excluida
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 * 	@return bollean
	 */
	public function EluicaoPodeSerExcluido( $codeluicao ){
		try {
			$this->dados =  $this->query(
				" select count(*) as QTD from marcacao where CODELUICAO = $codeluicao "
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