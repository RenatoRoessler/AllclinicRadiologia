
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Farmaco');  ?>">Farmaco</a>  / Cadastros
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Farmaco/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODFARMACO1" name="FFCODFARMACO1" value="<?php echo $retorno[0]["CODFARMACO"]; ?>" >			
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnExcluirFarmaco" class="btn btn-danger btn-sm sys-btn-search" ><i class="fa fa-trash"></i> Excluir</button>
	      			</div>
	    			<ul class="nav nav-tabs col-sm-12 col-md-12 col-xs-12" role="tablist">
	    				<li role="presentation" class="active"><a href="#geral" aria-controls="geral" role="tab" data-toggle="tab">Geral</a></li>
					</ul>					
				</div>
				<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
				<div class="tab-content">
					<br/>
					<div role="tabpanel" class="tab-pane active" id="geral">
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFCODFARMACO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODFARMACO" name="FFCODFARMACO" value="<?php echo $retorno[0]["CODFARMACO"]; ?>"  readonly >
							</div>
                            <div class="form-group col-main col-sm-3 col-xs-12">
								<label for="FFDESCRICAO" class="sys-label col-sm-12 col-xs-12">Descricao:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFDESCRICAO" name="FFDESCRICAO" value="<?php echo $retorno[0]["DESCRICAO"]; ?>" 
								minlength="3" maxlength="30"  placeholder="Informe a Descricao"  autocomplete="off">
							</div>
                            <div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFPH" class="sys-label col-sm-12 col-xs-12">PH:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFPH" name="FFPH" value="<?php echo $retorno[0]["PH"] ? $retorno[0]["PH"] : 0 ;  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" >
							</div>
                            <div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFSOLVORGANICO" class="sys-label col-sm-12 col-xs-12">Solv. Orgânico:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFSOLVORGANICO" name="FFSOLVORGANICO" value="<?php echo $retorno[0]["SOLV_ORGANICO"] ? $retorno[0]["SOLV_ORGANICO"] : 0 ;  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" >
							</div>
                            <div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFSOLVINORGANICO" class="sys-label col-sm-12 col-xs-12">Solv. Inorgânico:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFSOLVINORGANICO" name="FFSOLVINORGANICO" value="<?php echo $retorno[0]["SOLV_INORGANICO"] ? $retorno[0]["SOLV_INORGANICO"] : 0 ;  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" >
							</div>	
                            <div class="col-main col-sm-1 col-xs-12">
								<label for="FFATIVO" class="sys-label col-sm-12 col-xs-12">Ativo:</label>
								<select class="form-control form-control-sm col-sm-12 col-xs-12 " id="FFATIVO" name="FFATIVO">
									<option <?php if( $retorno[0]["ATIVO"] == "S") echo "selected"; ?> value="S">Ativo</option>
									<option <?php if( $retorno[0]["ATIVO"] == "N") echo "selected"; ?> value="N">Inativo</option>
								</select>
							</div>				        		
						</div>
					</div>
				</div>
				
				<br/>
					<div class="col-xs-1 col-sm-1 pull-left">
		      			<button type="button" id="btnVoltar" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-chevron-left"></i> Voltar</button>
	      			</div>
				<div class="col-xs-12 col-md-12 col-sm-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnSalvar" class="btn btn-success btn-sm sys-btn-search" ><i class="fa fa-save"></i> Salvar</button>
	      			</div>
		    	</div>
			<?php 
            echo form_close();
            ?>

		</div>
	</div>


	<script type="text/javascript">
	    function somenteNumeros(num) {
	    	//campo.value.replace(',','.');
	        var er = /[^0-9.]/;
	        er.lastIndex = 0;
	        var campo = num;
	    	campo.value =  campo.value.replace(',','.');        
	        
	        if (er.test(campo.value)) {
	          campo.value = "";
	      	 }		 
   		}
	</script>






