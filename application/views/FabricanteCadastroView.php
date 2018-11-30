
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Fabricante');  ?>">Fabricante</a> / Cadastros
					<br/>
				</li>
			</ol>
			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 
			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Fabricante/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODFABRICANTE1" name="FFCODFABRICANTE1" value="<?php echo $retorno[0]["CODFABRICANTE"]; ?>" >
			
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
								<label for="FFCODFABRICANTE" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODFABRICANTE" name="FFCODFABRICANTE" value="<?php echo $retorno[0]["CODFABRICANTE"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-3 col-xs-12">
								<label for="FFDESCRICAO" class="sys-label col-sm-12 col-xs-12">Descrição:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFDESCRICAO" name="FFDESCRICAO" value="<?php echo $retorno[0]["DESCRICAO"]; ?>" 
								minlength="10" maxlength="45"  required style="text-transform:uppercase" autocomplete="off">
							</div>
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFESPECIFICACAO" class="sys-label col-sm-12 col-xs-12">Especificação:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFESPECIFICACAO" name="FFESPECIFICACAO" value="<?php echo $retorno[0]["ESPECIFICACAO"]; ?>" 
								minlength="10" maxlength="45" required  style="text-transform:uppercase" autocomplete="off">
							</div>	
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFTIPO" class="sys-label col-sm-12 col-xs-12">Tipo:</label>	
								<select class="form-control form-control-sm col-sm-12 col-xs-12 " id="FFTIPO" name="FFTIPO">
									<option <?php if( $retorno[0]["TIPO"] == "") echo "selected"; ?> value="">Selecione o Tipo</option>
									<option <?php if( $retorno[0]["TIPO"] == "1") echo "selected"; ?> value="1">Gerador</option>
									<option <?php if( $retorno[0]["TIPO"] == "2") echo "selected"; ?> value="2">Radiofarmaco</option>
								</select>
							</div>					
						</div>
					</div>
				</div>
				<div class="row col-sm-12 col-xs-12">
					<div class="row col-sm-4 col-xs-12">
						<div class="col-main col-sm-7 col-xs-12">
							<label for="FFFARMACO" class="sys-label col-sm-12 col-xs-12">Farmaco:</label>	
							<select class="form-control form-control-sm" id="FFFARMACO" name="FFFARMACO" data-live-search="true">
								<option >Selecione o Farmaco</option>
								<?php
								foreach ($farmaco as $k => $v) {
								$sel = ($v["CODFARMACO"] == $retorno[0]["CODFARMACO"]  ) ? 'selected' : '';
								?>
								<option value="<?php echo $v['CODFARMACO'];?>" <?php echo $sel; ?> > <?php echo $v["DESCRICAO"]  ?> </option>
								<?php  
								}
								?>									
							</select>
						</div>
						<div class="col-xs-2 col-sm-5 pull-right">
							<label for="btnAdicionar" class="sys-label col-sm-12 col-xs-12">&nbsp; </label>
							<button type="button" id="btnAdicionar" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-plus"></i> Adicionar Farmaco</button>
						</div>									
					</div>
					
					<div class="row col-sm-8 col-xs-12" > 	
						<div class="col-md-12">
							<div class="panel-group" >	
								<div class="panel panel-default">		
									<div class="panel-body table-responsive">
										<table id="tableIndex" class="table table-middle table-condensed table-hover table-borderless table-striped table-bordered" style="width:100% !important;">
											<thead>
												<tr>
													<th>Farmaco</th>
													<th>PH</th>	
													<th>Solvente Orgânico</th>	
													<th>Solvente Inorgânico</th>	
													<th>Excluir</th>	   					
												</tr>
											</thead>
											<tbody>
												<?php 
												if($fabricanteFarmaco){
												foreach ($fabricanteFarmaco as $k => $v) {  			
												?>
												<tr id="<?php echo $v['CODFABRICANTE']; ?>">
												<td><?php echo $v['DESCRICAO']; ?></td>
												<td><?php echo $v['PH']; ?></td>
												<td><?php echo $v['SOLV_ORGANICO']; ?></td>
												<td><?php echo $v['SOLV_INORGANICO']; ?></td>
								
												
												<td width="10"> 
													<a href=<?php echo base_url() .'/Fabricante/excluirItem/'. $v['CODFABRICANTE']  ?> > 
														<i class="fa fa-minus-circle fa-lg" style="color:red;"></i> 
													</a>
												</td>
												</tr>
												<?php } } ?>
											</tbody>
										</table>
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




