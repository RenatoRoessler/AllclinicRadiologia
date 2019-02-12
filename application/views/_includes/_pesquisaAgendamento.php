<script type="text/placeholder" id="DialogPesquisaAgendamento">
<div class='row col-sm-12 col-md-12 col-xs-12'>
    <div class="form-group col-main col-sm-3 col-xs-12">
		<!--
		<label for="FFDATAHORAFILTRO" class="sys-label col-sm-12 col-xs-12">Data:</label>
		<div class='input-group date' >
			<input type='text' class="form-control" id='FFDATAHORAFILTRO' name="FFDATAHORAFILTRO" value="<?php echo   date ("d/m/Y")  ?>"  autocomplete="off"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			 </span>
		</div>
		-->
			<label for="FFDATAHORAFILTRO" class="sys-label col-sm-12 col-xs-12">Date</label>
			<input class="form-control" type="date" value="<?php echo   date ("Y-m-d")  ?>" id="FFDATAHORAFILTRO" name="FFDATAHORAFILTRO" > 								
	</div>
    <div class="col-main col-md-7 col-sm-7 col-xs-10" id="divNome">
		<label class="sys-label col-sm-12 col-xs-12">Nome Paciente:</label>
		<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="FFNOMEPAC" value="" autocomplete="off"  placeholder="Informe o Nome" style="text-transform:uppercase" >
	</div>
    
    <div class="col-main col-md-1 col-sm-1 col-xs-2">
    	<label class="sys-label col-sm-12 col-xs-12">&nbsp;</label>
		<button type="button" id="btnFiltrarAgendamentos" class="btn btn-primary btn-xs glyphicon glyphicon-search" style="top:-1px;" ><span> Filtrar</span></button>
	</div>
</div>
<div class='col-sm-12 col-md-12 col-xs-12 divisor'></div>
<div class='col-sm-12 col-md-12 col-xs-12'>
    <div class="panel-body table-responsive sys-texto-padrao-container">
		<table id="tableAgendamentos" class="table table-middle table-condensed table-hover" style="width:100% !important;">
			<thead>
				<tr>
					<th>Código</th>
					<th>Data</th>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Exame</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<input type="text" class="col-sm-12 col-xs-12 form-control input-sm" id="FFCODAGTOEXA" value="" hidden >

