<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Classe do Main para Models
 * 
 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
 *	@version 1.0 - 27 de mar de 2017 12:42:54
 **/ 
class MY_Model extends CI_Model{
	
	/**	Utilizado para paginação
	 * 	@name $paginar
	 *	@access	public
	 */
	public $paginar = null;

	/**	Página atual
	 * 	@name $pagina
	 *	@access	public
	 */
	public $pagina = 0;

	/**	Total de páginas
	 * 	@name $total
	 *	@access	public
	 */
	public $total = 0;
	
	/**	Define limite de registros para paginação
	 * 	@name $limite
	 *	@access	public
	 */
	public $limite = 15;
	
	/**	Numero de links para paginacao
	 * 	@name $links
	 *	@access public
	 */
	public $links = 4;
	
	/**	Recebe dados resultantes da pesquisa
	 * 	@name $dados
	 *	@access	public
	 */
	public $dados;
	
	/**	Contrutor do model
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 27 de mar de 2017 17:43:57
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 	Metodo que prepara query para execução
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.3.18.11 - 25/08/2017
	 *	@param String $query - Stringo com a query	
	 *	@param Integer $exec - Indica se a query será retornada ou se apenas o sql  
	 *	@param Integer $pagina - Pagina 
	 * 	@return Mixed
	 */
	public function query( $query, $exec = true, $pagina = null ){
		
		if( isVal( $this->paginar ) && preg_match( "/select/i", $query ) ){
				
			$qtmp = explode('{{}}', $query );
			$queryCount = "select count(*) as QTE_LINHAS_SQLDEV " . $qtmp[1] ;
				
			/* executando query que retorna quantidade de itens */
			$resultado = $this->db->query( $queryCount );
				
			//	Verificando se deu erro
			if( !$resultado ){
				// Gerando Log
				log_message( 'error', $this->db->error());
				return false;
			}else{
				//	Resetando n�mero da p�gina se controle � diferente
				$ctrl = $this->uri->segment(1);
				if( $this->session->controle != $ctrl ){
					$this->session->set_userdata('controle',$ctrl);
					$this->session->set_userdata('pagina',0);
				}
				//	Adicionando limite
				//	Verificando se p�gina foi passada
				$this->pagina = returnVariable( $pagina, $this->input->post('pagina'), $this->session->pagina, 1 );
				$this->pagina = limpaVariavel( $this->pagina );
				//	Query para paginar corretamente
				$query =
					"SELECT * FROM
						(
							SELECT a.*, rownum r__
							FROM
								(
									$query
								) a
							WHERE rownum < (($this->pagina * $this->limite) + 1 )
						)
					WHERE r__ >= ((($this->pagina-1) * $this->limite) + 1)";
				$row = $resultado->row();
				$this->total = returnVariable( $row->QTE_LINHAS_SQLDEV, 0 );
			}
				
			//	Excluido marcacoes da páginação
			$query = str_replace( '{{}}', '', $query );
		}
		
		//	Verificando se paginacao existe e se a query eh um select
		if( isVal( $this->paginar ) && preg_match( "/select/i", $query ) ){
			$this->session->set_userdata('pagina', $this->pagina);
		}
		
		/* Executando a query */
		if( !$exec ){
			return $query;
		}
		return $this->db->query( $query );
	}
	
	/**
	 * 	Metodo que pega o ultimo id inserido
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.3.15.3 - 10/08/2017
	 *	@param String $tabela - Tabela para retornar id	
	 *	@param String $seq - Sequencia	
	 * 	@return Integer
	 */
	public function retornaID( $tabela, $seq ){
		$id = $this->db->query("select $seq.CURRVAL from $tabela where ROWNUM = 1");
		return $id->result_array();
	}

