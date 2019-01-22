
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('AgendamentoView');  ?>">Agendamento</a> / Agendar
					<br/>
				</li>
			</ol>
			<?php include VIEWPATH . "_includes/_mensagem.php";?> 
		
			<form id="formularioCadastro" name="formularioCadastro" action="<?php echo base_url() .'Agendamento/atualizar' ?> " method="post" class="form-horizontal"   data-parsley-validate >	
            	<input type="hidden" id="FFCODAGTO1" name="FFCODAGTO1" value="<?php echo $retorno[0]["CODAGTO"]; ?>" >
					
				<input type="hidden" class="col-sm-12 col-xs-12 form-control" id="FFPROCEDIMENTO" name="FFPROCEDIMENTO" value= "<?php echo $retorno[0]['CODPROCEDIMENTO'] ?>" >
					
				
				<div class="divisor" >
					CADASTRO 
				</div>
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnExcluirAgendamento" class="btn btn-danger btn-sm sys-btn-search" ><i class="fa fa-trash"></i> Excluir</button>
	      			</div>
				</div>	
				<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;' ></div>
				<div class="tab-content">
					<br/>
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFCODAGTO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODAGTO" name="FFCODAGTO" value="<?php echo $retorno[0]["CODAGTO"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFDATAHORA" class="sys-label col-sm-12 col-xs-12">Date</label>
								<input class="form-control" type="date" value="<?php echo $retorno[0]["DATA"] ?  $retorno[0]["DATA"] :  date ("Y-m-d")  ?>" id="FFDATAHORA" name="FFDATAHORA" required> 								
					        </div>
							<div class="col-main col-sm-1 col-xs-12">
								<label for="FFHORA" class="sys-label col-sm-12 col-xs-12">Hora:</label>
								<input class="col-sm-12 col-xs-12 form-control" type="time" value="<?php echo $retorno[0]['HORA'] ? $retorno[0]['HORA'] : date("H:i")  ?>" id="FFHORA" name="FFHORA" required >
							</div> 							
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFNOMEPAC" class="sys-label col-sm-12 col-xs-12">Nome Paciente:</label>
								<div class="input-group mb-3">
								  <input type="text" class="form-control" placeholder="Nome do Paciente" aria-label="Nome do Paciente" aria-describedby="basic-addon2" id="FFNOMEPAC" name="FFNOMEPAC" value= "<?php echo $retorno[0]['NOME'] ?>" autocomplete="off"  required min="3" max="99">
								</div>								
							</div>
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFSOBRENOMEPAC" class="sys-label col-sm-12 col-xs-12">Sobrenome Paciente:</label>
								<div class="input-group mb-3">
								  <input type="text" class="form-control" placeholder="Sobrenome do Paciente" aria-label="Sobrenome do Paciente" aria-describedby="basic-addon2" id="FFSOBRENOMEPAC" name="FFSOBRENOMEPAC" value= "<?php echo $retorno[0]['SOBRENOME'] ?>" autocomplete="off" required min="3" max="99"> 
								</div>								
							</div>							
						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFCPF" class="sys-label col-sm-12 col-xs-12">CPF:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCPF" name="FFCPF" value="<?php echo $retorno[0]["CPF"]; ?>" 
								minlength="0" maxlength="15" placeholder="CPF.: 000.000.000-00" autocomplete="off" required>
							</div>								
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFDATANASCIMENTO" class="sys-label col-sm-12 col-xs-12">Date</label>
								<input class="form-control" type="date" value="<?php echo $retorno[0]["NASCIMENTO"]   ?>" id="FFDATANASCIMENTO" name="FFDATANASCIMENTO" required> 								
					        </div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFPESO" class="sys-label col-sm-12 col-xs-12">Peso(Kg):</label>
								<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFPESO" name="FFPESO" value="<?php echo $retorno[0]["PESO"]; ?>" 
								 placeholder="Peso.: 000.000" min="0" max="299.999" step="any"  >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFALTURA" class="sys-label col-sm-12 col-xs-12 ">Altura (m):</label>
								<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFALTURA" name="FFALTURA" value="<?php echo $retorno[0]["ALTURA"]; ?>" 
								 placeholder="Altura.: 0.000" min="0" max="2.99" step="any">
							</div>							
							<div class="col-main col-sm-4 col-xs-12">
								<label for="FFCONVENIO" class="sys-label col-sm-12 col-xs-12">Convênio:</label>	
								<select class="form-control selectpicker" id="FFCONVENIO" name="FFCONVENIO" data-live-search="true" required>
								<option <?php if( $retorno[0]["CODCONV"] == "") echo "selected"; ?> value="">Selecione o Convênio</option>
								<?php
									foreach ($convenio as $k => $v) {
									$sel = ($v["CODCONV"] == $retorno[0]["CODCONV"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODCONV'];?>" <?php echo $sel; ?> > <?php echo $v["DESCRICAO"] ?> </option>
									<?php  
										}
									?>									
								</select>								
							</div>							
						</div>
						<div class="divisor" >
							ÁREA TÉCNICA
						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-5 col-xs-12">
								<label for="FFNOMEPROCEDIMENTOTELA" class="sys-label col-sm-12 col-xs-12">Procedimento:</label>
								<div class="input-group mb-3">
								  <input type="text" class="form-control" placeholder="Nome do Procedimento" aria-label="Nome do Procedimento" aria-describedby="basic-addon2" id="FFNOMEPROCEDIMENTOTELA" value= "<?php echo $retorno[0]['DESCRICAO'] ?>" readonly>
								  <div class="input-group-append">
								    <button class="btn btn-outline-secondary fa fa-search"  id="btnPesquisaProcedimento" type="button" ></button>
								  </div>
								</div>								
							</div>	
							<div class="col-main col-sm-1 col-xs-12">
								<label for="FFPERMANENCIA" class="sys-label col-sm-12 col-xs-12">Permanecia(H):</label>
								<input class="col-sm-12 col-xs-12 form-control" type="time" value="<?php echo $retorno[0]['PERMANENCIA']  ?>" id="FFPERMANENCIA" name="FFPERMANENCIA"  >
							</div> 	
							<div class="col-main col-sm-1 col-xs-12">
								<label for="FFREPETICAO" class="sys-label col-sm-12 col-xs-12">Repetição:</label>
								<select class="form-control form-control-sm col-sm-12 col-xs-12" id="FFREPETICAO" name="FFREPETICAO" >
									<option <?php if( $retorno[0]["REPETICAO"] == "N") echo "selected"; ?> value="N">Não</option>
									<option <?php if( $retorno[0]["REPETICAO"] == "S") echo "selected"; ?> value="S">Sim</option>
								</select>
							</div>							
						</div>	
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-5 col-xs-12">
							<label for="FFRADIOISOTOPO " class="sys-label col-sm-12 col-xs-12">Radioisótopo:</label>	
								<select class="form-control selectpicker"  id="FFRADIOISOTOPO" name="FFRADIOISOTOPO" data-live-search="true">
								<option <?php if( $retorno[0]["CODRADIOISOTOPO"] == "") echo "selected"; ?> value="">Selecione o Radioisótopo</option>
								<?php
									foreach ($radioisotopos as $k => $v) {
									$sel = ($v["CODRADIOISOTOPO"] == $retorno[0]["CODRADIOISOTOPO"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODRADIOISOTOPO'];?>" <?php echo $sel; ?> > <?php echo $v["DESCRICAO"] ?> </option>
									<?php  
										}
									?>									
								</select>								
							</div>
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFATIVIDADE" class="sys-label col-sm-12 col-xs-12">Atividade mCI:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADE" name="FFATIVIDADE" value="<?php echo $retorno[0]["ATIVIDADE"];  ?>"  onkeyup="somenteNumeros(this)"
								 placeholder="Atividade em mCi" autocomplete="off">
								 
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


	<?php include VIEWPATH . "_includes/_pesquisaPaciente.php"; ?>
	<?php include VIEWPATH . "_includes/_pesquisaExame.php"; ?>





