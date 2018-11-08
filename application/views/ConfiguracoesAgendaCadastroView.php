
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('ConfiguracoesAgendaView');  ?>">Configurações Agenda</a> / Cadastros
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'ConfiguracoesAgenda/atualizar';
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
							<div class="form-group col-main col-sm-5 col-xs-12">
								<label for="FFDESCRICAO" class="sys-label col-sm-12 col-xs-12">Descrição:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFDESCRICAO" name="FFDESCRICAO" value="<?php echo $retorno[0]["DESCRICAO"]; ?>" 
								minlength="10" maxlength="150"  required style="text-transform:uppercase">
							</div>
							<div class="col-main col-sm-1 col-xs-12">
       							<label  for="FFINICIO" class="sys-label col-sm-12 col-xs-12">Hora Início:</label>
        						<input class="col-sm-12 col-xs-12 form-control" type="time" id="FFINICIO" name="FFINICIO" min="00:00" max="24:00" required value="<?php echo $retorno[0]["INICIO"];  ?>" />
    						</div>
    						<div class="col-main col-sm-1 col-xs-12">
       							<label  for="FFFIM" class="sys-label col-sm-12 col-xs-12">Hora Fim:</label>
        						<input class="col-sm-12 col-xs-12 form-control" type="time" id="FFFIM" name="FFFIM" min="00:00" max="24:00" required value="<?php echo $retorno[0]["FIM"];  ?>" />
    						</div>	
    						<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFINTERVALO" class="sys-label col-sm-12 col-xs-12">Intervalo:</label>
								<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFINTERVALO" name="FFINTERVALO" value="<?php echo $retorno[0]["INTERVALO"]; ?>" 
								 placeholder="Minutos" min="5" max="60">
							</div>
						</div>		
						<div class="row col-sm-12 col-xs-12">	
							<div class="form-group col-main col-sm-12 col-xs-12">					
								<div class="card">
								  	<div class="card-header">
								    	Dias Ativos da Agenda
								  	</div>
								  	<div class="card-body">	
								  		<div class="form-check form-check-inline col-main col-sm-1 col-xs-12">
									      	<label class="form-check-label" for="ckDomingo">
									      		<input class="form-check-input" type="checkbox" id="ckDomingo" name="ckDomingo" 
									      		<?php if($retorno[0]['DOMINGO']){echo 'checked'; }  ?>>Domingo
									      	</label>
									    </div>							    
									    <div class="form-check form-check-inline col-main col-sm-1 col-xs-12">
									      	<label class="form-check-label" for="ckSegunda">
									      		<input class="form-check-input" type="checkbox" id="ckSegunda" name="ckSegunda" 
									      		<?php if($retorno[0]['SEGUNDA']){echo 'checked'; }  ?>>
									      	Segunda
									        </label>
									    </div>
									    <div class="form-check form-check-inline col-main col-sm-1 col-xs-12">
									      	<label class="form-check-label" for="ckTerca">
									      		<input class="form-check-input" type="checkbox" id="ckTerca"  name="ckTerca" <?php if($retorno[0]['TERCA']){echo 'checked'; }  ?>>
									      	Terça
									      	</label>
									    </div>
									     <div class="form-check form-check-inline col-main col-sm-1 col-xs-12">
									      	<label class="form-check-label" for="ckQuarta">
									      		<input class="form-check-input" type="checkbox" id="ckQuarta" <?php if($retorno[0]['QUARTA']){echo 'checked'; }  ?> name="ckQuarta">
									      	Quarta
									      	</label>
									    </div>
									     <div class="form-check form-check-inline col-main col-sm-1 col-xs-12">
									      	<label class="form-check-label" for="ckQuinta">
									      		<input class="form-check-input" type="checkbox" id="ckQuinta" name="ckQuinta" <?php if($retorno[0]['QUINTA']){echo 'checked'; }  ?>>
									      	Quinta
									      	</label>
									    </div>
									     <div class="form-check form-check-inline col-main col-sm-1 col-xs-12">
									      	<label class="form-check-label" for="ckSexta">
									      		<input class="form-check-input" type="checkbox" id="ckSexta" name="ckSexta" <?php if($retorno[0]['SEXTA']){echo 'checked'; }  ?>>
									      	Sexta
									      	</label>
									    </div>
									     <div class="form-check form-check-inline col-main col-sm-1 col-xs-12">
									      	<label class="form-check-label" for="ckSabado">								      	
									      		<input class="form-check-input" type="checkbox" id="ckSabado" name="ckSabado" <?php if($retorno[0]['SABADO']){echo 'checked'; }  ?>>
									      	Sabado
									  		</label>
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