	/**
	 * 	Metodo para listar usuarios e instituições relacionadas
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 13 de fev de 2017 20:04:49
	 * 	
	 * 	@param	$inst
	 * 		- Código da instituíção
	 * 	@param	$usuario
	 * 		- Código do usuario
	 * 
	 *	@return void
	 */
	public function listarUsuarioInstituicao( $inst = null, $usuario = null ){
		
		if( !$inst && !$usuario ){
			return false;
		}
		try {
			$webusuario = ( $usuario ) ? " and u.usuario = '". limpaVariavel($usuario) ."' " : "" ;
			$usuario = ( $usuario ) ? " and u.apeluser = '". limpaVariavel($usuario) ."' " : "" ;
			$inst = ( $inst ) ? " and i.codinst = ". limpaVariavel($inst) : "" ;
			
			//	Query para pegar dados
			$dados = $this->db->query(
				"select		i.codinst, i.fantasia
				from		Usuario u 
							inner join Userinst ui on ( ui.apeluser = u.apeluser $usuario )
							inner join Instituicao i on ( i.codinst = ui.codinst $inst 
								and i.ativo = 'S'
							)
				union
				select 		i.codinst, i.fantasia
				from 		web_usuario u 
							inner join web_usuarioinst ui on ( ui.usuario = u.usuario $webusuario )
							inner join instituicao i on ( i.codinst = ui.instituicao $inst
								 and i.ativo = 'S'
							)
				order by	2" 
			);
			$this->dados = $dados->result_array();
		} catch (Exception $e) {
			log_message('error', $this->db->error() );
		}
	}
	
	/**
	 * 	Metodo para listar entidade
	 *
	 *	@author Douglas Comim - 01.07.2016 14:34
	 *	@version 0.1
	 *
	 * 	@param	String $tabela		| Nome da Tabela
	 * 	@param	Array $param 		| Array com parametros diversos
	 * 	@param	String $orderby 	| Order by por
	 * 	@param	Boolean $scape 		| Define se array sera filtrado
	 *
	 * 	@return array com dados do grupo
	 */
	public function listarEntidade( $tabela, $where = null, $orderby = null, $scape = true ){
	
		try {
			
			$w = '';
			foreach ( $where as $k => $v ){
				$temp = implode( ' ', $v );
				if( $scape ){
					$w .= ' and ' . limpaVariavel( $temp );
				}else{
					$w .= ' and ' . implode( ' ', $v );
				}
			}
			$order = ( $orderby ) ? 'order by ' . $orderby : null;
			
			$dados = $this->db->query(
				"select		*
				from		$tabela
				where		1=1
							$w 
				$order "
			);
			//	Retornando dados
			$this->dados = $dados->result_array();
	
		} catch (Exception $e) {
			//	Criando Log
			log_message('error', $this->db->error() );
		}
	}
	
	/**
	 * 	Metodo para listar setores
	 *
	 *	@author Douglas Comim - 01.07.2016 14:34
	 *	@version 0.1
	 *
	 * 	@return array com dados do setores
	 */
	public function listarSetor( $cod = null ){
		
		try {
			
			$cod = ( $cod ) ? " and s.codsetor = $cod " : "";
			
			$dados = $this->db->query(
				"select s.codsetor, s.descricao
				 from 	setor s
				where 	s.codsetor in (
							select 	e.codsetor
					        from 	planogrp p,  exame e
					        where  	p.codgex   = e.codgex
						)
						". limpaVariavel($cod) ."
				order by s.descricao"
			);
			//	Retornando dados
			$this->dados = $dados->result_array();
			
		} catch (Exception $e) {
			//	Criando Log
			log_message('error', $this->db->error() );
		}
		
	}
	
