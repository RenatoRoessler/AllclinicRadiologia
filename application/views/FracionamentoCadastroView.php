
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Fracionamento');  ?>">Fracionamento</a>  / Fracionar
					<br/>
				</li>
			</ol>

			<?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Fracionamento/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODMARCACAO1" name="FFCODMARCACAO1" value="<?php echo $marcacao[0]["CODMARCACAO"]; ?>" >	
            	<input type="hidden" class="col-sm-12 col-xs-12 form-control" id="FFPRONTUARIO" name="FFPRONTUARIO" value="" >	
				<input type="hidden"  id="FFCODAGTOEXA1" name="FFCODAGTOEXA1" value="" >	
					
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
	    			<ul class="nav nav-tabs col-sm-12 col-md-12 col-xs-12" role="tablist">
	    				<li role="presentation" class="active"><a href="#geral" aria-controls="geral" role="tab" data-toggle="tab">Geral</a></li>
					</ul>
				</div>
				<div class="row col-md-12 col-sm-12 col-xs-12" style='margin-top:3px;'></div>
				<div class="tab-content">
					<br/>
					<div role="tabpanel" class="tab-pane active" id="geral">
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFMARCACAO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFMARCACAO" name="FFMARCACAO" value="<?php echo $marcacao[0]["CODMARCACAO"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFLOTE" class="sys-label col-sm-12 col-xs-12">Lote:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFLOTE" name="FFLOTE" value="<?php echo $marcacao[0]["LOTE"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFDATA" class="sys-label col-sm-12 col-xs-12">Data:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFDATA" name="FFDATA" value="<?php echo $marcacao[0]["DATA1"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFHORA" class="sys-label col-sm-12 col-xs-12">Hora:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFHORA" name="FFHORA" value="<?php echo $marcacao[0]["HORAMINUTO"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFUSER" class="sys-label col-sm-12 col-xs-12">Usuário:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFUSER" name="FFUSER" value="<?php echo $marcacao[0]["APELUSER"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFFABRICANTE" class="sys-label col-sm-12 col-xs-12">Kit Fabricante:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFFABRICANTE" name="FFFABRICANTE" value="<?php echo $marcacao[0]["DESCRICAO"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-2 col-xs-12">
								<label for="FFFARMACO" class="sys-label col-sm-12 col-xs-12">Farmaco:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFFARMACO" name="FFFARMACO" value="<?php echo $marcacao[0]["DESCFARMACO"]; ?>"  readonly >
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFPH" class="sys-label col-sm-12 col-xs-12">Farmaco:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFPH" name="FFPH" value="<?php echo $marcacao[0]["PH"]; ?>"  readonly >
							</div>						
						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="form-group col-main col-sm-4 col-xs-12">
								<label for="FFAGENDAMENTO" class="sys-label col-sm-12 col-xs-12">Agendamento:</label>
								<div class="input-group mb-3">
								  <input type="text" class="form-control" placeholder="Agendamento" aria-label="Agendamento" aria-describedby="basic-addon2" id="FFAGENDAMENTO" readonly>
								  <div class="input-group-append">
								    <button class="btn btn-outline-secondary fa fa-search"  id="btnAgendamento" type="button" >Pesquisar</button>
								  </div>
								</div>								
							</div>
							<div class="col-xs-2 col-sm-2 pull-right">
								<label for="btnAdicionar" class="sys-label col-sm-12 col-xs-12">&nbsp; </label>
				      			<button type="button" id="btnAdicionar" class="btn btn-primary btn-sm sys-btn-search" ><i class="fa fa-plus"></i> Adicionar Agendamento</button>
			      			</div>									
						</div>
						<div class="row col-sm-12 col-xs-12">	
							<div class="col-md-12">
								<div class="panel-group" >	
									<div class="panel panel-default">									
								    	<div class="panel-body table-responsive">
								    		<table id="tableIndex" class="table table-middle table-condensed table-hover table-borderless table-striped table-bordered" style="width:100% !important;">
								    			<thead>
								    				<tr>
						    							<th>Nome</th>
						    							<th>Procedimento</th>
						    							<th>Excluir</th>
						    						</tr>
						    					</thead>
						    					<tbody>
						    						<?php 
						    						if($pacientesAdicionados){
								    				foreach ($pacientesAdicionados as $k => $v) {  			
								    				?>
								    				<tr id="<?php echo $v['CODITFRACIONAMENTO']; ?>">
								    					<td><?php echo $v['NOME']; ?></td>
								    					<td><?php echo $v['NOMEPROCEDIMENTO']; ?></td>
								    					<td width="10"> 
								    						<a href=<?php echo base_url() .'/Fracionamento/excluirItem/'. $v['CODITFRACIONAMENTO']  ?> > 
								    							<i class="fa fa-minus-circle fa-lg" style="color:red;"></i> 
								    						</a>
								    					</td>
								    				</tr>
								    			<?php } } ?>
								    			</tbody>
						    				</table>
						    			</div>
						    		</div>
						    	</div>
						    </div>
						</div>			
					</div>
				</div>
				<br/>
					<div class="col-xs-1 col-sm-1 pull-left">
		      			<button type="button" id="btnVoltar" class="btn btn-default btn-sm sys-btn-search" ><i class="fa fa-chevron-left"></i> Voltar</button>
	      			</div>
				<div class="col-xs-12 col-md-12 col-sm-12">
					<div class="col-xs-2 col-sm-2 pull-right">
		      			<button type="button" id="btnSalvar" class="btn btn-success btn-sm sys-btn-search" ><i class="fa fa-save"></i> Confirmar</button>
	      			</div>
		    	</div>
			<?php 
            echo form_close();
            ?>
		</div>
	</div>

	<?php include VIEWPATH . "_includes/_pesquisaPaciente.php"; ?>
	<?php include VIEWPATH . "_includes/_pesquisaAgendamento.php"; ?>

	<script type="text/javascript">
	    function somenteNumeros(num) {
	    	//campo.value.replace(',','.');
	        var er = /[^0-9.]/;
	        er.lastIndex = 0;
	        var campo = num;
	    	campo.value =  campo.value.replace(',','.');        
	        
	        if (er.test(campo.value)) {
	          campo.value = "";
	      	 }		 
   		}
	</script>






