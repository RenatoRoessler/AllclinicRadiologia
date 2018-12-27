
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Paciente');  ?>">Paciente</a> / Cadastros
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Paciente/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFPRONTUARIO1" name="FFPRONTUARIO1" value="<?php echo $retorno[0]["PRONTUARIO"]; ?>" >
			
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnExcluirPaciente" class="btn btn-danger btn-sm sys-btn-search" ><i class="fa fa-trash"></i> Excluir</button>
	      			</div>
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
								<label for="FFPRONTUARIO" class="sys-label col-sm-12 col-xs-12">Prontuario:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFPRONTUARIO" name="FFPRONTUARIO" value="<?php echo $retorno[0]["PRONTUARIO"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-3 col-xs-12">
								<label for="FFNOME" class="sys-label col-sm-12 col-xs-12">Nome:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFNOME" name="FFNOME" value="<?php echo $retorno[0]["NOME"]; ?>" 
								minlength="10" maxlength="70"  placeholder="Informe o Nome" style="text-transform:uppercase" autocomplete="off">
							</div>
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFCPF" class="sys-label col-sm-12 col-xs-12">CPF:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCPF" name="FFCPF" value="<?php echo $retorno[0]["CPF"]; ?>" 
								minlength="19" maxlength="15" placeholder="CPF.: 000.000.000-00" autocomplete="off">
							</div>	
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFTELEFONE" class="sys-label col-sm-12 col-xs-12">Telefone:</label>
								<input type="tel" class="col-sm-12 col-xs-12 form-control" id="FFTELEFONE" name="FFTELEFONE" value="<?php echo $retorno[0]["TELEFONE"]; ?>" 
								minlength="10" maxlength="15" required placeholder="Ex.: (00)00000-0000"  autocomplete="off">
							</div>	
							<div class="form-group col-main col-sm-2 col-xs-12">
					        	<label for="FFDTNASC" class="sys-label col-sm-12 col-xs-12">Nascimento:</label>
					            <div class='input-group date' >
					                <input type='text' class="form-control" id='FFDTNASC' name="FFDTNASC" value="<?php echo $retorno[0]["DATANASCIMENTO"];  ?>" autocomplete="off"/>
					                <span class="input-group-addon">
					                      <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					        </div>

						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFPESO" class="sys-label col-sm-12 col-xs-12">Peso:</label>
								<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFPESO" name="FFPESO" value="<?php echo $retorno[0]["PESO"]; ?>" 
								 placeholder="Peso.: 000.000" >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFALTURA" class="sys-label col-sm-12 col-xs-12">Altura:</label>
								<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFALTURA" name="FFALTURA" value="<?php echo $retorno[0]["ALTURA"]; ?>" 
								 placeholder="Altura.: 0.000" >
							</div>	
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFEMAIL" class="sys-label col-sm-12 col-xs-12">Email:</label>
								<input type="email" class="col-sm-12 col-xs-12 form-control" id="FFEMAIL" name="FFEMAIL" value="<?php echo $retorno[0]["EMAIL"]; ?>" 
								 placeholder="email" >
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