	/**
	 * 	Metodo para listar usuários web ativos
	 *
	 *	@author	Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 * 	@param 	Array $param | Array de parametros
	 *
	 *	@version 1.3.23.11 | 05.11.2017
	 * 	@return void
	 */
	public function listarWebUsuario( $param ){
		
		try {
			
			/*	Buscando por id*/
			$sql .= ( $param['usuario'] ) ? " and u.usuario = '$param[usuario]' " : '';
			$sql .= ( $param['tipo'] ) ? " and u.tipo in ( $param[tipo] )" : '';
			
			/*	Testando vigencia*/
			if( $param['vigente'] === true ){
				$sql .=  'and u.iniciovigencia <= sysdate and ( u.fimvigencia is null or u.fimvigencia > sysdate )' ;
			}else if( $param['vigente'] === false ){
				$sql .= 'and u.iniciovigencia > sysdate or ( u.fimvigencia <= sysdate )';
			}
			
			$dados = $this->db->query(
				"select 	*
				 from 		web_usuario u
				where 		1=1
							$sql
				order by 	u.nome"
			);
			$this->dados = $dados->result_array();
			
		} catch (Exception $e) {
			log_message('error', $this->db->error() );
		}
		
	}
	
	/**
	 * 	Metodo para listar usuários ativos
	 *
	 *	@author	Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 * 	@param 	Array $param | Array de parametros
	 *
	 *	@version 1.3.23.11 | 05.11.2017
	 * 	@return void
	 */
	public function listarUsuario( $param ){
		
		try {
			
			$dados = $this->db->query(
				"select 	u.*, f.nome as funcao
				from 		usuario u
							inner join funcao f on ( f.codfunc = u.codfunc 
								and U.status = 'A'
								and U.apeluser <> 'ADMDATA'
							)
				order by 	u.nome"
			);
			$this->dados = $dados->result_array();
			
		} catch (Exception $e) {
			log_message('error', $this->db->error() );
		}
		
	}

