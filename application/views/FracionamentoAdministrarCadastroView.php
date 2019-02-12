
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Fracionamento');  ?>">Fracionamento</a> / Administrar
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioAdministrar','name' => 'formularioAdministrar');
			$action  =  base_url() .'Fracionamento/Administrar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODFRACIONAMENTO1" name="FFCODFRACIONAMENTO1" value="<?php echo $retorno[0]["CODFRACIONAMENTO"]; ?>" >
			
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
								<label for="FFCODITFRACIONAMENTO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODITFRACIONAMENTO" name="FFCODITFRACIONAMENTO" value="<?php echo $retorno[0]["CODITFRACIONAMENTO"]; ?>"  readonly >
							</div>	
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFATIVIDADE" class="sys-label col-sm-12 col-xs-12">Atividade Inicial:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATIVIDADE" name="FFATIVIDADE" value="<?php echo $retorno[0]["ATIVIDADE"]; ?>"  onkeyup="somenteNumeros(this); " >
							</div>							
						    <div class="col-main col-sm-1 col-xs-12">
       							<label  for="FFHORAINICIO" class="sys-label col-sm-12 col-xs-12">Hora Inicio:</label>
        						<input class="col-sm-12 col-xs-12 form-control" type="time" id="FFHORAINICIO" name="FFHORAINICIO" min="00:00" max="24:00" required value="<?php echo $retorno[0]["HORAINICIO"];  ?>" />
    						</div>
    						<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFATVADMINISTRADA" class="sys-label col-sm-12 col-xs-12">Atividade Administrada:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFATVADMINISTRADA" name="FFATVADMINISTRADA" value="<?php echo $retorno[0]["ATV_ADMINISTRADA"]; ?>"  onkeyup="somenteNumeros(this); " >
							</div>
    						 <div class="col-main col-sm-2 col-xs-12">
       							<label  for="FFHORAADMINISTRADA" class="sys-label col-sm-12 col-xs-12">Hora Administrada:</label>
        						<input class="col-sm-12 col-xs-12 form-control" type="time" id="FFHORAADMINISTRADA" name="FFHORAADMINISTRADA" min="00:00" max="24:00" required value="<?php echo $retorno[0]["HORA_ADMINISTRADA"];  ?>" />
    						</div>
    					</div>
					</div>
				</div>
				<br/>
					<div class="col-xs-1 col-sm-1 pull-left">
		      			<button type="button" id="btnVoltarAdministracao" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-chevron-left"></i> Voltar</button>
	      			</div>
				<div class="col-xs-12 col-md-12 col-sm-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnSalvarAdministracao" class="btn btn-success btn-sm sys-btn-search" ><i class="fa fa-save"></i> Salvar</button>
	      			</div>
		    	</div>
			<?php 
            echo form_close();
            ?>

		</div>
	</div>






