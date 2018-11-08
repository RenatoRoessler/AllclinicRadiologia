
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Gerador');  ?>">Gerador</a>  / Cadastros
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Gerador/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODGERADOR1" name="FFCODGERADOR1" value="<?php echo $retorno[0]["CODGERADOR"]; ?>" >			
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
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
								<label for="FFCODGERADOR" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODGERADOR" name="FFCODGERADOR" value="<?php echo $retorno[0]["CODGERADOR"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFLOTE" class="sys-label col-sm-12 col-xs-12">Lote:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFLOTE" name="FFLOTE" value="<?php echo $retorno[0]["LOTE"];  ?>"  autocomplete="off">
							</div>					
					        <div class="form-group col-main col-sm-2 col-xs-12">
					        	<label for="FFDATAHORA" class="sys-label col-sm-12 col-xs-12">Data:</label>
					            <div class='input-group date' >
					                <input type='text' class="form-control" id='FFDATAHORA' name="FFDATAHORA" value="<?php echo $retorno[0]["DATAF"];  ?>"  autocomplete="off"/>
					                <span class="input-group-addon">
					                      <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					        </div>
					        <div class="col-main col-sm-1 col-xs-12">
       							<label  for="FFHORA" class="sys-label col-sm-12 col-xs-12">Hora:</label>
        						<input class="col-sm-12 col-xs-12 form-control" type="time" id="FFHORA" name="FFHORA" min="00:00" max="24:00" required value="<?php echo $retorno[0]["HORA"];  ?>" />
    						</div>
					        <div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFNROELUICAO" class="sys-label col-sm-12 col-xs-12">Nro. Eluição:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFNROELUICAO" name="FFNROELUICAO" value="<?php echo $retorno[0]["NRO_ELUICAO"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
							</div>	
							<div class="form-group col-main col-sm-2 col-xs-12">
					        	<label for="FFDATACALIBRACAO" class="sys-label col-sm-12 col-xs-12">Data Calibração:</label>
					            <div class='input-group date' >
					                <input type='text' class="form-control" id="FFDATACALIBRACAO" name="FFDATACALIBRACAO" value="<?php echo $retorno[0]["DATA_CALIBRACAOF"];  ?>" autocomplete="off"/>
					                <span class="input-group-addon">
					                      <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					        </div>					        		
						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFUSUARIO" class="sys-label col-sm-12 col-xs-12">Usuário</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFUSUARIO" name="FFUSUARIO" value="<?php echo $_SESSION['APELUSER'] ?>"  readonly >
							</div>	
							<div class="form-group col-main col-sm- col-xs-12">
								<label for="FFATIVIDADECAL" class="sys-label col-sm-12 col-xs-12">Atividade de Calibração:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADECAL" name="FFATIVIDADECAL" value="<?php echo $retorno[0]["ATIVIDADE_CALIBRACAO"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
							</div>							
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFFABRICANTE" class="sys-label col-sm-12 col-xs-12">Fabricante:</label>	
								<select class="form-control form-control-sm" id="FFFABRICANTE" name="FFFABRICANTE" data-live-search="true">
								<option <?php if( $fabricante[0]["CODFABRICANTE"] == "") echo "selected"; ?> value="">Selecione o Fabricante</option>
								<?php
									foreach ($fabricante as $k => $v) {
									$sel = ($v["CODFABRICANTE"] == $retorno[0]["CODFABRICANTE"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODFABRICANTE'];?>" <?php echo $sel; ?> > <?php echo $v["DESCRICAO"]; ?> </option>
									<?php  
										}
									?>
									
								</select>
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
        var er = /[^0-9.]/;
        er.lastIndex = 0;
        var campo = num;
        if (er.test(campo.value)) {
          campo.value = "";
      	 }
   		}
	</script>






