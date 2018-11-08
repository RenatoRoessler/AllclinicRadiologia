<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Classe do Main para Controllers
 * 
 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
 *	@version 1.0 - 27 de mar de 2017 12:42:54
 **/ 
class MY_Controller extends CI_Controller{
	
	/**	Recebe nome do arquivo javascript default para ser carregado pelos views usados pelo controller
	 * 	@name $js
	 *	@access public
	 */
	public $js = array();
	
	/**	Recebe nome do arquivo css para ser carregado pelos views usados pelo controller
	 * 	@name $css
	 *	@access public
	 */
	public $css = array();
	
	/**	Json default para resposta
	 * 	@name $json
	 *	@access public
	 */
	public $json = array(
		'status' => false, /* status default */
		'message' => array('msg'=>'', 'tipo'=>'e'), /* mensagem ao usuário */
		'content' => '' /* conteudo do response */
	);

	/**	Array com controles que podem executar metodos
	 * 	@name $controle
	 *	@access protected
	 */
	protected $controle;

	/**	Array com controles que sao permitidos para todos
	 * 	@name $controlePermitido
	 *	@access protected
	 */
	protected $controlePermitido = array( 'Index', 'Erro', 'Login', 'Sys' );
	
	/**	Array com metodos que sao permitidos a todos
	 * 	@name $metodoPermitido
	 *	@access protected
	 */
	protected $metodoPermitido = array( 'index', 'logout', 'errorClean' );
	
	/**	Contrutor do controler
	 *	@author Douglas Comim <douglas.pinheiro@unimedpf.com.br> 11 de fev de 2016 16:30:45
	 *	@version 0.1 
	 **/
	public function __construct() {
		
		parent::__construct();
		
		/* Carregando configurações so sistema */
		//$this->config->load('sys_config');
		
		//	Pega controllers padrao
		//$this->controle[] = get_class($this);
		
		/* validando sessao */
		//$this->validaSessao();
		
		/* Valida controle acessado */
		//$this->validaControle();

		/*	Validando permissão do usuario*/
		//$this->validaPermissao();
	}
	
	/**
	 * 	Seta mensagem de sucesso
	 * 
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 27 de mar de 2017 14:11:27
	 * 	@return void
	 */
	public function msgSucesso( $msg, $content = '', $json = false, $echo = false, $tipo = 's' ) {
		
		if( $json ){
			$this->json = array(
				'status' => true,
				'content' => $content,
				'message' => array(
					'tipo' => $tipo,
					'msg' => $msg
				)
			);
			if( $echo ){
				echo jsonEncodeArray( $this->json );
			}
		}else{
			$this->session->set_userdata('MSG', array( $tipo, $msg ));
		}
	}

	/**
	 * 	Seta mensagem de falha
	 * 
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 27 de mar de 2017 14:11:27
	 * 	@return void
	 */
	public function msgFalha( $msg, $content = '', $json = false, $echo = false, $tipo = 'e' ) {
		
		if( $json ){
			$this->json = array(
				'status' => false,
				'content' => $content,
				'message' => array(
					'tipo' => $tipo,
					'msg' => $msg
				)
			);
			if( $echo ){
				echo jsonEncodeArray( $this->json );
			}
		}else{
			$this->session->set_userdata('MSG', array( $tipo, $msg ));
		}
	}

	/**
	 * 	Limpa dados da sessão
	 * 
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 27 de mar de 2017 14:11:27
	 * 	@return void
	 */
	public function limpaSessao() {
		
		/* Coloque dentro do array $reservado, os dados que você quer que permaneçam */
		$reservado = array();
		$sessao = $this->session->all_userdata();
		
		foreach( $sessao as $k => $v){
			if( !in_array( $k, $reservado ) ){
				$this->session->unset_userdata($k);
			}
		}
	}

	/**
	 * 	Salva dados da sessão
	 * 
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 27 de mar de 2017 14:11:27
	 * 	@return void
	 */
	public function filtroSessao( $dados ) {
		
		$filter = $this->session->filter;
		foreach ( $dados as $k => $v ) {
			if( substr( $k, 0, 2 ) == 'FF' ) {
				$filter[$k] = $v;
			}
		}
		return $filter;
	}
	
	/**
	 * 	Paginação das paginas
	 * 
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 27 de mar de 2017 14:11:27
	 * 	@param	$model objetc - Model por referência
	 * 	@return void
	 */
	public function paginar( &$model ) {
		
		if( !$model ){
			return false;
		}
		$this->load->library('classes/Paginacao');
		return $this->paginacao->paginar( $model->links , $model->pagina, $model->limite, $model->total );
	}
	
