    
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo base_url();  ?>">Home</a>
				</li>
				<li class="breadcrumb-item">
					ImportarAgenda
				</li>
			</ol>
			<?php include VIEWPATH . "_includes/_mensagem.php";?> 
			<form id="formulario" name="uploadCSV" action="<?php echo base_url() .'/ImportarAgenda/Importar' ?> " method="post" class="form-horizontal"   enctype="multipart/form-data"  data-parsley-validate >
				<div class="row col-sm-12 col-xs-12">
					<div class="col-xs-8 col-sm-8 ">
						<label class="col-md-4 control-label">Choose CSV File</label>
						<input	type="file" name="file" id="file" accept=".csv">
					</div>					
					<div class="col-xs-2 col-sm-2 ">
						<button type="button" id="btnSalvar" class="btn btn-success btn-sm sys-btn-search" ><i class="fa fa-save"></i> Importar</button>
					</div>
				</div>					
				<br />
			<div id="labelError"></div>				
			</form>
		</div>
	</div>




	






