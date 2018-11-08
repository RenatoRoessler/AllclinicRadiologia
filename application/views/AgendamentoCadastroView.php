
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
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFPRONTUARIO" class="sys-label col-sm-12 col-xs-12">Paciente:</label>	
								<select class="form-control form-control-sm" id="FFPRONTUARIO" name="FFPRONTUARIO" data-live-search="true">
								<option <?php if( $retorno[0]["PRONTUARIO"] == "") echo "selected"; ?> value="">Selecione o Paciente</option>
								<?php
									foreach ($paciente as $k => $v) {
									$sel = ($v["PRONTUARIO"] == $retorno[0]["PRONTUARIO"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['PRONTUARIO'];?>" <?php echo $sel; ?> > <?php echo $v["NOME"]; ?> </option>
									<?php  
										}
									?>									
								</select>
							</div>
							<div class="form-group col-main col-sm-2 col-xs-12">
					        	<label for="FFDATAHORA" class="sys-label col-sm-12 col-xs-12">Data:</label>
					            <div class='input-group date' >
					                <input type='text' class="form-control" id='FFDATAHORA' name="FFDATAHORA" value="<?php echo $retorno[0]["DATA1"];  ?>"  autocomplete="off"/>
					                <span class="input-group-addon">
					                      <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					        </div>
					        <div class="col-main col-sm-1 col-xs-12">
       							<label  for="FFHORA" class="sys-label col-sm-12 col-xs-12">Hora:</label>
        						<input class="col-sm-12 col-xs-12 form-control" type="time" id="FFHORA" name="FFHORA" min="00:00" max="24:00" required value="<?php echo $retorno[0]["HORA"];  ?>" />
    						</div>  
    						<div class="col-main col-sm-2 col-xs-12">
								<label for="FFPROCEDIMENTO" class="sys-label col-sm-12 col-xs-12">Procedimento:</label>	
								<select class="form-control form-control-sm" id="FFPROCEDIMENTO" name="FFPROCEDIMENTO" data-live-search="true">
								<option <?php if( $retorno[0]["CODPROCEDIMENTO"] == "") echo "selected"; ?> value="">Selecione o Procedimento</option>
								<?php
									foreach ($procedimento as $k => $v) {
									$sel = ($v["CODPROCEDIMENTO"] == $retorno[0]["CODPROCEDIMENTO"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODPROCEDIMENTO'];?>" <?php echo $sel; ?> > <?php echo $v["DESCRICAO"]; ?> </option>
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
			<?php 
            echo form_close();
            ?>

		</div>
	</div>




