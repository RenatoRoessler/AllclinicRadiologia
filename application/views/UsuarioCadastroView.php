
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Usuarios');  ?>">Usuários</a> / Cadastros
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<form id="formularioCadastro" name="formularioCadastro" action="<?php echo base_url() .'Usuarios/atualizar' ?> " method="post" class="form-horizontal"   data-parsley-validate >
            	<input type="hidden" id="FFAPELUSER1" name="FFAPELUSER1" value="<?php echo $retorno[0]["APELUSER"]; ?>" >
			
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
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="UsuarioModel" class="sys-label col-sm-12 col-xs-12">Login:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFAPELUSER" name="FFAPELUSER" 
								value="<?php echo $retorno[0]["APELUSER"]; ?>" minlength="4" maxlength="10"  style="text-transform:uppercase" required>
							</div>
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFNOME" class="sys-label col-sm-12 col-xs-12">Nome:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFNOME" name="FFNOME" value="<?php echo $retorno[0]["NOME"]; ?>" 
								minlength="5" maxlength="45"  required style="text-transform:uppercase" autocomplete="off">
							</div>
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFEMAIL" class="sys-label col-sm-12 col-xs-12">E-mail:</label>
								<input type="email" class="col-sm-12 col-xs-12 form-control" id="FFEMAIL" name="FFEMAIL" value="<?php echo $retorno[0]["EMAIL"]; ?>" 
								minlength="3" maxlength="255" required  style="text-transform:lowercase" autocomplete="off">
							</div>
							
						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="col-main col-sm-3 col-xs-12">
								<label for="FFINSTITUICAO" class="sys-label col-sm-12 col-xs-12">Instituição:</label>	
								<select class="form-control form-control-sm" id="FFINSTITUICAO" name="FFINSTITUICAO" data-live-search="true" required>
								<option <?php if( $retorno[0]["CODINST"] == "") echo "selected"; ?> value="">Selecione a Conta</option>
								<?php
									foreach ($instituicao as $k => $v) {
									$sel = ($v["CODINST"] == $retorno[0]["CODINST"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODINST'];?>" <?php echo $sel; ?> > <?php echo $v["FANTASIA"]; ?> </option>
									<?php  
										}
									?>
									
								</select>
							</div>
							<div class="form-group col-main col-sm-2 col-xs-12">
                                <label for="txt-senha" class="sys-label col-sm-12 col-xs-12">Senha</label>
                                <input type="password" id="txt-senha" name="txt-senha" class="form-control" >
                            </div>
                            <div class="form-group col-main col-sm-2 col-xs-12">
                                <label for="txt-confir-senha" class="sys-label col-sm-12 col-xs-12">Confirmar Senha</label>
                                <input type="password" id="txt-confir-senha" name="txt-confir-senha" class="form-control">
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




