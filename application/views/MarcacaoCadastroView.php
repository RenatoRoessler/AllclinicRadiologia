
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php echo base_url('Marcacao');  ?>">Marcação</a>  / Cadastros
					<br/>
				</li>
			</ol>

			 <?php include VIEWPATH . "_includes/_mensagem.php";?> 

			<?php 
			echo validation_errors('<div class="alert alert-danger">','</div>');
			$attributes = array('class' => 'form-horizontal', 'id' => 'formularioCadastro','name' => 'formularioCadastro');
			$action  =  base_url() .'Marcacao/atualizar';
            echo form_open($action , $attributes);
            ?>
            	<input type="hidden" id="FFCODMARCACAO1" name="FFCODMARCACAO1" value="<?php echo $retorno[0]["CODMARCACAO"]; ?>" >			
		    	<!-- ABAS -->
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnExcluirMarcacao" class="btn btn-danger btn-sm sys-btn-search" ><i class="fa fa-trash"></i> Excluir</button>
	      			</div>
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
								<label for="FFCODMARCACAO" class="sys-label col-sm-12 col-xs-12">Código:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFCODMARCACAO" name="FFCODMARCACAO" value="<?php echo $retorno[0]["CODMARCACAO"]; ?>"  readonly >
							</div>
							<div class="col-main col-sm-3 col-xs-12">
								<label for="FFELUICAO" class="sys-label col-sm-12 col-xs-12">Eluição:</label>	
								<select class="form-control form-control-sm" id="FFELUICAO" name="FFELUICAO" >
								<option <?php if( $retorno[0]["CODELUICAO"] == "") echo "selected"; ?> value="">Selecione a Eluição</option>
								<?php
									foreach ($eluicao as $k => $v) {
									$sel = ($v["CODELUICAO"] == $retorno[0]["CODELUICAO"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODELUICAO'];?>" <?php echo $sel; ?> > <?php echo 'Gerador: ' . $v["LOTEGERADOR"] .' /Eluição: ' . $v["LOTE"]  .'  -  ' .$v["DATA1"] . ' - ' .$v["HORA"]; ?> </option>
									<?php  
										}
									?>									
								</select>
							</div>
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFLOTE" class="sys-label col-sm-12 col-xs-12">Lote:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFLOTE" name="FFLOTE" value="<?php echo $retorno[0]["LOTE"];  ?>" autocomplete="off" readonly>
							</div>
							 <div class="form-group col-main col-sm-2 col-xs-12">
					        	<label for="FFDATAHORA" class="sys-label col-sm-12 col-xs-12">Data Controle:</label>
					            <div class='input-group date' >
					                <input type='text' class="form-control" id='FFDATAHORA' name="FFDATAHORA" value="<?php echo $retorno[0]["DATA1"] ?  $retorno[0]["DATA1"] :  date ("d/m/Y")  ?>"  autocomplete="off"/>
					                <span class="input-group-addon">
					                      <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					        </div>
					        <div class="col-main col-sm-2 col-xs-12">
       							<label  for="FFHORA" class="sys-label col-sm-12 col-xs-12">Hora Controle</label>
        						<input class="col-sm-12 col-xs-12 form-control" type="time" id="FFHORA" name="FFHORA" min="00:00" max="24:00" required value="<?php echo $retorno[0]['HORA'] ? $retorno[0]['HORA'] : date("H:i")  ?>" />
    						</div>
											        		
						</div>
						<div class="row col-sm-12 col-xs-12">
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFKITFABRICANTE" class="sys-label col-sm-12 col-xs-12">KIT Fabricante:</label>	
								<select class="form-control form-control-sm" id="FFKITFABRICANTE" name="FFKITFABRICANTE" data-live-search="true"
								data-sfa='FFFARMACO' 
								data-sft="<?php echo criptLow( 'FARMACO' );?>" 
								data-sfci="<?php echo criptLow( 'CODFARMACO' );?>" 
								data-sfcl="<?php echo criptLow( 'DESCRICAO' );?>" 
								data-sfw="<?php echo criptLow( "where  CODFARMACO  in(select CODFARMACO from FABRICANTEFARMACO where CODFABRICANTE = {V}) " );?>" 
								data-sfwa="<?php echo criptLow( "where 1 = 1 " );?> ">
								<option <?php if(  $retorno[0]["KIT_CODFABRICANTE"] == '' ) echo "selected"; ?> value="">Selecione o Fabricante</option>
								<?php
									foreach ($fabricantes as $k => $v) {
									$sel = ($v["CODFABRICANTE"] == $retorno[0]["KIT_CODFABRICANTE"]  ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODFABRICANTE'];?>" <?php echo $sel; ?> > <?php echo $v["DESCRICAO"]  ?> </option>
									<?php  
										}
									?>									
								</select>
							</div>
							<div class="col-main col-sm-2 col-xs-12">
								<label for="FFFARMACO" class="sys-label col-sm-12 col-xs-12">Farmaco:</label>	
								<select class="form-control form-control-sm" id="FFFARMACO" name="FFFARMACO" >
								<option <?php if( $retorno[0]["CODFARMACO"] == "") echo "selected"; ?> value="">Selecione o Farmaco</option>
								<?php
									foreach ($farmaco as $k => $v) {
									$sel = ( $v["CODFARMACO"] == $retorno[0]["CODFARMACO"] ) ? 'selected' : '';
								?>
									<option value="<?php echo $v['CODFARMACO'];?>" <?php echo $sel; ?> > <?php echo $v["DESCRICAO"]  ?> </option>
									<?php  
										}
									?>									
								</select>
							</div>
																				
							<div class="form-group col-main col-sm-1 col-xs-12">
								<label for="FFKITLOTE" class="sys-label col-sm-12 col-xs-12">KIT Lote:</label>
								<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFKITLOTE" name="FFKITLOTE" value="<?php echo $retorno[0]["KIT_LOTE"];  ?>" autocomplete="off">
							</div>
							
							<div class="col-main col-sm-1 col-xs-12">
								<label for="FFCQ" class="sys-label col-sm-12 col-xs-12">C.Q:</label>
								<select class="form-control form-control-sm col-sm-12 col-xs-12 " id="FFCQ" name="FFCQ" onchange="mostraDiv()">
									<option <?php if( $retorno[0]["CQ"] == "S") echo "selected"; ?> value="S">Sim</option>
									<option <?php if( $retorno[0]["CQ"] == "N") echo "selected"; ?> value="N">Não</option>						
								</select>
							</div>														
						</div>
						<div class="row col-sm-12 col-xs-12" style="visibility: hidden;" id="EFICIENCIA">
							<div class="row col-sm-3 col-xs-12">	
								<div class="form-group col-main col-sm-12 col-xs-12">			
									<div class="card">
									  	<div class="card-header">
									    	Eficiência da Marcaçao
									  	</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFPH" class="sys-label col-sm-12 col-xs-12">PH:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFPH" name="FFPH" value="<?php echo $retorno[0]["PH"];  ?>" autocomplete="off">
										</div>									  	
									  	<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFORGANICO" class="sys-label col-sm-12 col-xs-12">Organico:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFORGANICO" name="FFORGANICO" value="<?php echo $retorno[0]["ORGANICO"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
										</div>
										<div class="form-group col-main col-sm-12 col-xs-12">
											<label for="FFQUIMICO" class="sys-label col-sm-12 col-xs-12">Quimico:</label>
											<input type="text" class="col-sm-12 col-xs-12 form-control" id="FFQUIMICO" name="FFQUIMICO" value="<?php echo $retorno[0]["QUIMICO"];  ?>" onkeyup="somenteNumeros(this);" autocomplete="off">
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
					<div class="col-xs-1 col-sm-1 pull-right">
		      			<button type="button" id="btnSalvar" class="btn btn-success btn-sm sys-btn-search" ><i class="fa fa-save"></i> Salvar</button>
	      			</div>
		    	</div>
			<?php 
            echo form_close();
            ?>

		</div>
	</div>
	
	
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

   		function mostraDiv()
		{
			var e = document.getElementById("FFCQ");
			var itemSelecionado = e.options[e.selectedIndex].value;
			if(itemSelecionado != 'S'){
				document.getElementById('EFICIENCIA').style.visibility = "hidden"; 
			}else{
				document.getElementById('EFICIENCIA').style.visibility = "visible"; 
			}
			return false;  
		}
		mostraDiv();

	</script>






