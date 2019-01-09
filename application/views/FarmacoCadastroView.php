
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Farmaco');  ?>">Farmaco</a>  / Cadastros
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Farmaco/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODFARMACO1" name="FFCODFARMACO1" value="<?php echo $retorno[0]["CODFARMACO"]; ?>" >			
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnExcluirFarmaco" class="btn btn-danger btn-sm sys-btn-search" ><i class="fa fa-trash"></i> Excluir</button>
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
								<label for="FFCODFARMACO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODFARMACO" name="FFCODFARMACO" value="<?php echo $retorno[0]["CODFARMACO"]; ?>"  readonly >
							</div>
                            <div class="form-group col-main col-sm-3 col-xs-12">
								<label for="FFDESCRICAO" class="sys-label col-sm-12 col-xs-12">Nome:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFDESCRICAO" name="FFDESCRICAO" value="<?php echo $retorno[0]["DESCRICAO"]; ?>" 
								minlength="3" maxlength="30"  placeholder="Informe a Descricao"  autocomplete="off">
							</div>
                            	
                            <div class="col-main col-sm-1 col-xs-12">
								<label for="FFATIVO" class="sys-label col-sm-12 col-xs-12">Ativo:</label>
								<select class="form-control form-control-sm col-sm-12 col-xs-12 " id="FFATIVO" name="FFATIVO">
									<option <?php if( $retorno[0]["ATIVO"] == "S") echo "selected"; ?> value="S">Ativo</option>
									<option <?php if( $retorno[0]["ATIVO"] == "N") echo "selected"; ?> value="N">Inativo</option>
								</select>
							</div>				        		
						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="row col-md-2 col-xs-12">	
								<div class="form-group col-main col-sm-12 col-xs-12">			
									<div class="card">
										<div class="card-header">
											Limites
										</div>									  	
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFPH" class="sys-label col-sm-12 col-xs-12">PH:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFPH" name="FFPH" value="<?php echo $retorno[0]["PH"] ? $retorno[0]["PH"] : 0 ;  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" >
											</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFSOLVORGANICO" class="sys-label col-sm-12 col-xs-12">Solv. Orgânico(%):</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFSOLVORGANICO" name="FFSOLVORGANICO" value="<?php echo $retorno[0]["SOLV_ORGANICO"] ? $retorno[0]["SOLV_ORGANICO"] : 0 ;  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" >
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFSOLVINORGANICO" class="sys-label col-sm-12 col-xs-12">Solv. Inorgânico(%):</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFSOLVINORGANICO" name="FFSOLVINORGANICO" value="<?php echo $retorno[0]["SOLV_INORGANICO"] ? $retorno[0]["SOLV_INORGANICO"] : 0 ;  ?>" onkeyup="somenteNumeros(this);" autocomplete="off" >
										</div>
									</div>
								</div>
							</div>
							<div class="row col-sm-10 col-xs-12" <?php echo $retorno[0]["CODFARMACO"]  ?   '' : 'style="visibility: hidden;"' ?> > 
								<div class="form-group col-main col-sm-12 col-xs-12">			
									<div class="card">
										<div class="card-header">
											Fabricantes desse farmaco
										</div>	
										<div class="row col-sm-6 col-xs-12">
											<div class="col-main col-sm-7 col-xs-12">
												<label for="FFFABRICANTE" class="sys-label col-sm-12 col-xs-12">Fabricante:</label>	
												<select class="form-control form-control-sm" id="FFFABRICANTE" name="FFFABRICANTE" data-live-search="true">
													<option >Selecione o Farmaco</option>
													<?php
													foreach ($fabricante as $k => $v) {
													?>
													<option value="<?php echo $v['CODFABRICANTE'];?>"  > <?php echo $v["DESCRICAO"]  ?> </option>
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
										<div class="panel-group col-main col-sm-12 col-xs-12" id="vinculo"  >	
											<div class="panel panel-default">		
												<div class="panel-body table-responsive">
													<table id="tableIndex" class="table table-middle table-condensed table-hover table-borderless table-striped table-bordered" style="width:100% !important;">
														<thead>
															<tr>
																<th>Fabricante</th>
																<th>PH</th>	
																<th>Solvente Orgânico</th>	
																<th>Solvente Inorgânico</th>	
																<th>Excluir</th>	   					
															</tr>
														</thead>
														<tbody>
															<?php 
															if($farmacoFabricante){
															foreach ($farmacoFabricante as $k => $v) {  			
															?>
															<tr id="<?php echo $v['CODFABRICANTE'];  ?>" id2="<?php echo $v['CODFARMACO'];  ?>">
															<td><?php echo $v['DESCFABRICANTE']; ?></td>
															<td><?php echo $v['PH']; ?></td>
															<td><?php echo $v['SOLV_ORGANICO']; ?></td>
															<td><?php echo $v['SOLV_INORGANICO']; ?></td>	
															<td width="10"> 
																<button type="button" id="btnExcluirVinculo"   class="btn btn-default " ><i class="fa fa-minus-circle fa-lg" style="color:red;" onclick="excluirVinculo(<?php echo $v['CODFABRICANTE'] ?>, <?php echo $v['CODFARMACO'] ?>)" ></i> </button>
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


	<script type="text/javascript">
		function excluirVinculo(codfabricante,codfarmaco){
			$.ajax({
			url : '/AllclinicRadiologia/farmaco/excluirVinculo/',
			type : 'POST',
			timeout: 30000,
			data : {
				'Codigo' :  '1',
				'CODFARMACO' : codfarmaco,
				'CODFABRICANTE' : codfabricante,				
			},
			beforeSend: function(){
				loader('show');
			},
			success: function( retorno ){
				var j = jsonEncode( retorno, 'json' );
				mensagem(j.content.tipoMsg , j.content.mensagem);				
				loader('hide');
				ir('/AllclinicRadiologia/farmaco/editar/' +  codfarmaco);
			},
			error: function( request, status, error ){ 
				loader('hide');
				mensagem( 'e', error )
			}
		});	
		}
	</script>








