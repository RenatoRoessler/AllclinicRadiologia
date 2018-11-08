
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Instituições / Cadastros
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 
			<!--
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Instituicao/atualizar' ?> " method="post" class="form-horizontal" data-parsley-validate >
			-->

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formulario','name' => 'formulario');
			$action  =  base_url() .'Instituicao/atualizar';
            echo form_open($action , $attributes);
            ?>

				<input type="hidden" id="FFCODINST" name="FFCODINST" value="<?php echo $retorno[0]["CODINST"]; ?>" >
				
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
							<div class="col-main col-sm-2 col-xs-12">
								<label for="codigo" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="codigo" name="codigo" value="<?php echo $retorno[0]["CODINST"]; ?>" readonly >
							</div>
							<div class="col-main col-sm-3 col-xs-12">
								<label for="FFFantasia" class="sys-label col-sm-12 col-xs-12">Fantasia:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="FFFantasia" name="FFFantasia" value="<?php echo $retorno[0]["FANTASIA"]; ?>" 
								minlength="3" maxlength="30"  required>
							</div>
							<div class="col-main col-sm-3 col-xs-12">
								<label for="FFRazao" class="sys-label col-sm-12 col-xs-12">Razão:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="FFRazao" name="FFRazao" value="<?php echo $retorno[0]["RAZAO"]; ?>" 
								minlength="3" maxlength="70" required >
							</div>
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFCNPJ" class="sys-label col-sm-12 col-xs-12">CNPJ:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="FFCNPJ" name="FFCNPJ" value="<?php echo $retorno[0]["CNPJ"]; ?>" 
								minlength="8" maxlength="15"  required>
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

			<!-- </form>  -->
			<?php 
            echo form_close();
            ?>

		</div>
	</div>
<div class="row col-md-11 col-sm-11 col-xs-11 sys-btn-action-base-container">
	<div class="col-sm-1 col-xs-2">
		<button class="btn btn-warning sys-btn-action-base" id="btnEditar" 
			data-toggle="tooltip" data-placement="top" title="Editar" ><i class="fa fa-pencil"></i></button>
	</div>
</div>





