<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * 	Modelo do Usuário
 * 
 *	@author Renato Roessler
 **/ 
class UsuarioModel extends MY_Model {


	public function __construct() {
		parent::__construct();
	}
	
    /**
	 * 	Metodo Index 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $url integer - inteiro com o código da conta
	 *
	 * 	@return array
	 */
	public function index( $post = null ) {

		try {
			
			$FF = '';
			if(isset($post['Instituicao'])) {
				$FF .= ( $post['Instituicao'] ) ? "and a.CODINST = $post[Instituicao] " : '';
			}
			if(isset($post['Login'])) {
				$FF .= ( $post['Login'] ) ? "and A.APELUSER like upper('%$post[Login]%') " : '';
			}
			if(isset($post['Nome'])) {
				$FF .= ( $post['Nome'])  ? "and A.NOME like upper('%$post[Nome]%') " : '';
			}
			$this->dados = $this->query(
				"select 	a.APELUSER, a.NOME,a.EMAIL	,A.CODINST, i.RAZAO	
				from 		usuario a
				left join    instituicao i on (a.codinst = i.codinst)
				where 		1=1
							$FF
				order by 	a.nome"
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
	 * 	Metodo para inserir um Usário
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return array
	 */
	public function inserir( $post ) {	
		try {			
			$this->db->trans_begin();
			$senha = md5($post['txt-senha']);			
			$this->db->query(
				"insert into usuario (apeluser,nome,email,codinst,senha	) values (upper('$post[FFAPELUSER]'),upper('$post[FFNOME]'),'$post[FFEMAIL]',$post[FFINSTITUICAO],'$senha')"
			);
			/*	Erro*/
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}
			/*	Pegando id*/
			//$id = $post['FFAPELUSER'];

			$this->db->trans_commit();
			//return $id[0]['codinst'];
			return true;
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para buscar um usuario 
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $apeluser string - string com o apeluser
	 *
	 * 	@return array
	 */
	public function buscaUsuario( $apeluser ) {

		try {
			
			$FF = '';
			
			$this->dados = $this->query(
				"select 	a.APELUSER, a.NOME,a.EMAIL,a.CODINST				
				from 		usuario a
				where 		a.APELUSER = '$apeluser'
				order by 	a.nome"
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
	 * 	Metodo para excluir um Usuário
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $Apeluser string - string com o código do usuário
	 *
	 * 	@return array
	 */
	public function excluir( $apeluser ) {

		try {
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"delete from usuario where apeluser = '$apeluser' "
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
	 * 	Metodo para atulizar um Usuario
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */

	public function atualizar( $post ) {
	
		try {			
			$this->db->trans_begin();
			/* update na conta corrente*/
			$this->db->query(
				"update 	usuario
				 set  APELUSER = upper('$post[FFAPELUSER]'),
				 	  NOME = upper('$post[FFNOME]'),
				 	  EMAIL = '$post[FFEMAIL]',
				 	  CODINST = $post[FFINSTITUICAO]

				where 		APELUSER = '$post[FFAPELUSER]'"
			);
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}

			$this->db->trans_commit();
			return true;
	
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}

	/**
	 * 	Metodo para atulizar a senha do Usuário
	 *
	 *	@author Renato Roessler <renatoroessler@gmail.com>
	 *	@param $post Array - array com dados do $_POST
	 *
	 * 	@return boolean
	 */
	public function atualizarSenha( $post ) {
	
		try {			
			$this->db->trans_begin();
			/* update na conta corrente*/
			$senha = md5($post['txt-senha']);
			$this->db->query(
				"update 	usuario
				 set  senha = '$senha'
				where 		APELUSER = '$post[FFAPELUSER]'"
			);
			if( $this->db->trans_status() === false ){
				$this->db->trans_rollback();
				return false;
			}

			$this->db->trans_commit();
			return true;
	
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
		return false;
	}
	/**
	 * Metodo para verificar se o usuario já está cadastrado
	 * @author Renato Roessler <renatoroessler@gmail.com>
	 * @param $apeluser = string 
	 * @param $codinst = integer (NÃO OBRIGATÓRIO) 
	 */
	public function usuarioJaCadastrado( $apeluser, $codinst = 0){
		try {
			
			$FF = '';
			
			if($codinst > 0){
				$FF = " and CODINST = $codinst";
			}			
			$this->dados = $this->query(
				"select count(*) as QTD from usuario where APELUSER = '$apeluser' $FF "
			);			
			$this->dados = $this->dados->result_array();
			//se a quantidade for maior que zero não pode excluir
			if ($this->dados[0]['QTD'] > 0 ){
				return true;
			}else{
				return false;
			}	
		} catch (Exception $e) {
			/* criando log  */
			log_message('error', $this->db->error()); 
		}
		return false;
	}
}