	/**
	 * 	Método para carregar views
	 * 
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 27 de mar de 2017 14:11:27
	 * 	@param	$view array - Array com a view a ser carregada e possiveis dados [ array( 'view'=> 'nomeDaView', 'info' => array('info1'=> 1, ...)) ]
	 * 	@return void
	 */
	public function loadView( $view, $hf = true ) {
		
		if(!$view || !is_array($view)){
			show_error('Parâmetro View não é válido', 503);
			exit();
		}
		
		if( SYS_ENV != 'PRODUCAO' ){
			$this->css[] = 'css/sys-homologacao.css';
		}

		$view['info']['TEMA'] = $this->session->tema;
		$view['info']['MENU'] = $this->session->menu;
		
		//	add JS e CSS para carregar na view
		$view['info']['CSS'] = $this->css;
		$view['info']['JS'] = $this->js;
		
		//	Adicionando mensagens da sessao na view
		$view['info']['MSG'] = $this->session->MSG;
		$view['info']['MSGB'] = $this->session->MSGB;
		$view['info']['MSGC'] = $this->session->MSGC;
		
		/* Header View Footer */
		if( $hf ){
			$this->load->view('_includes/_header.php', $view['info']);
		}
		$this->load->view( $view['view'], $view['info']);
		if( $hf ){
			$this->load->view('_includes/_footer.php', $view['info']);
		}
		
	}
	
	/**
	 * 	Valida controllers permitidos ao usuário
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 27 de mar de 2017 15:16:11
	 * 	@return true
	 */
	public function validaControle(){

		if ( !in_array( $this->uri->segment(2), $this->metodoPermitido ) && isVal( $this->uri->segment(1) ) && isVal( $this->uri->segment(2) ) ){
			if( !in_array( $this->uri->segment(1), $this->controle ) && !in_array( $this->uri->segment(1), $this->controlePermitido )){
				show_error("Access denied", 403);
				exit();
			}
		}
	}
	
	/**
	 * 	Método para validar permissoes
	 *
	 *	@author Douglas Comim <douglas.comim@gmail.com>
	 *	@version 0.0.1, 10 de jun de 2016 10:01:14
	 *	
	 *  @param $permissoes Array - Array com permissões a serem validados
	 *	@param $page String - URL de redirecionamento
	 *	@param $tipo Int - Tipo da validação, 1 obriga que todos os parâmetros sejam true, 0 apenas hum
	 *
	 * 	@return booblean
	 */
	public function validaPermissao( $page = null, $full = false ){
		
		/*	Se flag $full for marcada, testa Controle e Método*/
		if( $full ){
			$action = preg_replace( '/\/$/', '', '/' . $this->uri->segment(1) . '/' . $this->uri->segment(2) ); 
		}else{
			$action = preg_replace( '/\/$/', '', '/' . $this->uri->segment(1) ); 
		}

		log_message( 'debug', SYS_PREFIX . " Validando permissão de acesso --> [ Usuário: $_SESSION[idUsuario], Controle: $action, Full: " . (int) $full . " ]" );
		
		if( !in_array( $this->uri->segment(1), $this->config->item('sys_access_all') ) ){
			foreach( $this->session->acessos as $k => $v){
				if( strpos( $v[1], $action ) !== false ){
					return true;
				}
			}
			log_message( 'error', SYS_PREFIX . " !! ACESSO NEGADO !! --> [ Usuário: $_SESSION[idUsuario], Controle: $action ]" );

			$this->msgFalha( "ACESSO NEGADO [ $action ]", '', requestIsAjax() );
			redireciona( returnVariable( $page, '/' ) );
			exit();
		}
		return true;
	}
	