	/**
	 * 	Metodo para listar entidade
	 *
	 *	@author Douglas Comim - 01.07.2016 14:34
	 *	@version 0.1
	 *
	 * 	@param	$tabela		String	Nome da Tabela
	 * 	@param	$param		Array 	Array com parametros diversos
	 * 	@param	$orderby	String	Order by por
	 * 	@param	$field		Array	Campos desejados
	 * 
	 * 	@return array com dados do grupo
	 */
	public function listarInfoFooter( $cod){
	
		try {
	
			/* Pega info */
			$this->dados = $this->db->query(
				"select  	al.codlaudo as INFOCODLAUDO, conv.nome as INFOCONVENIO, ge.descricao as INFOGRUPO,
					        so.nome as INFOSOLICITANTE,
					        concat( al.digitadora, concat(' - ', ud.nome))  as INFODIGITADOR, to_char( al.datadig, 'DD/MM/YYYY HH24:MI' ) as INFODIGITADOEM, 
					        concat( al.alterlaudo, concat(' - ', ua.nome)) as INFOALTERADOPOR,
					        concat( al.userenvelop, concat(' - ', ue.nome)) as INFOENVELOPADOPOR, to_char( al.dtenvelope, 'DD/MM/YYYY HH24:MI' ) as INFOENVELOPADOEM,
					        concat( al.apeldigitar, concat(' - ', urd.nome)) as INFORECEBEUPARADIGITAR, to_char( al.dtdigitar, 'DD/MM/YYYY HH24:MI' ) as INFORECEBEUPARADIGITAREM,
					        concat( al.userentrega, concat(' - ', uep.nome)) as INFOENTREGUEPOR, to_char( al.dataentrega, 'DD/MM/YYYY HH24:MI' ) as INFOENTREGUEEM,
					        concat( con.atendente, concat(' - ', uat.nome)) as INFOATENDIDOPOR,
					        concat( al.user_prontoparaentrega, concat(' - ', upe.nome)) as INFOPRONTOPARAENTREGARPOR,
					        e.nome as INFOEXAME,
					        rea.nome as INFOREALIZADOPOR,
					        concat( al.user_liberou, concat(' - ', ul.nome)) as INFOLIBERADOPOR,
					        ag.descricao as INFOAGENDA, p.nome as INFOPACIENTE, 
					        con.codcst as INFOCONSULTA,
					        ass.nome as INFOASSINADOPOR,  to_char( al.dtassinado, 'DD/MM/YYYY HH24:MI' ) as INFOASSINADOEM,
					        rev.nome as INFOREVISADOPOR,  to_char( al.dtrevisalaudo, 'DD/MM/YYYY HH24:MI' ) as INFOREVISADOEM,
					        ax.usuario as INFOLAUDOPDFUS, to_char( ax.data, 'DD/MM/YYYY HH24:MI' ) as INFOLAUDOPDFDT,
					        al.obs as observacao
				from 		atd_laudo al
					        inner join atdpedexa ped on (al.codlaudo = ped.codlaudo
								and al.codlaudo = ". limpaVariavel($cod[3]) ."
							)
					        inner join atdpedido pedido on (ped.codatdped = pedido.codatdped)
					        inner join atendimento a on (pedido.codatdo = a.codatdo)
					        inner join consulta con    on (a.codatdo = con.codatdo
								and con.cbrcst is null
							)
					        inner join convenio conv on (con.codconv = conv.codconv)
					        inner join atdsin        on (al.codatdsin = atdsin.codatdsin)
					        inner join exame e       on (atdsin.codexa = e.codexa)
					        inner join grpexame ge   on ( ge.codgex = e.codgex )
					        inner join solicitante so on ( so.codsol = con.codsol )
					        inner join paciente p on ( p.prontuario = con.prontuario )
					        left join usuario ud on ( ud.apeluser = al.digitadora )
					        left join usuario ua on ( ua.apeluser = al.alterlaudo )
					        left join usuario ue on ( ue.apeluser = al.userenvelop )
					        left join usuario urd on ( urd.apeluser = al.apeldigitar )
					        left join usuario uep on ( uep.apeluser = al.entregue )
					        left join usuario uat on ( uat.apeluser = con.atendente )
					        left join usuario upe on ( upe.apeluser = al.user_prontoparaentrega )
					        left join usuario uen on ( uen.apeluser = al.userentrega )
					        left join usuario ul on ( ul.apeluser = al.user_liberou )
					        left join realizante rea on ( rea.codrea = al.codrea )
					        left join setor ag on ( ag.codsetor = ped.codsetor )
					        left join realizante ass on ( ass.codrea = al.assinado )
					        left join realizante rev on ( rev.codrea = al.revisalaudo )
					        left join atd_laudo_anexo ax on ( ax.codlaudo = al.codlaudo and ax.tipo = 'L' )"
			);
	
			$this->dados = $this->dados->result_array();
	
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
	}
	
	/**
	 * 	Update em registros de uma talea
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 29 de mar de 2017 22:43:40
	 * 	@param	$tabela	String
	 * 			- Nome da Tabela para ipdate
	 * 	@param 	$dados	array
	 * 			- Dados Ex.: array( 'campo' => 'dado' );
	 * 	@param 	$where	array
	 * 			- Parametros ex.: array( array( "campo", "=", "dado" ) );
	 * 	@param	$admin Boolean
	 * 			- Flag que diz se teste de permiss�o sobre usu�rio admin deve ser realizada
	 * 	@return void
	 */
	public function updateCLOB( $tabela, $campo, $valor, $where){
	
		//	Tentando execu��o
		try {
			//	Formando query sql de inser��o
			$sql =
				"update 	$tabela
				set 		$campo = EMPTY_CLOB() ";
			$sql2 = " returning $campo into :temp";
				
			$w = " where";
			// La�o para montar Update
			foreach ( $where as $k => $v ){
				//$w .= " $v[0] $v[1] " . isNull( $v[2] ) ." and";
				if( strtolower($v[1]) == "in" ){
					$w .= " {$v[0]} {$v[1]} ". $v[2] ." and";
				}else{
					$w .= " {$v[0]} {$v[1]} ". $v[2] ." and";
				}
			}
			$w = substr( $w, 0, -4 );
	
			//	SQL de update completo
			$sql = $sql . $w . $sql2;
				
			$query = oci_parse( $this->db->conn_id, $sql );
				
			$lob = oci_new_descriptor( $this->db->conn_id, OCI_D_LOB );
			oci_bind_by_name( $query, ':temp', $lob, -1, OCI_B_CLOB);
				
			log_message('debug', SYS_PREFIX . 'SQL [[ ' . preg_replace( '/  +/', ' ', preg_replace('/([\r\n\t]|(\s){2,})/', ' ', $sql ) ) . ' ]]');

			if( oci_execute( $query, OCI_DEFAULT ) ){
				$lob->save( $valor );
				return $lob;
			}else{
				 log_message('error', oci_error( $this->db->conn_id ) );
				return false;
			}
		} catch ( Exception $e ) {
			//	Criando log
			log_message('error', oci_error( $this->db->conn_id ));
		}
	}

	/**
	 * 	Update em registros de uma talea
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 29 de mar de 2017 22:43:40
	 * 	@param	$tabela	String
	 * 			- Nome da Tabela para ipdate
	 * 	@param 	$dados	array
	 * 			- Dados Ex.: array( 'campo' => 'dado' );
	 * 	@param 	$where	array
	 * 			- Parametros ex.: array( array( "campo", "=", "dado" ) );
	 * 	@param	$admin Boolean
	 * 			- Flag que diz se teste de permiss�o sobre usu�rio admin deve ser realizada
	 * 	@return void
	 */
	public function updateBLOB( $tabela, $campo, $valor, $where){
	
		//	Tentando execu��o
		try {
			//	Formando query sql de inser��o
			$sql =
				"update 	$tabela
				set 		$campo = EMPTY_BLOB() ";
			$sql2 = " returning $campo into :temp";
				
			$w = " where";
			// La�o para montar Update
			foreach ( $where as $k => $v ){
				//$w .= " $v[0] $v[1] " . isNull( $v[2] ) ." and";
				if( strtolower($v[1]) == "in" ){
					$w .= " {$v[0]} {$v[1]} ". $v[2] ." and";
				}else{
					$w .= " {$v[0]} {$v[1]} ". $v[2] ." and";
				}
			}
			$w = substr( $w, 0, -4 );
	
			//	SQL de update completo
			$sql = $sql . $w . $sql2;
				
			$query = oci_parse( $this->db->conn_id, $sql );
				
			$lob = oci_new_descriptor( $this->db->conn_id, OCI_D_LOB );
			oci_bind_by_name( $query, ':temp', $lob, -1, OCI_B_BLOB);
				
			log_message('debug', SYS_PREFIX . 'SQL [[ ' . preg_replace( '/  +/', ' ', preg_replace('/([\r\n\t]|(\s){2,})/', ' ', $sql ) ) . ' ]]');

			if( oci_execute( $query, OCI_DEFAULT ) ){
				$lob->save( $valor );
				return $lob;
			}else{
				 log_message('error', oci_error( $this->db->conn_id ) );
				return false;
			}
		} catch ( Exception $e ) {
			//	Criando log
			log_message('error', oci_error( $this->db->conn_id ));
		}
	}
	
	/**
	 * 	Divide a que string clob caso necessário
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 26 de mai de 2017 22:33:25
	 * 	
	 * 	@param	$string	String - String para ser validada
	 * 	
	 * 	@return String
	 */
	public function prepareCLOB( $string ){
		
		$tam = 3999;
		$len = strlen($string);
		
		if( $len > $tam ){
			$parts = ceil( $len / $tam );
			
			$ctrl = 0;
			$tstring = '';
			for( $i=0; $i < $parts; $i++ ){
				$tstring .= "to_clob('" . substr($string, $ctrl, $tam )."') || ";
				$ctrl += $tam;
			}
			$string = substr( $tstring, 0, -4 );
		}else{
			$string = "'$string'";
		}
		return "$string";
	}

	/**
	 * 	Metodo para realizar a copia do conteúdo do laudoh para laudor
	 * 	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@param Integer $codlaudo - Código do laudo
	 */
	public function copiaLaudoHLaudoR( $codlaudo ){
		
		if( !$codlaudo ){
			return false;
		}
		try {
			
			//	Carregando library do editor
			if( !class_exists('EditorHtml') ){
				$this->load->library('classes/EditorHTML', array( $_SESSION['idSessao'] ) );
			}

			//	Buscando laudoh
			$this->dados = $this->db->query("select length(laudor) as tamlaudor, laudoh, laudor from atd_laudo where codlaudo = $codlaudo");
			if( $this->db->trans_status() === false ){
				return false;
			}
			$dados = $this->dados->result_array();
			$dados = $dados[0];

			$this->db->trans_begin();

			//	Verificando tamanho do laudor
			if( $dados['TAMLAUDOR'] ){
				//	Pegando dados do laudo
				if( $dados['LAUDOR'] ){
					$dados['LAUDOR'] = $dados['LAUDOR']->load() ;
				}
				//	Atualizando LAUDOC
				//	Atualizando Laudo Clob
				$lob = $this->updateCLOB('atd_laudo', 'laudoc', $dados['LAUDOR'], array(
					array( 'codlaudo', '=', $codlaudo ),
				));
				if( $this->db->trans_status() === false ){
					$this->db->trans_rollback();
					return false;
				}
			}

			//	Pegando dados do laudo
			if( $dados['LAUDOH'] ){
				$dados['LAUDOH'] = $this->editorhtml->ajustaHTMLPrintOut( $this->editorhtml->ajustaHTMLOut( $dados['LAUDOH']->load() ) );
			}

			//	Atualizando Laudo Clob
			$lob = $this->updateCLOB('atd_laudo', 'laudor', strip_tags( $dados['LAUDOH'] ), array(
				array( 'codlaudo', '=', $codlaudo ),
			));
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}
			$this->db->trans_commit();
			return true;

		} catch (Exception $e) {
			//	Criando Log
			log_message('error', $this->db->error());
		}
	}

