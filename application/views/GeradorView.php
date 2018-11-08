    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Gerador
				</li>
			</ol>
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Gerador/' ?> " method="post" class="form-horizontal" data-parsley-validate >
				<div class="row sys-main-title sys-title sys-title-2">
					<div class="col-xs-12 col-md-12 col-sm-12">

					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSearch" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-search"></i> Filtar</button>
	      			</div>	  
	      			<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnLimpar" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-eraser"></i> Limpar</button>
	      			</div>
					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnNovo" class="btn btn-info btn-sm sys-btn-search" ><i class="fa fa-file"></i> Novo Gerador</button>
	      			</div>	      		
		    	</div>
		    	<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
		    	<div class="row tab-content col-xs-12 col-md-12 col-sm-12">
		    		<div class="form-group col-main col-sm-2 col-xs-2">
						<label for="FFCodigo" class="sys-label col-sm-12 col-xs-12">Código:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCodigo" name="FFCodigo" value="<?php echo $this->input->post("FFCodigo") ?>"  >
					</div>	
					<div class="form-group col-main col-sm-3 col-xs-3">
						<label for="Lote" class="sys-label col-sm-12 col-xs-12">Lote:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Lote" name="Lote" value="<?php echo $this->input->post("Lote") ?>"  style="text-transform:uppercase" >
					</div>      	

		    	</div>
		    	<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
			</div>
				<div class="row col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-12">
						<div class="panel-group" >	
							<div class="panel panel-default">
							
						    	<div class="panel-body table-responsive">
						    		<table id="tableIndex" class="table table-middle table-condensed table-hover table-borderless table-striped table-bordered" style="width:100% !important;">
						    			<thead>
						    				<tr>
						    					<th>Código</th>	
						    					<th>Lote</th>
						    					<th>Nro. Eluição</th>
						    					<th>Data</th>
						    					<th>Hora</th>
						    					<th>Instituição</th>
						    					<th>Atividade Calibração</th>
						    					<th>Fabricante</th>
						    					<th>Usuário</th>
						    					<th>Status</th>
						    					<th>Editar</th>
						    					<th>Excluir</th>
						    				</tr>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($gerador as $k => $v) {    				
						    				?>
						    				<tr id="<?php echo $v['CODGERADOR']; ?>">
						    					<td><?php echo $v['CODGERADOR']; ?></td>
						    					<td><?php echo $v['LOTE']; ?></td>
						    					<td><?php echo $v['NRO_ELUICAO']; ?></td>
												<td><?php echo $v['DATA']; ?></td>
												<td><?php echo $v['HORA']; ?></td>
												<td><?php echo $v['FANTASIA']; ?></td>
												<td><?php echo $v['ATIVIDADE_CALIBRACAO']; ?></td>
												<td><?php echo $v['DESCFABRICANTE']; ?></td>
												<td><?php echo $v['NOME']; ?></td>
												<td><?php echo $v['DESCATIVO']; ?></td>
						    					<td width="10"> 
						    						<a class="btn btn-default" href=<?php echo base_url() .'/Gerador/editar/'. $v['CODGERADOR']  ?> > 
						    							<i class="fa fa-edit fa-lg" ></i> 
						    						</a>
						    					</td>
						    					<td width="10">
						    						<a class="btn btn-default" href=<?php echo base_url() .'/Gerador/excluir/'. $v['CODGERADOR']  ?> > 
						    							<i class="fa fa-minus-circle fa-lg"  style="color:red"></i> 
						    						</a>    
						    					</td>

						    				</tr>
						    				<?php } ?>
						    			</tbody>
						    		</table>
						    	</div>

						    </div>						  
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>






