    
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
				<div class="row sys-main-title sys-title sys-title-2">
					<div class="col-xs-12 col-md-12 col-sm-12">
					<div class="col-md-2 col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSearch" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-search"></i> Filtar</button>
	      			</div>	      		
		    	</div>
		    	<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
		    	
		    	<div class="row tab-content col-xs-12 col-md-12 col-sm-12">
				<div class="form-group col-main col-sm-2 col-xs-12">
						<label for="FFDATAPESQUISA" class="sys-label col-sm-12 col-xs-12">Data Inicial</label>
					    <div class='input-group date' >
					    	<input type='text' class="form-control" id='FFDATAPESQUISA' name="FFDATAPESQUISA"   autocomplete="off" value="<?php echo $this->input->post("FFDATAPESQUISA") ? $this->input->post("FFDATAPESQUISA") : date('d/m/Y');  ?>"/>
					        <span class="input-group-addon">
					        	<span class="glyphicon glyphicon-calendar"></span>
					        </span>
					    </div>
			        </div>
					<div class="form-group col-main col-sm-2 col-xs-12">
						<label for="FFDATAFINALPESQUISA" class="sys-label col-sm-12 col-xs-12">Data Final</label>
					    <div class='input-group date' >
					    	<input type='text' class="form-control" id='FFDATAFINALPESQUISA' name="FFDATAFINALPESQUISA"   autocomplete="off" value="<?php echo $this->input->post("FFDATAFINALPESQUISA") ? $this->input->post("FFDATAFINALPESQUISA") : date('d/m/Y');  ?>"/>
					        <span class="input-group-addon">
					        	<span class="glyphicon glyphicon-calendar"></span>
					        </span>
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
						    					<th>Lote <br />Gerador</th>	
						    					<th>Lote <br />Marcação</th>
						    					<th>Calibração <br />Gerador</th>
						    					<th>Controle <br />Marcação</th>
						    					<th>Nome do <br />Paciente</th>
						    					<th>Atividade Iniciada <br />da Seringa</th>
						    					<th>Hóraio <br />Incial</th>
						    					<th>Atividade<br />Administrada</th>
						    					<th>Horáriao<br />Administração</th>
						    					<th>Lote<br />Gerador</th>
						    					<th>Lote<br />Eluição</th>
						    					<th>Pureza<br />Radionuclídica</th>
						    					<th>Aparência<br />solução Limpida</th>
						    					<th>PH</th>
						    					<th>Pureza<br />Quimica</th>
						    					<th>Responsavel<br />pelo Gerador</th>
						    					<th>KIT<br />Fabricante</th>
						    					<th>KIT<br />Fármaco</th>
						    					<th>KIT<br />Lote</th>
						    					<th>Sol<br />Orgânico</th>
						    					<th>Sol<br />Químico</th>
						    					<th>Responsável<br />pela Marcação</th>
						    				</tr>
						    			</thead>
						    			<tbody>
						    				<?php 
						    				foreach ($evolucao as $k => $v) {  			
						    				?>
						    				<tr id="<?php echo $v['CODITFRACIONAMENTO']; ?>">
						    					<td><?php echo $v['LOTEGERADOR']; ?></td>
						    					<td><?php echo $v['LOTEMARCACAO']; ?></td>
						    					<td><?php echo $v['DATAGERADOR']; ?></td>
						    					<td><?php echo $v['DATAMARCACAO']; ?></td>
						    					<td><?php echo $v['NOME']; ?></td>
						    					<td><?php echo $v['ATIVIDADE_INICIAL']; ?></td>
						    					<td><?php echo $v['HORA_INICIAL']; ?></td>
						    					<td><?php echo $v['ATIVIDADE_ADMINISTRADA']; ?></td>
						    					<td><?php echo $v['HORA_ADMINISTRADA']; ?></td>
						    					<td><?php echo $v['LOTEGERADOR']; ?></td>
						    					<td><?php echo $v['LOTEMARCACAO']; ?></td>
						    					<td><?php echo $v['PUREZA_RADIONUCLIDICA']; ?></td>
						    					<td><?php echo $v['LIMPIDA']; ?></td>
						    					<td><?php echo $v['PH']; ?></td>
						    					<td><?php echo $v['PUREZA_QUIMICA']; ?></td>
						    					<td><?php echo $v['APELUSER']; ?></td>
						    					<td><?php echo $v['KITFABRICANTE']; ?></td>
						    					<td><?php echo $v['DFARMACO']; ?></td>
						    					<td><?php echo $v['KIT_LOTE']; ?></td>
						    					<td><?php echo $v['ORGANICO']; ?></td>
						    					<td><?php echo $v['QUIMICO']; ?></td>
						    					<td><?php echo $v['USEMARCACAO']; ?></td>
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






