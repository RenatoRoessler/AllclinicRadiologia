    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Fracionamento
				</li>
			</ol>
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Fracionamento/' ?> " method="post" class="form-horizontal" data-parsley-validate >
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
						<label for="Lote" class="sys-label col-sm-12 col-xs-12">Lote:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Lote" name="Lote" value="<?php echo $this->input->post("Lote") ?>"  style="text-transform:uppercase"  autocomplete="off">
					</div> 
					<div class="form-group col-main col-sm-2 col-xs-12">
						<label for="FFDATAPESQUISA" class="sys-label col-sm-12 col-xs-12">Data Inicial:</label>
						<input class="form-control" type="date" value="<?php echo $this->input->post("FFDATAPESQUISA") ? $this->input->post("FFDATAPESQUISA") : date('Y-m-d');  ?>" id="FFDATAPESQUISA" name="FFDATAPESQUISA" required> 	
				    </div>
					<div class="form-group col-main col-sm-2 col-xs-12">
						<label for="FFDATAFINALPESQUISA" class="sys-label col-sm-12 col-xs-12">Data Final:</label>
						<input class="form-control" type="date" value="<?php echo $this->input->post("FFDATAFINALPESQUISA") ? $this->input->post("FFDATAFINALPESQUISA") : date('Y-m-d');  ?>" id="FFDATAFINALPESQUISA" name="FFDATAFINALPESQUISA" required> 	
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
												<th>Lote</th>
												<th>Lote Gerador</th>
												<th>Lote Eluição</th>
						    					<th>Data</th>
						    					<th>Hora</th>
						    					<th>Usuário</th>
												<th>Fármaco</th>
						    					<th>Fabricante</th>
												<th>PH</th>
												<th>Fracionar</th>
						    				</th>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($fracionamento as $k => $v) {  
						    				$true =  '<i class="fa fa-check-circle fa-2x">';
						    				$false =  '<i class="fa fa-times-circle fa-2x">';				
						    				?>
						    				<tr id="<?php echo $v['CODMARCACAO']; ?>">

												<td><?php echo $v['LOTE']; ?></td>
												<td><?php echo $v['LOTEGERADOR']; ?></td>
												<td><?php echo $v['LOTEELUICAO']; ?></td>
						    					<td><?php echo $v['DATA1']; ?></td>
												<td><?php echo $v['HORA']; ?></td>
												<td><?php echo $v['NOME']; ?></td>
												<td><?php echo $v['DESCKITFARMACO']; ?></td>
												<td><?php echo $v['DESCKITFABRICANTE']; ?></td>
												<td><?php echo $v['PH']; ?></td>
						    					<td width="10"> 
						    						<a class="btn btn-default" href=<?php echo base_url() .'/Fracionamento/editar/'. $v['CODMARCACAO']
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






