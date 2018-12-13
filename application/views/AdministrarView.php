    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Administrar
				</li>
			</ol>
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Administrar/' ?> " method="post" class="form-horizontal" data-parsley-validate >
				<div class="row sys-main-title sys-title sys-title-2">
					<div class="col-xs-12 col-md-12 col-sm-12">

					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSearch" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-search"></i> Filtar</button>
	      			</div>	  
	      			<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnLimpar" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-eraser"></i> Limpar</button>
	      			</div>    		
		    	</div>
		    	<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
		    	<div class="row tab-content col-xs-12 col-md-12 col-sm-12">
		    		<div class="form-group col-main col-sm-2 col-xs-2">
						<label for="UsuarioModel" class="sys-label col-sm-12 col-xs-12">Código:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Codigo" name="Codigo" value="<?php echo $this->input->post("Codigo") ?>"  >
					</div>	 	
		    	
					<div class="form-group col-main col-sm-2 col-xs-2">
						<label for="Lote" class="sys-label col-sm-12 col-xs-12">Lote:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Lote" name="Lote" value="<?php echo $this->input->post("Lote") ?>"  style="text-transform:uppercase"  autocomplete="off">
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
												<th>Paciente</th>	
						    					<th>Exame</th>
						    					<th>Data</th>
						    					<th>Hora</th>
						    					<th>Atividade Inicial</th>
						    					<th>Hora Inicio</th>
						    					<th>Atividade Administrad</th>
												<th>Hora Administrada</th>
												<th>Administrar</th>
						    				</th>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($administrar as $k => $v) {  
						    				$true =  '<i class="fa fa-check-circle fa-2x">';
						    				$false =  '<i class="fa fa-times-circle fa-2x">';				
						    				?>
						    				<tr id="<?php echo $v['CODITFRACIONAMENTO']; ?>">
						    					<td><?php echo $v['CODITFRACIONAMENTO']; ?></td>
												<td><?php echo $v['NOMEPACIENTE']; ?></td>
						    					<td><?php echo $v['DESCRICAO']; ?></td>
												<td><?php echo $v['DATA1']; ?></td>
												<td><?php echo $v['HORAMINUTO']; ?></td>
												<td><?php echo $v['ATIVIDADE_INICIAL']; ?></td>
												<td><?php echo $v['HORA_INICIAL']; ?></td>
												<td><?php echo $v['ATIVIDADE_ADMINISTRADA']; ?></td>
												<td><?php echo $v['HORA_ADMINISTRADA']; ?></td>
						    					<td width="10"> 
						    						<a class="btn btn-default" href=<?php echo base_url() .'/Administrar/Administracao/'. $v['CODMARCACAO']
						    						  ?> > 
						    							<i class="fa fa-edit fa-lg" ></i> 
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