	/**
	 * 	Método para validar parametros
	 *
	 *	@author Douglas Comim <douglas.comim@gmail.com>
	 *	@version 0.0.1, 10 de jun de 2016 10:01:14
	 *
	 *	@param $parametros Array - Array com parêmetros a serem validados
	 *	@param $page String - URL de redirecionamento
	 *	@param $tipo Int - Tipo da validação, 1 obriga que todos os parâmetros sejam true, 0 apenas hum
	 *	@param $msg String - Mensagem personalizada
	 *
	 * 	@return booblean
	 */
	public function validaParametro( $parametros, $page = null, $tipo = 0, $msg = null, $json = false ){
		
		//	Verificação básica dos parametros
		if( ( !$parametros || !is_array( $parametros ) ) ){
			if( !$json ){
				//$this->session->set_userdata('MSG', array( 'e', 'Falha. [Param:failed]' ));
				$this->msgFalha( 'Falha. [Param:failed]', '', $json );
				redireciona( returnVariable( $page, $this->config->item('sys_parameters')[ $this->session->tipoUsuario ]['Index'] ));
				exit();
			}else{
				$this->msgFalha( 'Falha. [Param:failed]', '', $json );
				echo jsonEncodeArray( $this->json );
				exit();
			}
		}
		
		$flag = 0;
		//	validando
		foreach ( $parametros as $k => $v ){
			//	Validando parametro
			if( !isset( $v ) || (!isset( $v ) && $v != 0 ) ){
				$flag++;
			}
		}
		if( $tipo ){
			$flag = ( $flag == count($parametros) ) ? true : false;
		}
		if( $flag ){
			if( !$json ){
				//$this->session->set_userdata('MSG', array( 'e', 'Falha. [Param:failed]' ));
				$this->msgFalha( 'Falha, par&acirc;metro inv&aacute;lido.', '', $json );
				redireciona( returnVariable( $page, $this->config->item('sys_parameters')[ $this->session->tipoUsuario ]['Index'] ));
				exit();
			}else{
				$this->msgFalha( 'Falha, par&acirc;metro inv&aacute;lido.', '', $json );
				echo jsonEncodeArray( $this->json );
				exit();
			}
		}
		return true;
	}
	
	/**
	 * 	Método para validar entidades
	 *
	 *	@author Douglas Comim <douglas.comim@gmail.com>
	 *	@version 1.0 - 28 de abr de 2017 22:03:44
	 *
	 *	@param $modelo Object - Modelo para persistência no banco
	 *	@param $entidade String - Nome da tabela
	 *	@param $page String - URL para redirecionamento
	 *	@param $msg String - Mensagem personalizada
	 *
	 * 	@return booblean
	 */
	public function validaEntidade( $modelo, $entidade, $page = null, $msg = null, $json = false ){
		
		//	Verificação básica dos parametros
		if( !$modelo || ( !$entidade || !is_array( $entidade ) ) ){
			if( !$json ){
				$this->msgFalha( 'Falha. [Entity:failed]', '', $json );
				redireciona( returnVariable( $page, $this->input->server('HTTP_REFERER')));
				exit();
			}else{
				$this->msgFalha( 'Falha. [Entity:failed]', '', $json );
				echo jsonEncodeArray( $this->json );
				exit();
			}
		}
		
		//	Verificando se CST pode ser digitado
		$modelo->listarEntidade( $entidade[0], $entidade[1] );
		
		//	CST não encontrado
		if( count( $modelo->dados ) == 0 ){
			if( !$json ){
				$this->msgFalha( returnVariable( $msg, 'Registro n&atilde;o encontrado.' ), '', $json );
				redireciona( returnVariable( $page, $this->input->server('HTTP_REFERER')));
				exit();
			}else{
				$this->msgFalha( returnVariable( $msg, 'Registro n&atilde;o encontrado.' ), '', $json );
				echo jsonEncodeArray( $this->json );
				exit();
			}
		}
		return true;
	}
	
	/**
	 * 	Método para validar checks
	 *
	 *	@author Douglas Comim <douglas.comim@gmail.com>
	 *	@version 1.0 - 28 de abr de 2017 22:03:44
	 *
	 * 	@return booblean
	 */
	public function validaChecks( $info, $checks, $json = false ){
		
		foreach ( $checks as $k => $v ){
			if( $info[$v[0]] == $v[1] ){
				$this->msgFalha( $v[3], '', $json, false, $v[2] );
				return false;
			}
		}
		return true;
	}

