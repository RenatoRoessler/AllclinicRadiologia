    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Usuários
				</li>
			</ol>
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Usuarios/' ?> " method="post" class="form-horizontal" data-parsley-validate >
				<div class="row sys-main-title sys-title sys-title-2">
					<div class="col-xs-12 col-md-12 col-sm-12">

					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSearch" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-search"></i> Filtar</button>
	      			</div>	  
	      			<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnLimpar" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-eraser"></i> Limpar</button>
	      			</div>
					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnNovo" class="btn btn-info btn-sm sys-btn-search" ><i class="fa fa-file"></i> Novo Usuario</button>
	      			</div>	      		
		    	</div>
		    	<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
		    	<div class="row tab-content col-xs-12 col-md-12 col-sm-12">
		    		<div class="form-group col-main col-sm-2 col-xs-2">
						<label for="Login" class="sys-label col-sm-12 col-xs-12">Login:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Login" name="Login" value="<?php echo $this->input->post("Login") ?>"  style="text-transform:uppercase" >
					</div>	
					<div class="form-group col-main col-sm-3 col-xs-3">
						<label for="Nome" class="sys-label col-sm-12 col-xs-12">Nome:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="Nome" name="Nome" value="<?php echo $this->input->post("Nome") ?>"  style="text-transform:uppercase" >
					</div>
					<div class="col-main col-sm-3 col-xs-3">
						<label for="Instituicao" class="sys-label col-sm-12 col-xs-12">Instituição:</label>	
						<select class="form-control form-control-sm" id="Instituicao" name="Instituicao" data-live-search="true">
						<option <?php if( $this->input->post("Instituicao") == "") echo "selected"; ?> value="">Selecione a Conta</option>
								<?php
									foreach ($instituicao as $k => $v) {
									$sel = ($v["CODINST"] == $this->input->post("Instituicao")  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODINST'];?>" <?php echo $sel; ?> > <?php echo $v["FANTASIA"]; ?> </option>
									<?php  
										}
									?>
									
						</select>
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
						    					<th>Login</th>	
						    					<th>Nome</th>
						    					<th>Email</th>
						    					<th>Instituição</th>
						    					<th>Editar</th>
						    					<th>Excluir</th>
						    				</tr>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($usuario as $k => $v) {    				
						    				?>
						    				<tr id="<?php echo $v['APELUSER']; ?>">
						    					<td><?php echo $v['APELUSER']; ?></td>
						    					<td><?php echo $v['NOME']; ?></td>
												<td><?php echo $v['EMAIL']; ?></td>
												<td><?php echo $v['RAZAO']; ?></td>
						    					<td width="10"> 
						    						<a class="btn btn-default" href=<?php echo base_url() .'/Usuarios/editar/'. $v['APELUSER']  ?> > 
						    							<i class="fa fa-edit fa-lg"></i> 
						    						</a>
						    					</td>
						    					<td width="10"> 						    					
						    						<a class="btn btn-default" href=<?php echo base_url() .'/Usuarios/excluir/'. $v['APELUSER']  ?> > <i class="fa fa-minus-circle fa-lg" style="color:red"></i> </a>  
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






