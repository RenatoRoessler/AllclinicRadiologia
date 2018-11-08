<script type="text/placeholder" id="DialogLaudoPadrao">
<div class='row col-sm-12 col-md-12 col-xs-12'>
	<label class="radio-inline"><input type="radio" name="filtro" id="opProntuario" onchange="mostraFiltro()"> Prontuario  &nbsp;&nbsp; </label>
	<label class="radio-inline"><input type="radio" name="filtro" id="opNome" checked="true" onchange="mostraFiltro()"> Nome   &nbsp;&nbsp;</label>
</div>
<div class='row col-sm-12 col-md-12 col-xs-12'>
    <div class="col-main col-md-11 col-sm-11 col-xs-10" id="divNome">
		<label class="sys-label col-sm-12 col-xs-12">Nome:</label>
		<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="NomeTextoPadrao" value="" autocomplete="off" minlength="10" maxlength="70"  placeholder="Informe o Nome" style="text-transform:uppercase" >
	</div>
	<div class="col-main col-md-11 col-sm-11 col-xs-10" id="divProntuario" style="display:none;"">
		<label class="sys-label col-sm-12 col-xs-12">Prontuario:</label>
		<input type="number" class="col-sm-12 col-xs-12 form-control input-sm" id="FFFiltroPRONTUARIO" value="" autocomplete="off" >
	</div>
	<div class="col-main col-md-11 col-sm-11 col-xs-10" id="divCPF" style="display:none;">
		<label class="sys-label col-sm-12 col-xs-12">CPF:</label>
		<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="FFFiltroCPF" value="" autocomplete="off"  minlength="19" maxlength="15" placeholder="CPF.: 000.000.000-00" >
	</div>

    <div class="col-main col-md-1 col-sm-1 col-xs-2">
    	<label class="sys-label col-sm-12 col-xs-12">&nbsp;</label>
		<button type="button" id="btnFiltraLaudoPadrao" class="btn btn-primary btn-xs glyphicon glyphicon-search" style="top:-1px;" ><span> Filtrar</span></button>
	</div>
</div>
<div class='col-sm-12 col-md-12 col-xs-12 divisor'></div>
<div class='col-sm-12 col-md-12 col-xs-12'>
    <div class="panel-body table-responsive sys-texto-padrao-container">
		<table id="tableTextoPadrao" class="table table-middle table-condensed table-hover" style="width:100% !important;">
			<thead>
				<tr>
					<th>Prontuário</th>
					<th>Nome</th>
					<th>CPF</th>
					<th>Nascimento</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="FFPRONTUARIORETORNO" value="" hidden >




</script>


<script type="text/javascript">
	function mostraFiltro()
		{
			document.getElementById("NomeTextoPadrao").value = "";
			document.getElementById("FFFiltroPRONTUARIO").value = "";
			//document.getElementById("FFFiltroCPF").value = "";
			if ($("#opProntuario").prop("checked")) {
			    document.getElementById("divNome").style.display = 'none';
			    document.getElementById("divProntuario").style.display = 'block';
			    document.getElementById("divCPF").style.display = 'none';
			 }
			 if($("#opNome").prop("checked")) {
			  	document.getElementById("divNome").style.display = 'block';
			  	document.getElementById("divProntuario").style.display = 'none';
			  	document.getElementById("divCPF").style.display = 'none';
			}
			if($("#opCPF").prop("checked")) {
			  	document.getElementById("divNome").style.display = 'none';
			  	document.getElementById("divProntuario").style.display = 'none';
			  	document.getElementById("divCPF").style.display = 'block';
			 }			
		}

</script>