<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1, shrink-to-fit=no">
	<title>template master</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bibliotecas/bootstrap/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bibliotecas/font-awesome/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sb-admin.min.css') ?>">
</head>
<body class="bg-dark">
	<div class="container">
		<div class="card card-login mx-auto mt-5">
			<div class="card-header">Login</div>
			<div class="card-body">
				
					<?php 
                        echo validation_errors('<div class="alert alert-danger">','</div>');
                        echo form_open('usuarios/login');
                     ?>
					<div class="form-group">
						<label for="txt-user">Login</label>
						<input type="text" class="form-control" name="txt-user" id="txt-user"  placeholder="Digite seu Login">
					</div>
					<div class="form-group">
						<label for="txt-senha">Senha</label>
						<input type="password" class="form-control" name="txt-senha" id="txt-senha"  placeholder="Digite sua Senha">
					</div>
					<!--
					<div class="form-group">
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input">Lembrar minha Senha
							</label>
						</div>
					</div>
				    -->
					<button class="btn btn-primary btn-block">Entrar no Sistema</button>
					<!--
					<div class="text-center">
						<a href="" class="d-block small mt-3">Criar uma Conta</a>
						<a href="" class="d-block small ">Esqueceu a senha</a>
					</div>
				-->		
				<?php 
                 echo form_close();
                 ?>
			</div>
		</div>
	</div>

	<script src="<?php echo base_url('assets/bibliotecas/jquery/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bibliotecas/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bibliotecas/jquery-easing/jquery.easing.min.js') ?>"></script>
</body>
</html>