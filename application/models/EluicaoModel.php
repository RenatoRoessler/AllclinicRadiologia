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
				$FF .= ( $post['FFDATAPESQUISA'] ) ? "and e.DATA = '$data' " : '';
			}
			if(isset($post['FFATIVOFILTRO'])) {
				$FF .= ( $post['FFATIVOFILTRO'] ) ? "and e.ATIVO = $post[FFATIVOFILTRO] " : '';
			}
			$this->dados = $this->query(
				"select 	e.CODELUICAO,e.DATA,e.HORA, e.VOLUME, e.ATIVIDADE_MCI,e.ATIVO, e.CQ,
							e.EFI_ATV_TEORICA, e.EFI_ATV_MEDIDA, e.EFI_VOLUME, e.PUREZA_RADIONUCLIDICA,	
							e.PUREZA_QUIMICA, e.CODGERADOR,e.EFI_RESULTADO,e.LIMPIDA, e.LOTE,
							DATE_FORMAT(e.DATA, '%d/%c/%Y') as DATA1
				from 		Eluicao e
				where 		1=1
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
			$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATAHORA'])));  

			$this->db->trans_begin();
			$this->db->query("insert into ELUICAO(
								DATA,
								HORA,
								VOLUME,
								ATIVIDADE_MCI,
								ATIVO,
								CQ,
								EFI_ATV_TEORICA,
								EFI_ATV_MEDIDA,
								EFI_RESULTADO,
								PUREZA_RADIONUCLIDICA,
								PUREZA_QUIMICA,
								LIMPIDA,
								CODGERADOR,
								LOTE
								) value 
								('$data',
								'$post[FFHORA]',
								$post[FFVOLUME],
								$post[FFATIVIDADE_MCI],
								'$post[FFATIVO]',
								'$post[FFCQ]',
								$post[FFATIVIDADETEORICA],
								$post[FFATIVIDADE_MEDIDA],
								$post[FFRESULTADO],
								$post[FFPUREZA_RADIONUCLIDICA],
								'$post[FFPUREZA_QUIMICA]',
								'$post[FFLIMPIDA]',
								$post[FFGERADOR],
								$post[FFLOTE]
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
			$data = date("Y-m-d",strtotime(str_replace('/','-',$_POST['FFDATAHORA'])));  
			$this->db->trans_begin();
			$this->db->query(" update eluicao set 
								DATA ='$data', 
								HORA = '$post[FFHORA]',
								VOLUME = $post[FFVOLUME],
								ATIVIDADE_MCI = $post[FFATIVIDADE_MCI],
								ATIVO = '$post[FFATIVO]',
								CQ = '$post[FFCQ]',
								EFI_ATV_TEORICA = $post[FFATIVIDADETEORICA],
								EFI_ATV_MEDIDA = $post[FFATIVIDADE_MEDIDA],
								EFI_RESULTADO = $post[FFRESULTADO],
								PUREZA_RADIONUCLIDICA = $post[FFPUREZA_RADIONUCLIDICA],
								PUREZA_QUIMICA = '$post[FFPUREZA_QUIMICA]',
								LIMPIDA = '$post[FFLIMPIDA]',
								CODGERADOR = $post[FFGERADOR],
								LOTE = 	$post[FFLOTE]						
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
							DATE_FORMAT(e.data, '%d/%c/%Y') as DATA1, e.LOTE			
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
	public function buscaEluicoesAtivas( ) {

		try {			
			$this->dados = $this->query(
				"select 	e.CODELUICAO,e.DATA,e.HORA, e.VOLUME, e.ATIVIDADE_MCI,e.ATIVO, e.CQ,
							e.EFI_ATV_TEORICA, e.EFI_ATV_MEDIDA, e.EFI_VOLUME, e.PUREZA_RADIONUCLIDICA,	
							e.PUREZA_QUIMICA, e.CODGERADOR,e.EFI_RESULTADO,e.LIMPIDA,e.PH,
							DATE_FORMAT(e.data, '%d/%c/%Y') as DATA1, e.LOTE			
				from 		eluicao e				
				where 		e.ATIVO = 'S'
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