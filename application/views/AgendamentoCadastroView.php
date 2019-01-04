
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
			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Agendamento/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODAGTO1" name="FFCODAGTO1" value="<?php echo $retorno[0]["CODAGTO"]; ?>" >
					
		    	<input type="hidden" class="col-sm-12 col-xs-12 form-control" id="FFPROCEDIMENTO" name="FFPROCEDIMENTO" value= "<?php echo $retorno[0]['CODPROCEDIMENTO'] ?>" >		
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
							<div class="form-group col-main col-sm-1 col-xs-12">
					        	<label for="FFDATAHORA" class="sys-label col-sm-12 col-xs-12">Data&nbsp;Agendamento:</label>
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
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFNOMEPAC" class="sys-label col-sm-12 col-xs-12">Nome Paciente:</label>
								<div class="input-group mb-3">
								  <input type="text" class="form-control" placeholder="Nome do Paciente" aria-label="Nome do Paciente" aria-describedby="basic-addon2" id="FFNOMEPAC" name="FFNOMEPAC" value= "<?php echo $retorno[0]['NOME'] ?>" autocomplete="off" >
								</div>								
							</div>
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFSOBRENOMEPAC" class="sys-label col-sm-12 col-xs-12">Sobrenome Paciente:</label>
								<div class="input-group mb-3">
								  <input type="text" class="form-control" placeholder="Sobrenome do Paciente" aria-label="Sobrenome do Paciente" aria-describedby="basic-addon2" id="FFSOBRENOMEPAC" name="FFSOBRENOMEPAC" value= "<?php echo $retorno[0]['SOBRENOME'] ?>" autocomplete="off">
								</div>								
							</div>							
						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFCPF" class="sys-label col-sm-12 col-xs-12">CPF:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCPF" name="FFCPF" value="<?php echo $retorno[0]["CPF"]; ?>" 
								minlength="19" maxlength="15" placeholder="CPF.: 000.000.000-00" autocomplete="off">
							</div>								
							<div class="form-group col-main col-sm-1 col-xs-12">
					        	<label for="FFDATANASCIMENTO" class="sys-label col-sm-12 col-xs-12">Data Nascimento:</label>
					            <div class='input-group date' >
					                <input type='text' class="form-control" id='FFDATANASCIMENTO' name="FFDATANASCIMENTO" value="<?php   echo $retorno[0]["DNASCIMENTO"]   ?>"  autocomplete="off" placeholder="Data de Nascimento" />
					                <span class="input-group-addon">
					                      <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					        </div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFPESO" class="sys-label col-sm-12 col-xs-12">Peso(Kg):</label>
								<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFPESO" name="FFPESO" value="<?php echo $retorno[0]["PESO"]; ?>" 
								 placeholder="Peso.: 000.000" >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFALTURA" class="sys-label col-sm-12 col-xs-12">Altura:</label>
								<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFALTURA" name="FFALTURA" value="<?php echo $retorno[0]["ALTURA"]; ?>" 
								 placeholder="Altura.: 0.000" >
							</div>							
							<div class="col-main col-sm-4 col-xs-12">
								<label for="FFCONVENIO" class="sys-label col-sm-12 col-xs-12">Convênio:</label>	
								<select class="selectpicker  form-control" id="FFCONVENIO" name="FFCONVENIO" data-live-search="true">
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



	<?php include VIEWPATH . "_includes/_pesquisaPaciente.php"; ?>
	<?php include VIEWPATH . "_includes/_pesquisaExame.php"; ?>




