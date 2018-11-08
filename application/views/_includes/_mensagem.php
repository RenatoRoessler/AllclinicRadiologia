<div class="sys-hide" id="mensagem" onclick="$(this).fadeOut('fast')">
	<div id="mensagem-texto" class="alert" role="alert"></div>
</div>
<?php
	//	Mensagem padrão
    if(isset($MSG) ){
		if( isVal( $MSG[0] ) && isVal( $MSG[1] ) ) {
			echo "<script>mensagem('$MSG[0]','$MSG[1]');</script>";
			$_SESSION['MSG'] =  NULL;
		}
	}

?>