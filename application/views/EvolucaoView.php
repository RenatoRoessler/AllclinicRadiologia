    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Evolução
				</li>
			</ol>
			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Evolucao/' ?> " method="post" class="form-horizontal" data-parsley-validate >
		
		    	<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
		    	<div class="row tab-content col-xs-12 col-md-12 col-sm-12"> 
					<div class="form-group col-main col-sm-2 col-xs-12">
						<label for="FFDATAPESQUISA" class="sys-label col-sm-12 col-xs-12">Data Inicial:</label>
						<input class="form-control" type="date" value="<?php echo $this->input->post("FFDATAPESQUISA") ? $this->input->post("FFDATAPESQUISA") : date('Y-m-d');  ?>" id="FFDATAPESQUISA" name="FFDATAPESQUISA" required> 	
				    </div>
					<div class="form-group col-main col-sm-2 col-xs-12">
						<label for="FFDATAFINALPESQUISA" class="sys-label col-sm-12 col-xs-12">Data Final:</label>
						<input class="form-control" type="date" value="<?php echo $this->input->post("FFDATAFINALPESQUISA") ? $this->input->post("FFDATAFINALPESQUISA") : date('Y-m-d');  ?>" id="FFDATAFINALPESQUISA" name="FFDATAFINALPESQUISA" required> 	
				    </div>
					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSearch" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-search"></i> Filtar</button>
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
											  	<th colspan=10 style="text-align:center;"> Dados Gerais</th>
													<th colspan=8 style="text-align:center;"> Controle de Eluição/Qualidade do Gerador de TC-99M</th>
													<th colspan=3 style="text-align:center;"> KIT Farmaco</th>
													<th colspan=2 style="text-align:center;"> Eficiência de Marcação</th>
												</tr>
											</thead>
											<thead>
						    				<tr>
						    					<th>Lote <br />Gerador</th>	
						    					<th>Lote <br />Marcação</th>
						    					<th>Calibração <br />Gerador</th>
						    					<th>Controle <br />Marcação</th>
						    					<th>Nome do <br />Paciente</th>
													<th>Código do <br />Paciente</th>
						    					<th>Atividade Iniciada <br />da Seringa</th>
						    					<th>Hóraio <br />Incial</th>
						    					<th>Atividade<br />Administrada</th>
						    					<th>Horáriao<br />Administração</th>
												  <th>Lote Eluato</th>
						    					<th>Pureza<br />Radionuclídica</th>
						    					<th>Aparência<br />solução Limpida</th>
												  <th>Pureza<br />Radioquímica</th>
						    					<th>PH</th>
						    					<th>Pureza<br />Quimica</th>
						    					<th>Responsavel<br />pelo Gerador</th>
													<th>Responsável<br />pela Marcação</th>
						    					<th>Fabricante</th>
						    					<th>Fármaco</th>
						    					<th>Lote</th>
						    					<th>Solv. Orgânico</th>
						    					<th>Solv. Químico</th>
						    					
						    				</tr>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($evolucao as $k => $v) {  
												$success = 	' <i class="fa fa-check-circle fa-3x" style="color: green;"></i>  '; 	
											    $error = '<i class="fa fa-times-circle fa-3x" style="color: red;"></i>';
						    				?>
						    				<tr id="<?php echo $v['CODITFRACIONAMENTO']; ?>">
						    					<td><?php echo $v['LOTEGERADOR']; ?></td>
						    					<td><?php echo $v['LOTEMARCACAO']; ?></td>
						    					<td><?php echo $v['DATAGERADOR']; ?></td>
						    					<td><?php echo $v['DATAMARCACAO']; ?></td>
						    					<td><?php echo $v['NOME'] .' ' . $v['SOBRENOME'] ; ?></td>
													<td><?php echo $v['CODPAC']; ?></td>
						    					<td><?php echo $v['ATIVIDADE_INICIAL']; ?></td>
						    					<td><?php echo $v['HORA_INICIAL']; ?></td>												
						    					<td><?php echo $v['ATIVIDADE_ADMINISTRADA']; ?></td>
						    					<td><?php echo $v['HORA_ADMINISTRADA']; ?></td>
												  <td><?php echo $v['LOTEELUICAO']; ?></td>
						    					<td><?php echo ($v['PUREZA_RADIONUCLIDICA'] <= 0.15) ? $success : $error ; ?></td>
						    					<td><?php echo ($v['LIMPIDA'] == 'S') ? $success : $error ; ?></td>
												  <td><?php echo ($v['PUREZA_RADIOQUIMICA'] >= 95) ? $success : $error ?></td>
						    					<td><?php echo ($v['PH'] >= 4.5 && $v['PH'] <=7.5) ? $success : $error ;  ?></td>
						    					<td><?php echo ($v['PUREZA_QUIMICA']=='S') ? $success : $error ;  ?></td>
						    					<td><?php echo $v['APELUSER']; ?></td>
													<td><?php echo $v['USEMARCACAO']; ?></td>
						    					<td><?php echo $v['KITFABRICANTE']; ?></td>
						    					<td><?php echo $v['DFARMACO']; ?></td>
						    					<td><?php echo $v['LOTEFARMACO']; ?></td>
						    				  <td><?php echo ($v['ORGANICO'] >= $v['SOLV_ORGANICO']) ? $success : $error ;?></td>
						    				  <td><?php echo ($v['INORGANICO'] >= $v['SOLV_INORGANICO']) ? $success : $error ; ?></td>
						    					
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






