
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Eluicao');  ?>">Manutenção Eluição </a> / Eluicao
					<br/>
				</li>
			</ol>
			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Eluicao/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODELUICAO1" name="FFCODELUICAO1" value="<?php echo $retorno[0]["CODELUICAO"]; ?>" >
			
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnExcluirEluicao" class="btn btn-danger btn-sm sys-btn-search" ><i class="fa fa-trash"></i> Excluir</button>
	      			</div>
	    			<ul class="nav nav-tabs col-sm-12 col-md-12 col-xs-12" role="tablist">
	    				<li role="presentation" class="active"><a href="#geral" aria-controls="geral" role="tab" data-toggle="tab">Geral</a></li>
					</ul>
				</div>
				<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;' ></div>
				<div class="tab-content">
					<br/>
					<div role="tabpanel" class="tab-pane active" id="geral">
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFCODELUICAO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODELUICAO" name="FFCODELUICAO" value="<?php echo $retorno[0]["CODELUICAO"]; ?>"  readonly >
							</div>
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFGERADOR" class="sys-label col-sm-12 col-xs-12">Gerador:</label>	
								<select class="form-control form-control-sm" id="FFGERADOR" name="FFGERADOR" data-live-search="true">
								<option <?php if( $retorno[0]["CODGERADOR"] == "") echo "selected"; ?> value="">Selecione o Gerador</option>
								<?php
									foreach ($gerador as $k => $v) {
									$sel = ($v["CODGERADOR"] == $retorno[0]["CODGERADOR"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODGERADOR'];?>" <?php echo $sel; ?> > <?php echo 'Lote: ' .$v["LOTE"] . '  /Data: ' .$v["DATA1"]; ?> </option>
									<?php  
										}
									?>									
								</select>
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFLOTE" class="sys-label col-sm-12 col-xs-12">Lote</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFLOTE" name="FFLOTE" value="<?php echo $retorno[0]["LOTE"];  ?>"  autocomplete="off"  readonly>
							</div>
							<div class="form-group col-main col-sm-2 col-xs-12">
					        	<label for="FFDATAHORA" class="sys-label col-sm-12 col-xs-12">Data:</label>
					            <div class='input-group date' >
					                <input type='text' class="form-control" id='FFDATAHORA' name="FFDATAHORA" value="<?php echo $retorno[0]["DATA1"] ?  $retorno[0]["DATA1"] :  date ("d/m/Y")  ?>"  autocomplete="off"/>
					                <span class="input-group-addon">
					                      <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					        </div>					       
					        <div class="col-main col-sm-1 col-xs-12">
       							<label  for="FFHORA" class="sys-label col-sm-12 col-xs-12">Hora:</label>
        						<input class="col-sm-12 col-xs-12 form-control" type="time" id="FFHORA" name="FFHORA" min="00:00" max="24:00" required value="<?php echo $retorno[0]['HORA'] ? $retorno[0]['HORA'] : date("H:i")  ?>" />
    						</div>
    						 <div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFVOLUME" class="sys-label col-sm-12 col-xs-12">Volume mCi:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFVOLUME" name="FFVOLUME" value="<?php echo $retorno[0]["VOLUME"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
							</div>
							 <div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFATIVIDADE_MCI" class="sys-label col-sm-12 col-xs-12">Atividade mCi:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADE_MCI" name="FFATIVIDADE_MCI" value="<?php echo $retorno[0]["ATIVIDADE_MCI"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
							</div>	
							<div class="col-main col-sm-1 col-xs-12">
								<label for="FFCQ" class="sys-label col-sm-12 col-xs-12">C.Q:</label>
								<select class="form-control form-control-sm col-sm-12 col-xs-12" id="FFCQ" name="FFCQ" onchange="mostraDiv()">
									<option <?php if( $retorno[0]["CQ"] == "N") echo "selected"; ?> value="N">Não</option>
									<option <?php if( $retorno[0]["CQ"] == "S") echo "selected"; ?> value="S">Sim</option>
								</select>
							</div>							
						</div>	
						<div class="row col-sm-12 col-xs-12" style="visibility: hidden;" id="EFICIENCIA">
							<div class="row col-sm-3 col-xs-12">	
								<div class="form-group col-main col-sm-12 col-xs-12">			
									<div class="card">
									  	<div class="card-header">
									    	Eficiência da Eluição
									  	</div>									  	
									  	<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFATIVIDADETEORICA" class="sys-label col-sm-12 col-xs-12">Atividade Teórica:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADETEORICA" name="FFATIVIDADETEORICA" value="<?php echo $retorno[0]["EFI_ATV_TEORICA"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFATIVIDADE_MEDIDA" class="sys-label col-sm-12 col-xs-12">Medida:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADE_MEDIDA" name="FFATIVIDADE_MEDIDA" value="<?php echo $retorno[0]["EFI_ATV_MEDIDA"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFRESULTADO" class="sys-label col-sm-12 col-xs-12">Resultado:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFRESULTADO" name="FFRESULTADO" value="<?php echo $retorno[0]["EFI_RESULTADO"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
										</div>
									</div>
								</div>
							</div>
							<div class="row col-sm-3 col-xs-12" style="visibility: hidden;" id="PUREZA">	
								<div class="form-group col-main col-sm-12 col-xs-12">					
									<div class="card">
									  	<div class="card-header">
									    	Pureza
									  	</div>
									  	<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFPUREZA_RADIONUCLIDICA" class="sys-label col-sm-12 col-xs-12">Radionuclidica:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFPUREZA_RADIONUCLIDICA" name="FFPUREZA_RADIONUCLIDICA" value="<?php echo $retorno[0]["PUREZA_RADIONUCLIDICA"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFPUREZA_QUIMICA" class="sys-label col-sm-12 col-xs-12">Radioquimica:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFPUREZA_QUIMICA" name="FFPUREZA_QUIMICA" value="<?php echo $retorno[0]["PUREZA_QUIMICA"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFLIMPIDA" class="sys-label col-sm-12 col-xs-12">Limpida</label>
											<select class="form-control form-control-sm col-sm-12 col-xs-12 " id="FFLIMPIDA" name="FFLIMPIDA">
												<option <?php if( $retorno[0]["LIMPIDA"] == "N") echo "selected"; ?> value="N">Não</option>
												<option <?php if( $retorno[0]["LIMPIDA"] == "S") echo "selected"; ?> value="S">Sim</option>									
											</select>
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFPUREZA_QUIMICA" class="sys-label col-sm-12 col-xs-12">Pureza Quimica</label>
											<select class="form-control form-control-sm col-sm-12 col-xs-12 " id="FFPUREZA_QUIMICA" name="FFPUREZA_QUIMICA">
												<option <?php if( $retorno[0]["PUREZA_QUIMICA"] == "N") echo "selected"; ?> value="N">Não</option>
												<option <?php if( $retorno[0]["PUREZA_QUIMICA"] == "S") echo "selected"; ?> value="S">Sim</option>						
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row col-sm-3 col-xs-12" style="visibility: hidden;" id="PH">	
								<div class="form-group col-main col-sm-12 col-xs-12">					
									<div class="card">
									  	<div class="card-header">
									    	PH
									  	</div>
									  	<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFPH" class="sys-label col-sm-12 col-xs-12">PH:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFPH" name="FFPH" value="<?php echo $retorno[0]["PH"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
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

   		function mostraDiv()
		{
			var e = document.getElementById("FFCQ");
			var itemSelecionado = e.options[e.selectedIndex].value;
			if(itemSelecionado != 'S'){
				document.getElementById('PUREZA').style.visibility = "hidden"; 
				document.getElementById('EFICIENCIA').style.visibility = "hidden"; 
				document.getElementById('PH').style.visibility = "hidden"; 
			}else{
				document.getElementById('PUREZA').style.visibility = "visible"; 
				document.getElementById('EFICIENCIA').style.visibility = "visible"
				document.getElementById('PH').style.visibility = "visible"
			}
			return false;  
		}
		mostraDiv();


	</script>