	/**
	 * 
	 */
	public function rastreamento( $codlaudo , $usuario ){
		try {
			
			$this->db->query("  insert into rastreamento (CODRAST,prontuario,codcst,operacao,obs,apeluser,data)
					(SELECT seq_rastreamento.nextval,C.PRONTUARIO,C.CODCST,'E','Deletado Laudo','$usuario',SYSDATE
					FROM ATD_LAUDO AL
					INNER JOIN ATDPEDEXA AE ON (AL.CODLAUDO = AE.CODLAUDO)
					INNER JOIN ATDPEDIDO AP ON(AE.CODATDPED = AP.CODATDPED)
					INNER JOIN ATENDIMENTO ATDO ON (AP.CODATDO = ATDO.CODATDO)
					INNER JOIN CONSULTA  C   ON (ATDO.CODATDO = C.CODATDO)
					WHERE AL.CODLAUDO = ". limpaVariavel($codlaudo) .")
					");
			
		} catch (Exception $e) {
			//	Criando Log
			log_message('error', $this->db->error());
		}
	}

	/**
	 * 	Metodo que pega o ultimo o max de uma coluna no mysql
	 *
	 *	@author renato roessler <renatoroessler@gmail.com>
	 *	@param String $tabela - Tabela para retornar id	
	 *	@param String $coluna - coluna	
	 * 	@return Integer
	 */
	public function retornaMaxColuna( $tabela, $coluna ){
		$id = $this->db->query("select coalesce( max( $coluna ), 0) as $coluna from $tabela ");
		return $id->result_array();
	}
}