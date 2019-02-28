
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Convenio');  ?>">Manutenção Convênio </a> / Convênio
					<br/>
				</li>
			</ol>
			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 
			<form id="formularioCadastro" name="formularioCadastro" action="<?php echo base_url() .'Convenio/atualizar' ?> " method="post" class="form-horizontal"   data-parsley-validate >
            	<input type="hidden" id="FFCODCONV1" name="FFCODCONV1" value="<?php echo $retorno[0]["CODCONV"]; ?>" >
			
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnExcluirConvenio" class="btn btn-danger btn-sm sys-btn-search" ><i class="fa fa-trash"></i> Excluir</button>
	      			</div>

				</div>
				<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;' ></div>
				<div class="tab-content">
					<br/>
					<div role="tabpanel" class="tab-pane active" id="geral">
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFCODCONV" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODCONV" name="FFCODCONV" value="<?php echo $retorno[0]["CODCONV"]; ?>"  readonly >
							</div>
                            <div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFDESCRICAO" class="sys-label col-sm-12 col-xs-12">Descrição:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFDESCRICAO" name="FFDESCRICAO" value="<?php echo $retorno[0]["DESCRICAO"]; ?>" >
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




