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
			$this->dados = $this->query(
				"select 	i.CODFRACIONAMENTO, g.LOTE as LOTEGERADOR, g.CODGERADOR, m.CODMARCACAO,
							DATE_FORMAT(g.DATA, '%d/%c/%Y') as DATAGERADOR,
							DATE_FORMAT(m.DATA, '%d/%c/%Y') as DATAMARCACAO, p.NOME as PACIENTE,
							i.ATIVIDADE, i.HORAINICIO, i.ATV_ADMINISTRADA, i.HORA_ADMINISTRADA,
							e.LOTE as LOTEELUICAO, e.PUREZA_RADIONUCLIDICA, e.LIMPIDA,
							e.PH, e.PUREZA_QUIMICA, g.APELUSER, m.KIT_CODFABRICANTE,
							m.KIT_CODRADIOFARMACO, m.KIT_LOTE, m.NCI_CODFABRICANTE,
							m.NACI_LOTE, ffkitfabricante.DESCRICAO as D_KIT_FABRICANTE,
							ffkitfarmaco.DESCRICAO as D_KIT_FARMACO, 
							naci.DESCRICAO as NACI_DESCRICAO, m.ORGANICO, m.QUIMICO,
							m.APELUSER as USERMARCACAO

				from 	    ITEMFRACIONAMENTO i
				join        FRACIONAMENTO f on (i.CODFRACIONAMENTO = f.CODFRACIONAMENTO)
				join        MARCACAO m on (f.CODMARCACAO = m.CODMARCACAO)
				join        ELUICAO e on (m.CODELUICAO = e.CODELUICAO)
				join        GERADOR g on (e.CODGERADOR = g.CODGERADOR)
				join        PACIENTE p on (i.PRONTUARIO = p.PRONTUARIO)
				left join   FABRICANTE ffkitfabricante on (m.KIT_CODFABRICANTE = ffkitfabricante.CODFABRICANTE)
				left join   FABRICANTE ffkitfarmaco on (m.KIT_CODRADIOFARMACO = ffkitfarmaco.CODFABRICANTE)
				left join   FABRICANTE naci on (m.NCI_CODFABRICANTE = naci.CODFABRICANTE)
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