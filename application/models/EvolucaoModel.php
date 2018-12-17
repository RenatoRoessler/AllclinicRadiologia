<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Evolução
 * 
 *	@author Renato Roessler
 **/ 
class EvolucaoModel extends MY_Model {


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
				$FF .= ( $post['FFDATAPESQUISA'] ) ? "and m.DATA >= '$data' " : '';
			}
			if(isset($post['FFDATAFINALPESQUISA'])) {
				$data = date("Y-m-d",strtotime(str_replace('/','-',$post['FFDATAFINALPESQUISA']))); 
				$FF .= ( $post['FFDATAFINALPESQUISA'] ) ? "and m.DATA <= '$data' " : '';
			}
			$this->dados = $this->query(
				"select 	i.CODITFRACIONAMENTO, 
							g.LOTE as LOTEGERADOR,  
							e.LOTE AS LOTEELUICAO,
							DATE_FORMAT(g.DATA, '%d/%c/%Y') as DATAGERADOR, 
							m.LOTE as LOTEMARCACAO,
							DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATAMARCACAO,
							p.NOME,
							i.ATIVIDADE_INICIAL,
							i.HORA_INICIAL,
							i.ATIVIDADE_ADMINISTRADA,
							i.HORA_ADMINISTRADA,
							e.PUREZA_RADIONUCLIDICA,
							e.LIMPIDA,
							e.PH,
							e.PUREZA_QUIMICA,
							g.APELUSER,
							f.DESCRICAO as KITFABRICANTE,
							fa.DESCRICAO as DFARMACO,
							m.KIT_LOTE,
							m.ORGANICO,
							m.QUIMICO,
							m.APELUSER as USEMARCACAO

				from 	    ITFRACIONAMENTO i
				join        MARCACAO m on (i.CODMARCACAO = m.CODMARCACAO)
				join        ELUICAO e on (m.CODELUICAO = e.CODELUICAO)
				join        GERADOR g on (e.CODGERADOR = g.CODGERADOR)
				join        AGTOEXAME ae on (i.CODAGTOEXA = ae.CODAGTOEXA)
				join        AGENDAMENTO ag on (ae.CODAGTO = ag.CODAGTO)
				join        PACIENTE p on (ag.PRONTUARIO = p.PRONTUARIO)
				join        FABRICANTE f on (m.KIT_CODFABRICANTE = f.CODFABRICANTE)
				join        FARMACO    fa on (m.CODFARMACO = fa.CODFARMACO)
				
				where 		1=1
				and         g.CODINST = $_SESSION[CODINST]
							$FF
				order by 	i.CODITFRACIONAMENTO desc"
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