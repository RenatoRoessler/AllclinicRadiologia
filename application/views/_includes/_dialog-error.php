<?php 
//	Define link para redirecionamento após o erro
$exp = explode("/", $_SERVER['HTTP_REFERER'] );
$des = preg_replace("/[^a-z]/i", "", $_SERVER["REQUEST_URI"]);
( $exp[3] != $des ) ? $link = $_SERVER['HTTP_REFERER'] : $link = "/" ;
?>
<div class="modal fade sys-modal-error" id="dialogoError" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialogoError" aria-labelledby="dialogoTituloError" aria-hidden="true">
	<div class="modal-dialog" style="z-index: 7000;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title sys-error-label" id="dialogoTituloError">Alerta de Erro</h5>
			</div>
			<div class="modal-body" id='dialogoTextoError'>
				<p>Ocorreu um erro durante a execução do aplicativo.</p>
				<?php echo $mensagemError;?>
			</div>
			<div class="modal-footer" id='dialogoAcaoError'>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="ir('<?php echo $link;?>');" >Ok</button>
			</div>
		</div>
	</div>
</div>
<?php if( $mensagemError ) {?>
<script>$("document").ready(function(){dialogoError();});</script>
<?php }?>