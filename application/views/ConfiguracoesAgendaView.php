    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Agenda
				</li>
			</ol>
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/ConfiguracoesAgenda/' ?> " method="post" class="form-horizontal" data-parsley-validate >
				<div class="row sys-main-title sys-title sys-title-2">
					<div class="col-xs-12 col-md-12 col-sm-12">

					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSearch" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-search"></i> Filtar</button>
	      			</div>	  
	      			<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnLimpar" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-eraser"></i> Limpar</button>
	      			</div>
					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnNovo" class="btn btn-info btn-sm sys-btn-search" ><i class="fa fa-file"></i> Novo Agenda</button>
	      			</div>	      		
		    	</div>
		    	<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
		    	<div class="row tab-content col-xs-12 col-md-12 col-sm-12">
		    		<div class="form-group col-main col-sm-2 col-xs-2">
						<label for="UsuarioModel" class="sys-label col-sm-12 col-xs-12">Código:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Codigo" name="Codigo" value="<?php echo $this->input->post("Codigo") ?>"  >
					</div>	
					<div class="form-group col-main col-sm-3 col-xs-3">
						<label for="Descricao" class="sys-label col-sm-12 col-xs-12">Descrição:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Descricao" name="Descricao" value="<?php echo $this->input->post("Descricao") ?>"  style="text-transform:uppercase" >
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
						    					<th>Descrição</th>
						    					<th>Hora Inicio</th>
						    					<th>Hora Fim</th>
						    					<th>Segunda</th>
						    					<th>Terça</th>
						    					<th>Quarta</th>
						    					<th>Quinta</th>						    					
						    					<th>Sexta</th>
						    					<th>Sabado</th>
						    					<th>Domingo</th>
						    					<th>Instituição</th>
						    					<th>Editar</th>
						    				</tr>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($configuracoes as $k => $v) {  
						    				$true =  '<i class="fa fa-check-circle fa-2x" style="color:green;">';
						    				$false =  '<i class="fa fa-times-circle fa-2x" style="color:red;"">';				
						    				?>
						    				<tr id="<?php echo $v['CODAGTO']; ?>">
						    					<td><?php echo $v['CODAGTO']; ?></td>
						    					<td><?php echo $v['DESCRICAO']; ?></td>
												<td><?php echo $v['INICIO']; ?></td>
												<td><?php echo $v['FIM']; ?></td>
												<td><?php echo ($v['SEGUNDA'] == 1) ?  $true :   $false; ?></td>
												<td><?php echo ($v['TERCA'] == 1) ?  $true :  $false ; ?></td>
												<td><?php echo ($v['QUARTA'] == 1) ?  $true :  $false ; ?></td>
												<td><?php echo ($v['QUINTA'] == 1) ?  $true :  $false ; ?></td>
												<td><?php echo ($v['SEXTA'] == 1) ?  $true :  $false ; ?></td>
												<td><?php echo ($v['SABADO'] == 1) ?  $true :  $false ; ?></td>
												<td><?php echo ($v['DOMINGO'] == 1) ?  $true :  $false ; ?></td>
												<td><?php echo $v['RAZAO']; ?></td>
						    					<td> 
						    						<a href=<?php echo base_url() .'/ConfiguracoesAgenda/editar/'. $v['CODAGTO']  ?> > 
						    							<i class="fa fa-edit fa-lg "></i> 
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






