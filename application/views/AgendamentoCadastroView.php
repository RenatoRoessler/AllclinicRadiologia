
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('AgendamentoView');  ?>">Configurações Agenda</a> / Eluicao
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
				<input type="hidden" class="col-sm-12 col-xs-12 form-control" id="FFPRONTUARIO" name="FFPRONTUARIO" value= "<?php echo $retorno[0]['PRONTUARIO'] ?>" >		
		    	<input type="hidden" class="col-sm-12 col-xs-12 form-control" id="FFPROCEDIMENTO" name="FFPROCEDIMENTO" value= "<?php echo $retorno[0]['CODPROCEDIMENTO'] ?>" >		
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
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
								<label for="FFCODAGTO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODAGTO" name="FFCODAGTO" value="<?php echo $retorno[0]["CODAGTO"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFNOMEPAC" class="sys-label col-sm-12 col-xs-12">Paciente:</label>
								<div class="input-group mb-3">
								  <input type="text" class="form-control" placeholder="Nome do Paciente" aria-label="Nome do Paciente" aria-describedby="basic-addon2" id="FFNOMEPAC" value= "<?php echo $retorno[0]['NOME'] ?>" readonly>
								  <div class="input-group-append">
								    <button class="btn btn-outline-secondary fa fa-search"  id="btnPesquisaPac" type="button" ></button>
								  </div>
								</div>								
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
							<div class="form-group col-main col-sm-4 col-xs-12">
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




