
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Radioisotopo');  ?>">Manutenção Radioisótopo </a> / Cadastro de Radioisótopo
					<br/>
				</li>
			</ol>
			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 
		
			<form id="formularioCadastro" name="formularioCadastro" action="<?php echo base_url() .'Radioisotopo/atualizar' ?> " method="post" class="form-horizontal"   data-parsley-validate >		
			
            	<input type="hidden" id="FFCODRADIOISOTOPO1" name="FFCODRADIOISOTOPO1" value="<?php echo $radioisotopo[0]["CODRADIOISOTOPO"]; ?>" >
			
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnExcluirRadioisotopo" class="btn btn-danger btn-sm sys-btn-search" ><i class="fa fa-trash"></i> Excluir</button>
	      			</div>
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
								<label for="FFCODRADIOISOTOPO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODRADIOISOTOPO" name="FFCODRADIOISOTOPO" value="<?php echo $radioisotopo[0]["CODRADIOISOTOPO"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-5 col-xs-12">
								<label for="FFDESCRICAO" class="sys-label col-sm-12 col-xs-12">*Descrição:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFDESCRICAO" name="FFDESCRICAO" value="<?php echo $radioisotopo[0]["DESCRICAO"]; ?>" minlength="3" maxlength="99"  required style="text-transform:uppercase" autocomplete="off">
							</div>	
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFGAMAO" class="sys-label col-sm-12 col-xs-12">Gamão:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFGAMAO" name="FFGAMAO" value="<?php echo $radioisotopo[0]["GAMAO"] ? $radioisotopo[0]["GAMAO"] : 0 ;  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" required min="0" max="999.999" >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFMEIAVIDA" class="sys-label col-sm-12 col-xs-12">Meia Vida: </label>
								<input type="number" class="col-sm-12 col-xs-12 form-control" id="FFMEIAVIDA" name="FFMEIAVIDA" value="<?php echo $radioisotopo[0]["MEIAVIDA"] ? $radioisotopo[0]["MEIAVIDA"] : 0 ;  ?>"  autocomplete="off" required min="0" max="36" >
								<small id="" class="form-text text-muted">Em Horas</small>											
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