	/**
	 * 	Valida sessão do usuário
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.0 - 29 de mar de 2017 17:10:44
	 * 	@return void
	 */
	public function validaSessao(){
	
		/* Log */
		log_message('debug', 
			SYS_PREFIX . ' Validando Sessao --> [ User:' . $this->session->idUsuario. 
			', Session:' . $this->session->idSessao .
			', IP:' . $this->input->server('REMOTE_ADDR') .
			', Request:' . $this->input->server('REQUEST_URI') . 
			' ]'
		);

		$access = ( 
			( $this->session->has_userdata('idSessao') ) ||
			( in_array( $this->uri->segment(1), array( 'Sys', 'Login', 'Index' ) ) )
		);
		
		//	validando sessao
		if( $access ) {
			
			/*	Buscando dados da sessao*/
			$this->load->model('LoginModel');
			$sessao = $this->LoginModel->verificaSessao( $this->session->idUsuario, $this->session->idSessao );

			/*	Não retornou sessao e não eh o controle de login*/
			if( !$sessao[0] && !in_array( $this->uri->segment(1), array( 'Login', 'Sys', 'Index' ) ) ){
				$this->destroiSessao( 'e', 'Sessão encerrada' );
			}

			/* Verificando se expira por tempo de inatividade*/
			if( $sessao[0]['TEMPO'] > $sessao[0]['SESSAO_EXP'] ){
				$this->destroiSessao( 'e', 'Sessão expirou por inatividade' );	
			}
			
			$this->LoginModel->atualizaSessao( $this->session->idUsuario, $this->session->idSessao );
			return true;
		}
		$this->destroiSessao();
	}
	
	/**
	 * 	Método que verifica se laudo está sendo editado por outro usuário
	 *
	 *	@author Douglas Comim <douglas.comim@gmail.com>
	 *	@version 1.3.16.5 - 22/08/2017
	 * 	@return void
	 */
	public function bls( $json = false ){

		$this->load->model( 'EditorModel' );
		
		/*	Se verdadeiro, está sendo editado por outra pessoa; falso laudo está liberado*/
		if( $this->EditorModel->bloqueioLaudoStatus( $this->uri->segment_array() ) ){
			/*	Testa se o usuário eh mesmo que bloqueou o registro*/
			$msg = 'Laudo <b>'. $this->EditorModel->dados[0]['CODLAUDO'] .'</b> está sendo acessado por <b>'. $this->EditorModel->dados[0]['NOME'] .'</b>.<br/>Por favor, tente novamente mais tarde.';
			if( $this->EditorModel->dados[0]['USERBLOQUEADO'] != $this->session->userdata('idUsuario') ){
				if( !$json ){
					$this->msgFalha( $msg, '', $json );
					redireciona( returnVariable( $page, $this->input->server('HTTP_REFERER') ) );
					exit();
				}else{
					$this->msgFalha( $msg, '', $json );
					echo jsonEncodeArray( $this->json );
					exit();
				}
			} 
		}
	}

	/**
	 * 	Método que bloqueia laudo para edição
	 *
	 *	@author Douglas Comim <douglas.comim@gmail.com>
	 *	@version 1.3.16.5 - 22/08/2017
	 * 	@return void
	 */
	public function bl(){

		/*	Carregando Modelo*/
		$this->load->model( 'EditorModel' );
		
		$this->validaEntidade( $this->EditorModel, array( 'atd_laudo', array(
			array( 'codlaudo =', $this->uri->segment(3))
		) ) );
		
		$this->EditorModel->bloqueioLaudo( $this->uri->segment_array() );

	}

	/**
	 * 	Método que libera laudo do bloqueio da edição
	 *
	 *	@author Douglas Comim <douglas.comim@gmail.com>
	 *	@version 1.3.16.5 - 22/08/2017
	 * 	@return void
	 */
	public function bll(){

		/*	Carregando Modelo*/
		$this->load->model( 'EditorModel' );
		$this->EditorModel->bloqueioLaudoLiberar( $this->uri->segment_array() );

	}

	/**
	 * 	Destroi a sessão do usuário
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@param char $t = Tipo da mensagem
	 *	@param string $m = Mensagem de erro
	 *
	 *	@version 1.0 - 29 de mar de 2017 17:10:44
	 * 	@return void
	 */
	public function destroiSessao( $t = null, $m = null){
		
		if( !$this->session->MSG[1] ){
			$message = array($t,$m);
		}
		$_SESSION = array();
		if( $message ){
			$this->session->set_userdata('MSG',$message);
		}
		if(  $this->uri->segment(1) != '' ){
			/* Log */
			log_message( 'debug', SYS_PREFIX . ' Destruindo sessão, redirecionando para /' );
			redireciona( '/' );
			exit();
		}
	}
	
