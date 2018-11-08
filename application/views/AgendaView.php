	<div class="content-wrapper" >
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					Agenda
				</li>
			</ol>

			<form id="formulario" name="formulario" action="<?php echo base_url() .'/Agenda/' ?> " method="post" class="form-horizontal" data-parsley-validate  >

				<div class="row col-sm-12 col-xs-12">
					<div class="form-group col-main col-sm-2 col-xs-12">
						<div id="pickyDate" ></div>
						<div> 
						    <input type="text" id="datafiltro" name="datafiltro" value="" hidden >
						</div>
						
		      			<div class="col-main col-sm-12 col-xs-12">
							<label for="FFAGENDA" class="sys-label col-sm-12 col-xs-12">Agenda:</label>	
							<select class="form-control form-control-sm" id="FFAGENDA" name="FFAGENDA" data-live-search="true">
							<option <?php if( $ConfiguracoesAgendaModel[0]["CODAGTO"] == "") echo "selected"; ?> value="">Selecione a Agenda</option>
							<?php
								foreach ($ConfiguracoesAgendaModel as $k => $v) {
								$sel = ($v["CODAGTO"] == $retorno[0]["CODAGTO"]  ) ? 'selected' : '';
							?>
								<option value="<?php echo $v['CODAGTO'];?>" <?php echo $sel; ?> > <?php echo $v["DESCRICAO"]; ?> </option>
								<?php  
									}
								?>		
							</select>
						</div>
						<div class="col-md-12 col-xs-12 col-sm-12 p-3">
			     			<button type="button" id="btnSearch" class="btn btn-primary btn-sm sys-btn-search " ><i class="fa fa-search" ></i> Filtar</button>
		      			</div>
					</div>
					<!-- Agenda -->
					<div class="form-group col-main col-sm-9 col-xs-12">
						

						<div class="row col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-12">
							<div class="panel-group" >	
								<div class="panel panel-default">
								
							    	<div class="panel-body table-responsive">
							    		<table id="tableIndex" class="table table-middle table-condensed table-hover table-borderless table-striped table-bordered" style="width:100% !important;">
							    			<thead>
							    				<tr>
							    					<th></th>	
							    					<th></th>
							    					<th></th>	
							    				</tr>
							    			</thead>
							    			<tbody>
							    				<?php 
							    					foreach ($horarios as $k => $v) { 
							    				 ?>
							    				<tr id="">
							    					<td><?php echo $v; ?></td>
							    					<td></td>
							    					<td></td>
							    				</tr>
												<?php } ?>
							    			</tbody>
							    		</table>
							    	</div>

							    </div>						  
							</div>
						</div>
						</div>


					</div>
				</div>			
			</form>
		</div>
	</div>
