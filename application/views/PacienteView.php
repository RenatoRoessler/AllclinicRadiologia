    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Paciente
				</li>
			</ol>
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Paciente/' ?> " method="post" class="form-horizontal" data-parsley-validate >
				<div class="row sys-main-title sys-title sys-title-2">
					<div class="col-xs-12 col-md-12 col-sm-12">

					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSearch" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-search"></i> Filtar</button>
	      			</div>	  
	      			<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnLimpar" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-eraser"></i> Limpar</button>
	      			</div>
					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnNovo" class="btn btn-info btn-sm sys-btn-search" ><i class="fa fa-file"></i> Novo Paciente</button>
	      			</div>	      		
		    	</div>
		    	<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
		    	<div class="row tab-content col-xs-12 col-md-12 col-sm-12">
		    		<div class="form-group col-main col-sm-1 col-xs-2">
						<label for="Prontuario" class="sys-label col-sm-12 col-xs-12">Prontuário:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Prontuario" name="Prontuario" value="<?php echo $this->input->post("Prontuario") ?>"  >
					</div>	
					<div class="form-group col-main col-sm-3 col-xs-3">
						<label for="Nome" class="sys-label col-sm-12 col-xs-12">Nome:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Nome" name="Nome" value="<?php echo $this->input->post("Nome") ?>"  style="text-transform:uppercase" >
					</div> 
					<div class="form-group col-main col-sm-2 col-xs-3">
						<label for="CPF" class="sys-label col-sm-12 col-xs-12">CPF:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="CPF" name="CPF" value="<?php echo $this->input->post("CPF") ?>"  style="text-transform:uppercase" >
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
						    					<th>Prontuário</th>	
						    					<th>Nome</th>
						    					<th>CPF</th>
						    					<th>Telefone</th>
						    					<th>Nascimento</th>
						    					<th>Editar</th>
						    					<th>Excluir</th>
						    				</tr>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($paciente as $k => $v) {    				
						    				?>
						    				<tr id="<?php echo $v['PRONTUARIO']; ?>">
						    					<td><?php echo $v['PRONTUARIO']; ?></td>
						    					<td><?php echo $v['NOME']; ?></td>
												<td><?php echo $v['CPF']; ?></td>
												<td><?php echo $v['TELEFONE']; ?></td>
												<td><?php echo $v['DATANASCIMENTO']; ?></td>
						    					<td width="10"> 
						    						<a href=<?php echo base_url() .'/Paciente/editar/'. $v['PRONTUARIO']  ?> > 
						    							<i class="fa fa-edit fa-lg"></i> 
						    						</a>
						    					</td>
						    					<td width="10">
						    						<a href=<?php echo base_url() .'/Paciente/excluir/'. $v['PRONTUARIO']  ?> > <i class="fa fa-minus-circle fa-lg" style="color:red;"></i> </a>    
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






