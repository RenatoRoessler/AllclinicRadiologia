
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Fracionamento');  ?>">Fracionamento</a>  / Fracionar
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Fracionamento/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODFRACIONAMENTO1" name="FFCODFRACIONAMENTO1" value="<?php echo $retorno[0]["CODFRACIONAMENTO"]; ?>" >	
            	<input type="hidden" class="col-sm-12 col-xs-12 form-control" id="FFPRONTUARIO" name="FFPRONTUARIO" value="" >		
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
								<label for="FFCODFRACIONAMENTO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODFRACIONAMENTO" name="FFCODFRACIONAMENTO" value="<?php echo $retorno[0]["CODFRACIONAMENTO"]; ?>"  readonly >
							</div>
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFMARCACAO" class="sys-label col-sm-12 col-xs-12">Marcação:</label>	
								<select class="form-control form-control-sm" id="FFMARCACAO" name="FFMARCACAO" data-live-search="true">
								<option <?php if( $retorno[0]["CODMARCACAO"] == "") echo "selected"; ?> value="">Selecione o Gerador</option>
								<?php
									foreach ($marcacao as $k => $v) {
									$sel = ($v["CODMARCACAO"] == $retorno[0]["CODMARCACAO"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODMARCACAO'];?>" <?php echo $sel; ?> > <?php echo $v["KIT_LOTE"]; ?> </option>
									<?php  
										}
									?>									
								</select>
							</div>	
						</div>
						<div class="row col-sm-12 col-xs-12">
							<!--
							<div class="col-main col-sm-3 col-xs-12">
								<label for="FFPRONTUARIO" class="sys-label col-sm-12 col-xs-12">Paciete:</label>	
								<select class="form-control form-control-sm" id="FFPRONTUARIO" name="FFPRONTUARIO" data-live-search="true">
								<option  value="">Selecione o Paciente</option>
								<?php
									foreach ($paciente as $k => $v) {
								?>
									<option value="<?php echo $v['PRONTUARIO'];?>" > <?php echo $v["NOME"]; ?> </option>
									<?php  
										}
									?>									
								</select>
							</div>
						-->
					
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFNOMEPAC" class="sys-label col-sm-12 col-xs-12">Paciente:</label>
								<div class="input-group mb-3">
								  <input type="text" class="form-control" placeholder="Nome do Paciente" aria-label="Nome do Paciente" aria-describedby="basic-addon2" id="FFNOMEPAC" readonly>
								  <div class="input-group-append">
								    <button class="btn btn-outline-secondary fa fa-search"  id="btnTeste" type="button" >Pesquisar</button>
								  </div>
								</div>								
							</div>

							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFATIVIDADE" class="sys-label col-sm-12 col-xs-12">Atividade:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADE" name="FFATIVIDADE" value="" onkeyup="somenteNumeros(this);">
							</div>
							<div class="col-xs-2 col-sm-2 pull-right">
								<label for="btnAdicionar" class="sys-label col-sm-12 col-xs-12">&nbsp; </label>
				      			<button type="button" id="btnAdicionar" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-plus"></i> Adicionar Paciente</button>
			      			</div>									
						</div>
						<div class="row col-sm-12 col-xs-12">	
							<div class="col-md-12">
								<div class="panel-group" >	
									<div class="panel panel-default">
									
								    	<div class="panel-body table-responsive">
								    		<table id="tableIndex" class="table table-middle table-condensed table-hover table-borderless table-striped table-bordered" style="width:100% !important;">
								    			<thead>
								    				<tr>
						    							<th>Nome</th>
						    							<th>CPF</th>
						    							<th>Atividade</th>
						    							<th>Administrar</th>
						    							<th>Excluir</th>
						    						</tr>
						    					</thead>
						    					<tbody>
						    						<?php 
						    						if($pacientesAdicionados){
								    				foreach ($pacientesAdicionados as $k => $v) {  			
								    				?>
								    				<tr id="<?php echo $v['CODITFRACIONAMENTO']; ?>">
								    					<td><?php echo $v['NOME']; ?></td>
								    					<td><?php echo $v['CPF']; ?></td>
								    					<td><?php echo $v['ATIVIDADE']; ?></td>
								    					<td width="10"> 
								    						<a href=<?php echo base_url() .'/Fracionamento/administrarIndex/'. $v['CODITFRACIONAMENTO']  ?> > 
								    							<i class="fa fa-stethoscope fa-lg"></i>
								    						</a>
								    					</td>
								    					<td width="10"> 
								    						<a href=<?php echo base_url() .'/Fracionamento/excluirItem/'. $v['CODITFRACIONAMENTO']  ?> > 
								    							<i class="fa fa-minus-circle fa-lg" style="color:red;"></i> 
								    						</a>
								    					</td>
								    				</tr>
								    			<?php } } ?>
								    			</tbody>
						    				</table>
						    			</div>
						    		</div>
						    	</div>
						    </div>
						</div>			
					</div>
				</div>
				<br/>
					<div class="col-xs-1 col-sm-1 pull-left">
		      			<button type="button" id="btnVoltar" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-chevron-left"></i> Voltar</button>
	      			</div>
				<div class="col-xs-12 col-md-12 col-sm-12">
					<div class="col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSalvar" class="btn btn-success btn-sm sys-btn-search" ><i class="fa fa-save"></i> Confirmar</button>
	      			</div>
		    	</div>
			<?php 
            echo form_close();
            ?>

		</div>
	</div>

	<?php include VIEWPATH . "_includes/_pesquisaPaciente.php"; ?>
	

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






