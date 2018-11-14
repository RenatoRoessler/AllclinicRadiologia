<script type="text/placeholder" id="DialogPesquisaProcedimento">
<div class='row col-sm-12 col-md-12 col-xs-12'>
    <div class="col-main col-md-11 col-sm-11 col-xs-10" id="divNome">
		<label class="sys-label col-sm-12 col-xs-12">Descrição:</label>
		<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="FFNOMEPROCEDIMENTO" value="" autocomplete="off" minlength="10" maxlength="70"  placeholder="Informe o Nome" style="text-transform:uppercase" >
	</div>
    
    <div class="col-main col-md-1 col-sm-1 col-xs-2">
    	<label class="sys-label col-sm-12 col-xs-12">&nbsp;</label>
		<button type="button" id="btnFiltrarProcedimentos" class="btn btn-primary btn-xs glyphicon glyphicon-search" style="top:-1px;" ><span> Filtrar</span></button>
	</div>
</div>
<div class='col-sm-12 col-md-12 col-xs-12 divisor'></div>
<div class='col-sm-12 col-md-12 col-xs-12'>
    <div class="panel-body table-responsive sys-texto-padrao-container">
		<table id="tableExames" class="table table-middle table-condensed table-hover" style="width:100% !important;">
			<thead>
				<tr>
					<th>Código</th>
					<th>Descrição</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="FFCODPROCEDIMENTO" value="" hidden >
