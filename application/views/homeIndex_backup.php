<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1, shrink-to-fit=no">
	<title>Allclinic</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bibliotecas/bootstrap/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bibliotecas/font-awesome/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sb-admin.min.css') ?>">
</head>
<body class="bg-dark fixed-nav sticky-footer" id="page-top">
	<!-- Navegação !-->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
		<a class="navbar-brand" href="inde.html">Allclinic</a>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCurso" aria-control="navbarCurso" aria-expanded="false" aria-label="Navegação Toggle">
			<span class="navbar-toggler-icon"></span>
			
		</button>
		<div id="navbarCurso" class="collapse navbar-collapse">
			<ul class="navbar-nav navbar-sidenav" id="linksaccordion">
				<li class="nav-item">
					<a class="nav-link nav-link-collapse collapse" href="#linksCadastros" data-toggle="collapse" data-parent="#linksaccordion">
						<i class="fa fa-fw fa-file"></i>
						<span class="nav-link-text">Cadastros</span>				
					</a>
					<ul class="sidenav-second-level collapse"  id="linksCadastros">
						<li>
							<a href="login.html"> Usuários</a>
						</li>	
						<li>
							<a href="recuperar.html"> Gerador</a>
						</li>
						<li>
							<a href="registro.html"> Farmaco</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link nav-link-collapse collapse" href="#linksAgenda" data-toggle="collapse" data-parent="#linksaccordion">
						<i class="fa fa-fw fa-calendar"></i>
						<span class="nav-link-text">Agenda</span>				
					</a>
					<ul class="sidenav-second-level collapse"  id="linksAgenda">
						<li>
							<a href="login.html"> Paciente</a>
						</li>	
						<li>
							<a href="recuperar.html"> Agenda</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link nav-link-collapse collapse" href="#linksEvolucao" data-toggle="collapse" data-parent="#linksaccordion">
						<i class="fa fa-fw fa-exchange"></i>
						<span class="nav-link-text">Evolução</span>				
					</a>
					<ul class="sidenav-second-level collapse"  id="linksEvolucao">
						<li>
							<a href="login.html"> Raadiofarmaco</a>
						</li>	
						<li>
							<a href="recuperar.html"> Eluição</a>
						</li>
						<li>
							<a href="recuperar.html"> Marcação</a>
						</li>
						<li>
							<a href="recuperar.html"> Evolução</a>
						</li>
					</ul>
				</li>
			</ul>
			<ul class="navbar-nav sidenav-toggler">
				<li class="nav-item">
					<a id="sidenavToggler" class="nav-link text-center">
						<i class="fa fa-fw fa-angle-left"></i>	
					</a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-fw fa-envelope"> </i>
						<span class="d-lg-none">
							Mensagens
							<span class="badge badge-pill badge-primary">12 novas</span>
						</span>
						<span class="indicator text-primary d-none d-lg-block">
							<i class="fa fa-fw fa-circle"></i>
						</span>
					</a>
					<div class="dropdown-menu" aria-labelledby="messagesDropdown">
						<h6 class="dropdown-header">Novas Mensagens</h6>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">
							<strong> José Francisco</strong>
							<span class="small float-right text-muted">14:30</span>
							<div class="dropdown-message small">
								loren
							</div>
							<div class="dropdown-divider"></div>
						</a>
						<a class="dropdown-item" href="#">
							<strong> Maria caolina</strong>
							<span class="small float-right text-muted">14:30</span>
							<div class="dropdown-message small">
								loren
							</div>
							<div class="dropdown-divider"></div>
						</a>
						<a class="dropdown-item" href="#">
							<strong> Mauro lodi</strong>
							<span class="small float-right text-muted">14:30</span>
							<div class="dropdown-message small">
								vou pagar o lanche
							</div>
							<div class="dropdown-divider"></div>
						</a>
						
					</div>
				</li>

				<li class="nav-item">
					<form class="form-inline my-2 my-lg-0 mr-lg-2">
						<div class="input-group">
							<input type="text" name="form-control" placeholder="Pesquisar por ...">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button">
									<i class="fa fa-search"></i>
								</button>
							</span>
						</div>
					</form>	
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('usuarios/logout');  ?>">
						<i class="fa fa-sign-out">Logout</i>
					</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="content-wrapper">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="index.html">Home</a>
				</li>
				<li class="breadcrumb-item">
					Pagina em branco
				</li>
			</ol>
			<div class="row">
				<div class="col-12">
					<h1>titulo da pagina</h1>
					<p>lore	</p>
				</div>
			</div>
		</div>
		<footer class="sticky-footer">
			<div class="container">
				<div class="text-center">
					<small>Copyright Renato 2018</small>
					
				</div>
			</div>
			
		</footer>
	</div>

	<script src="<?php echo base_url('assets/bibliotecas/jquery/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bibliotecas/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bibliotecas/jquery-easing/jquery.easing.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/sb-admin.min.js') ?>" type="text/javascript"></script>
</body>
</html>