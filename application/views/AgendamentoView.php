    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Agendamento
				</li>
			</ol>	
			<?php include VIEWPATH . "_includes/_mensagem.php";?> 		
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Agendamento/' ?> " method="post" class="form-horizontal" data-parsley-validate >
				<input type="hidden" class="col-sm-12 col-xs-12 form-control" name="FFPRONTUARIO" id="FFPRONTUARIO" name="FFPRONTUARIO" value= "<?php echo $this->input->post("FFPRONTUARIO") ?>" >		
				<input type="hidden" class="col-sm-12 col-xs-12 form-control"  id="FFPROCEDIMENTO" name="FFPROCEDIMENTO" value= "<?php echo $this->input->post("FFPROCEDIMENTO") ?>" >	
				<div class="row sys-main-title sys-title sys-title-2">
					<div class="col-xs-12 col-md-12 col-sm-12">

					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSearch" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-search"></i> Filtar</button>
	      			</div>	  
	      			<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnLimpar" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-eraser"></i> Limpar</button>
	      			</div>
					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnNovo" class="btn btn-info btn-sm sys-btn-search" ><i class="fa fa-file"></i> Novo Agendamento</button>
	      			</div>	      		
		    	</div>
		    	<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
		    	<div class="row tab-content col-xs-12 col-md-12 col-sm-12">
		    		<div class="form-group col-main col-sm-1 col-xs-1">
						<label for="UsuarioModel" class="sys-label col-sm-12 col-xs-12">Código:</label>
						<input type="number" class="col-sm-12 col-xs-12 form-control" id="Codigo" name="Codigo" value="<?php echo $this->input->post("Codigo") ?>" autocomplete="off" >
					</div>   		
					<div class="form-group col-main col-sm-2 col-xs-12">
						<label for="Data" class="sys-label col-sm-12 col-xs-12">Data Inicial:</label>
						<input class="form-control" type="date" value="<?php echo $this->input->post("Data") ? $this->input->post("Data") : date('Y-m-d');  ?>" id="Data" name="Data" required> 	
				    </div>
					<div class="form-group col-main col-sm-3 col-xs-12">
						<label for="FILTERNOME" class="sys-label col-sm-12 col-xs-12">Nome:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="FILTERNOME" name="FILTERNOME" value="<?php echo $this->input->post("FILTERNOME") ?>" autocomplete="off" >							
					</div>
					<div class="form-group col-main col-sm-3 col-xs-12">
						<label for="FILTERSOBRENOME" class="sys-label col-sm-12 col-xs-12">Sobrenome:</label>
						<input type="text" class="col-sm-12 col-xs-12 form-control" id="FILTERSOBRENOME" name="FILTERSOBRENOME" value="<?php echo $this->input->post("FILTERSOBRENOME") ?>" autocomplete="off" >							
					</div>
					<div class="form-group col-main col-sm-3 col-xs-12">
						<label for="FFNOMEPROCEDIMENTOTELA" class="sys-label col-sm-12 col-xs-12">Procedimento:</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Nome do Procedimento" aria-label="Nome do Procedimento" aria-describedby="basic-addon2" id="FFNOMEPROCEDIMENTOTELA" name="FFNOMEPROCEDIMENTOTELA" value= "<?php echo $this->input->post("FFNOMEPROCEDIMENTOTELA") ?>" readonly>
							<div class="input-group-append">
							    <button class="btn btn-outline-secondary fa fa-search"  id="btnPesquisaProcedimento" type="button" ></button>
							 </div>
						</div>								
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
						    					<th>Data</th>
						    					<th>Hora</th>
						    					<th>Paciente</th>						    					
												<th>Sobrenome</th>
												<th>Exame</th>
						    					<th>Editar</th>
						    				</tr>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($agendamento as $k => $v) {  
						    				$true =  '<i class="fa fa-check-circle fa-2x">';
						    				$false =  '<i class="fa fa-times-circle fa-2x">';				
						    				?>
						    				<tr id="<?php echo $v['CODAGTO']; ?>">
						    					<td><?php echo $v['CODAGTO']; ?></td>
						    					<td><?php echo $v['DATA1']; ?></td>
						    					<td><?php echo $v['HORA']; ?></td>
												<td><?php echo $v['NOME']; ?></td>
												<td><?php echo $v['SOBRENOME']; ?></td>
												<td><?php echo $v['DESCRICAO']; ?></td>
						    					<td width="10"> 
						    						<a href=<?php echo base_url() .'/Agendamento/editar/'. $v['CODAGTO']  ?> > 
						    							<i class="fa fa-edit fa-lg"></i> 
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

	<?php include VIEWPATH . "_includes/_pesquisaExame.php"; ?>