	/**
	 * 	Carrega formularios
	 * 
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.3.19.1
	 * 	@return void
	 */
	public function carregaForm( $form, $dados ) {
		
		$content = '';

		ob_start();
		include VIEWPATH . "_includes/form/$form";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * 	Retorna codigo do controle presente nas permissões
	 * 
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.3.23.17 | 09.01.2018
	 *
	 *	@param String $controle 		| Regex Controle para procura
	 * 	@return Mixed
	 */
	public function retornaCodigoControleAcessos( $controle ) {
		foreach( $this->session->acessos as $k => $v ){
			if( preg_match( $controle , $v[1] ) ){
				return $v[0];
			}
		}
		return false;
	}

	/**
	 * 	Retorna botões de ação da tela
	 * 
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 *	@version 1.3.23.17 | 09.01.2018
	 *
	 *	@param 	Array $subcontroles 	| Array com dados dos subcontroles
	 *	@param 	Array $botoes 			| Array com botões permitidos, permite regras para validar valores
	 *				Ex.: $botoes['imprimir']['regra'][] = array( $teste, 2 ) // Habilita botão para imprimir se $teste for igual à 2
	 * 	@return String
	 */
	public function retornaBotoesAcesso( $subcontroles, $botoes ) {
		$btns = array();
		$i = 0;
		foreach( $subcontroles as $k => $v ) {
			$tp = explode( '/', $v['CONTROLE'] );
			if( $botoes[ $tp[2] ] ){
				$valid = true;
				foreach( $botoes[ $tp[2] ]['regra'] as $kk => $vv ) {
					if( $vv[0] != $vv[1] ){
						$valid = false;
						break;
					}
				}
				if( $valid ){
					$btns[ returnVariable( $v['INDICE'], $i++ ) ] = 
					"<div class='col-sm-1 col-xs-2'>
						<button class='btn sys-btn-action-base $v[CSS]' id='btn". ucwords( $tp[2] ) ."' 
							data-toggle='tooltip' data-placement='top' title='$v[LABEL]' ><i class='fa fa-$v[ICONE]'></i></button>
					</div>";
				}
			}
		}
		ksort( $btns );
		return implode( '', $btns );
	}

	/**
	 * 	Método para validar senha informada para o usuário
	 *
	 *	@author Douglas Comim <douglas.comim@gmail.com>
	 *	@version 1.0 - 13 de fev de 2017 21:38:10
	 *
	 *	@param String $senha 			| Senha 		 	
	 *	@param String $confirmaSenha 	| Confirmação da senha 		 	
	 * 	@return Mixed
	 */
	public function validaRequisitoSenhaUsuario( $senha, $confirmaSenha ){

		if( !$senha ){
			return 'Senha não informada.';
		}
		if( $senha != $confirmaSenha ){
			return 'Senhas informadas não são iguais.';
		}
		/*	Validanto complexidade da senha */
		if( !preg_match( '/'. $this->config->item('sys_password')['regex'] .'/', $senha ) ){
			return $this->config->item('sys_password')['label'];
		}
		return true;
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
	 * 	Metodo para upload de da assinatura
	 *
	 *	@author Douglas Comim - 03/02/2016 14:32:09
	 *	@param  $file 			| imagem 		 	
	 *	@param String $user 	| Apelido do usuario	
	 *	@version 0.1
	 * 	@return void
	 */
	public function assinaturaUpload($file, $user){
		
		$flag = false;
		
		if( $file ){

			$novoArquivo = SYS_TRASH . md5( 'sign' . $this->session->idUsuario . $user ) . '.png' ;
			
			if( move_uploaded_file( $file['tmp_name'], $novoArquivo ) ){
				
				if( file_exists( $novoArquivo ) ){
					if( $this->assinaturaRedimensiona( $novoArquivo ) ){
						return file_get_contents( $novoArquivo );
					}
				}				
			}			
		}
		
		return $flag;

	}

	/**
	 * 	Metodo para redimensionar da assinatura
	 *
	 *	@author Douglas Comim Pinheiro <douglas.comim@gmail.com>
	 * 	@return boolean
	 */
	private function assinaturaRedimensiona( $imagem ){
		
		//	Biblioteca de resize
		include FCPATH . '/assets/plugins/wideimage/WideImage.php';
		$sizeMain = 1024;
		
		list( $width, $height, $type, $attr ) = getimagesize( $imagem );
		$novaAltura = round(($height * (round(((100*$sizeMain)/$width) /100,2))),0);

		// Carrega a imagem a ser manipulada
		$img = WideImage::load( $imagem );
		// Redimensiona a imagem
		$img = $img->resize( $sizeMain , $novaAltura);
		// Salva a imagem em um arquivo (novo ou não)
		$img->saveToFile( $imagem );

		return true;
	}
}