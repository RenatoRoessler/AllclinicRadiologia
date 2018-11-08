    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Instituições
				</li>
			</ol>
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Instituicao/' ?> " method="post" class="form-horizontal" data-parsley-validate >
				<div class="row sys-main-title sys-title sys-title-2">
					<div class="col-xs-12 col-md-12 col-sm-12">
					
					<div class="col-md-2 col-xs-1 col-sm-2 pull-right">
		      			<button type="button" id="btnNovo" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-file"></i> Cadastrar</button>
	      			</div>
	      		
		    	</div>
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
						    					<th>Fantasia</th>
						    					<th>Razão</th>
						    					<th>CNPJ</th>
						    					<th>Editar</th>	
						    					<th>Excluir</th>	
						    				</tr>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($instituicao as $k => $v) {    				
						    				?>
						    				<tr id="<?php echo $v['CODINST']; ?>">
						    					<td><?php echo $v['CODINST']; ?></td>
						    					<td><?php echo $v['FANTASIA']; ?></td>
						    					<td><?php echo $v['RAZAO']; ?></td>
						    					<td><?php echo $v['CNPJ']; ?></td>
						    					<td width="10"> 
						    						<a href=<?php echo base_url() .'/Instituicao/editar/'. $v['CODINST']  ?> > 
						    							<i class="fa fa-edit fa-lg "></i> 
						    						</a>
						    					</td>
						    					<td width="10">
						    						<a href=<?php echo base_url() .'/Instituicao/excluir/'. $v['CODINST']  ?> > <i class="fa fa-minus-circle fa-lg" style="color:red;"></i> </a>    
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
<div class="row col-md-11 col-sm-11 col-xs-11 sys-btn-action-base-container">
	<div class="col-sm-1 col-xs-2">
		<button class="btn btn-warning sys-btn-action-base" id="btnEditar" 
			data-toggle="tooltip" data-placement="top" title="Editar" ><i class="fa fa-pencil"></i></button>
	</div>
</div>





