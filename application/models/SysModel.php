<?php
/**	
 * 	Modelo com metodos de acesso ao banco do sistema
 * 
 **/ 
class SysModel extends MY_Model{
	
	/**	Contrutor do model
	 **/
	public function __construct() {
		parent::__construct();
	}
	

	/**
	 * 	Método para popula ção automática de selects 
	 *
	 *
	 * 	@return Void
	 */
	public function selectFill( $post ) {
		
		try {
			$param = ( $post['sfv'] ) ? $post['sfw'] : $post['sfwa'];
			$param = str_replace('{V}', $post['sfv'], $param );
			$this->dados = $this->query(
				"select 	$post[sfci], $post[sfcl]
				from 		$post[sft]
				$param
				order by 	2"
			);
			$this->dados = $this->dados->result_array();
			
		} catch (Exception $e) {
			log_message('error', $this->db->error());
		}
	}
}