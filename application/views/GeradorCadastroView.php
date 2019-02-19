
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
			<form id="formularioCadastro" name="formularioCadastro" action="<?php echo base_url() .'Gerador/atualizar' ?> " method="post" class="form-horizontal"   data-parsley-validate >

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
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFLOTE" name="FFLOTE" value="<?php echo $retorno[0]["LOTE"];  ?>"  autocomplete="off" required maxlength="11" >
							</div>	
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFDATAHORA" class="sys-label col-sm-12 col-xs-12">Data de Geração:</label>
								<input class="form-control" type="date" value="<?php echo $retorno[0]["DATA"] ?  $retorno[0]["DATA"] :  date ("Y-m-d")  ?>" id="FFDATAHORA" name="FFDATAHORA" required> 								
					        </div>		
					        <div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFNROELUICAO" class="sys-label col-sm-12 col-xs-12">Nro. Eluição:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFNROELUICAO" name="FFNROELUICAO" value="<?php echo $retorno[0]["NRO_ELUICAO"] ? $retorno[0]["NRO_ELUICAO"] : 0 ;  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" readonly>
							</div>	
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFDATACALIBRACAO" class="sys-label col-sm-12 col-xs-12">Data Calibração:</label>
								<input class="form-control" type="date" value="<?php echo $retorno[0]["DATA_CALIBRACAO"] ?  $retorno[0]["DATA_CALIBRACAO"] :  date ("Y-m-d")  ?>" id="FFDATACALIBRACAO" name="FFDATACALIBRACAO" required> 								
					        </div>
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFHORA" class="sys-label col-sm-12 col-xs-12">Hora Calibração:</label>
								<input class="col-sm-12 col-xs-12 form-control" type="time" value="<?php echo $retorno[0]['HORA'] ? $retorno[0]['HORA'] : date("H:i")  ?>" id="FFHORA" name="FFHORA" required >
							</div> 					        		
						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFUSUARIO" class="sys-label col-sm-12 col-xs-12">Usuário</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFUSUARIO" name="FFUSUARIO" value="<?php echo $_SESSION['APELUSER'] ?>"  readonly >
							</div>	
							<div class="form-group col-main col-sm- col-xs-12">
								<label for="FFATIVIDADECAL" class="sys-label col-sm-12 col-xs-12">Atividade Calibração mCi</label>
								<select class="form-control form-control-sm" id="FFATIVIDADECAL" name="FFATIVIDADECAL" required>
								<option <?php if( $retorno[0]["ATIVIDADE_CALIBRACAO"] == "") echo "selected"; ?> value="">Selecione a Atividade</option>
								<option <?php if( $retorno[0]["ATIVIDADE_CALIBRACAO"] == 2000) echo "selected"; ?> value="2000">2000</option>
								<option <?php if( $retorno[0]["ATIVIDADE_CALIBRACAO"] == 1500) echo "selected"; ?> value="1500">1500</option>
								<option <?php if( $retorno[0]["ATIVIDADE_CALIBRACAO"] == 1250) echo "selected"; ?> value="1250">1250</option>
								<option <?php if( $retorno[0]["ATIVIDADE_CALIBRACAO"] == 1000) echo "selected"; ?> value="1000">1000</option>
								<option <?php if( $retorno[0]["ATIVIDADE_CALIBRACAO"] == 750) echo "selected"; ?> value="750">750</option>
								<option <?php if( $retorno[0]["ATIVIDADE_CALIBRACAO"] == 500) echo "selected"; ?> value="500">500</option>
								<option <?php if( $retorno[0]["ATIVIDADE_CALIBRACAO"] == 250) echo "selected"; ?> value="250">250</option>
																	
								</select>

								<!--<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADECAL" name="FFATIVIDADECAL" value="<?php echo $retorno[0]["ATIVIDADE_CALIBRACAO"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off"  required>
								-->
							</div>	
							<div class="form-group col-main col-sm- col-xs-12">
								<label for="FFATIVIDADEMO99" class="sys-label col-sm-12 col-xs-12">Atividade <SUP>99</SUP>Mo:</label>		
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADEMO99" name="FFATIVIDADEMO99" value="<?php echo $retorno[0]["ATIVIDADEMO99"];  ?>" readonly>	
							</div>			
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFFABRICANTE" class="sys-label col-sm-12 col-xs-12">Fabricante:</label>	
								<select class="form-control form-control-sm" id="FFFABRICANTE" name="FFFABRICANTE" data-live-search="true" required>
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







