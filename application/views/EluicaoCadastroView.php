
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

			<form id="formularioCadastro" name="formularioCadastro" action="<?php echo base_url() .'Eluicao/atualizar' ?> " method="post" class="form-horizontal"   data-parsley-validate >
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
								<select class="form-control form-control-sm" id="FFGERADOR" name="FFGERADOR" data-live-search="true" required  <?php if($retorno[0]["CODELUICAO"]) echo 'disabled'  ?> >
								<option <?php if( $retorno[0]["CODGERADOR"] == "") echo "selected"; ?> value="">Selecione o Gerador</option>
								<?php
									foreach ($gerador as $k => $v) {
									$sel = ($v["CODGERADOR"] == $retorno[0]["CODGERADOR"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODGERADOR'];?>" <?php echo $sel; ?> > <?php echo 'Lote: ' .$v["LOTE"] . '  /Calibração: ' .$v["DATACALIBRACAO"]; ?> </option>
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
								<label for="FFDATAHORA" class="sys-label col-sm-12 col-xs-12">Data :</label>
								<input class="form-control" type="date" value="<?php echo $retorno[0]["DATA"] ?  $retorno[0]["DATA"] :  date ("Y-m-d")  ?>" id="FFDATAHORA" name="FFDATAHORA" required  >  								
					        </div>						       
					        <div class="col-main col-sm-1 col-xs-12">
       							<label  for="FFHORA" class="sys-label col-sm-12 col-xs-12">Hora:</label>
        						<input class="col-sm-12 col-xs-12 form-control" type="time" id="FFHORA" name="FFHORA" min="00:00" max="24:00" required value="<?php echo $retorno[0]['HORA'] ? $retorno[0]['HORA'] : date("H:i")  ?>" />
    						</div>
    						 <div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFVOLUME" class="sys-label col-sm-12 col-xs-12">Volume(ml) :</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFVOLUME" name="FFVOLUME" value="<?php echo $retorno[0]["VOLUME"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" placeholder="Volume em ml" required />
							</div>
							 <div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFATIVIDADE_MCI" class="sys-label col-sm-12 col-xs-12">Atividade mCi:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADE_MCI" name="FFATIVIDADE_MCI" value="<?php echo $retorno[0]["ATIVIDADE_MCI"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" required />
							</div>	
							<div class="col-main col-sm-1 col-xs-12">
								<label for="FFCQ" class="sys-label col-sm-12 col-xs-12">C.Q:</label>
								<select class="form-control form-control-sm col-sm-12 col-xs-12" id="FFCQ" name="FFCQ" onchange="mostraDiv()">
									<option <?php if( $retorno[0]["CQ"] == "S") echo "selected"; ?> value="S">Sim</option>
									<option <?php if( $retorno[0]["CQ"] == "N") echo "selected"; ?> value="N">Não</option>
								</select>
							</div>							
						</div>	

						<div class="row col-sm-12 col-xs-12" style="visibility: hidden;" id="CQ">
							<div class="row col-sm-2 col-xs-12"><!-- eficiencia da eluicao -->
								<div class="form-group col-main col-sm-12 col-xs-12">			
									<div class="card">
									  	<div class="card-header">
									    	Eficiência da Eluição
									  	</div>									  	
									  	<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFATIVIDADETEORICA" class="sys-label col-sm-12 col-xs-12">Atividade Teórica:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADETEORICA" name="FFATIVIDADETEORICA" value="<?php echo $retorno[0]["EFI_ATV_TEORICA"];  ?>" readonly />
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFATIVIDADE_MEDIDA" class="sys-label col-sm-12 col-xs-12">Medida:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADE_MEDIDA" name="FFATIVIDADE_MEDIDA" value="<?php echo $retorno[0]["EFI_ATV_MEDIDA"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" />
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFRESULTADO" class="sys-label col-sm-12 col-xs-12">Resultado(%):</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFRESULTADO" name="FFRESULTADO" value="<?php echo $retorno[0]["EFI_RESULTADO"];  ?>" readonly />
										</div>
									</div>
								</div>
							</div><!-- eficiencia da eluicao -->

							<div class="row col-sm-2 col-xs-12"><!-- Pureza Radioquímica -->
								<div class="form-group col-main col-sm-12 col-xs-12">			
									<div class="card">
									  	<div class="card-header">
										  Pureza Radioquímica
									  	</div>							  	
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFSUPERIOR" class="sys-label col-sm-12 col-xs-12">Parte Superior: </label>
											<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFSUPERIOR" name="FFSUPERIOR" value="<?php echo $retorno[0]["SUPERIOR"] ; ?>"  autocomplete="off"  min="0" max="999.99" step="0.01" />		
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFINFERIOR" class="sys-label col-sm-12 col-xs-12">Parte Inferior: </label>
											<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFINFERIOR" name="FFINFERIOR" value="<?php echo $retorno[0]["INFERIOR"] ; ?>"  autocomplete="off"  min="0" max="999.99" step="0.01" />		
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFRADIOQUIMICA" class="sys-label col-sm-12 col-xs-12">Resultado:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFRADIOQUIMICA" name="FFRADIOQUIMICA" value="<?php echo $retorno[0]["PUREZA_RADIOQUIMICA"];  ?>" readonly />
										</div>
									</div>
								</div>
							</div><!-- Pureza Radionuclídica -->
							<div class="row col-sm-2 col-xs-12"><!-- Pureza Radionuclídica -->
								<div class="form-group col-main col-sm-12 col-xs-12">			
									<div class="card">
									  	<div class="card-header">
										  Pureza Radionuclídica
									  	</div>							  	
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFATV" class="sys-label col-sm-12 col-xs-12">Atividade de <SUP>99</SUP>Mo: </label>
											<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFATV" name="FFATV" value="<?php echo $retorno[0]["ATV"] ; ?>" step="0.01"  autocomplete="off"  min="0" max="999.99" />		
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFATVTECNEZIO" class="sys-label col-sm-12 col-xs-12">Atividade de <SUP>99m</SUP>Tc: </label>
											<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFATVTECNEZIO" name="FFATVTECNEZIO" value="<?php echo $retorno[0]["ATVTECNEZIO"] ; ?>"  autocomplete="off"  min="0" max="999.99" step="0.01" />		
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFATVFUNDO" class="sys-label col-sm-12 col-xs-12">Atividade de fundo de <SUP>99</SUP>Mo: </label>
											<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFATVFUNDO" name="FFATVFUNDO" value="<?php echo $retorno[0]["ATVFUNDO"] ; ?>"  autocomplete="off"  min="0" max="999.99" step="0.01" />		
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFRADIONUCLIDICA" class="sys-label col-sm-12 col-xs-12">Resultado:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFRADIONUCLIDICA" name="FFRADIONUCLIDICA" value="<?php echo $retorno[0]["PUREZA_RADIONUCLIDICA"];  ?>" readonly />
										</div>
									</div>
								</div>
							</div><!-- Pureza Radionuclídica -->						
							<div class="row col-sm-2 col-xs-12"><!-- OUTROS -->
								<div class="form-group col-main col-sm-12 col-xs-12">						
									<div class="card">
									  	<div class="card-header">
									    	outros
									  	</div>
									  	<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFPH" class="sys-label col-sm-12 col-xs-12">PH:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFPH" name="FFPH" value="<?php echo $retorno[0]["PH"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFLIMPIDA" class="sys-label col-sm-12 col-xs-12">Limpida</label>
											<select class="form-control form-control-sm col-sm-12 col-xs-12 " id="FFLIMPIDA" name="FFLIMPIDA">
												<option <?php if( $retorno[0]["LIMPIDA"] == "N") echo "selected"; ?> value="N">Não</option>
												<option <?php if( $retorno[0]["LIMPIDA"] == "S") echo "selected"; ?> value="S">Sim</option>
											</select>
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
			</form>

		</div>
	</div>

		<script type="text/javascript">


   		function mostraDiv()
		{
			var e = document.getElementById("FFCQ");
			var itemSelecionado = e.options[e.selectedIndex].value;
			if(itemSelecionado != 'S'){
				document.getElementById('CQ').style.visibility = "hidden"; 
				
			}else{
				document.getElementById('CQ').style.visibility = "visible"; 
				
			}
			return false;  
		}
		mostraDiv();


	</script>




