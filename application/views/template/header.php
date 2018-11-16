<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1, shrink-to-fit=no">
	<title>Allclinic</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bibliotecas/bootstrap/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bibliotecas/font-awesome/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sb-admin.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sysmain.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sys.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css') ?>" />

	<script src="<?php echo base_url('assets/bibliotecas/jquery/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-select.min.js') ?>" ></script>
	<script src="<?php echo base_url('assets/js/tablesorter/dist/js/jquery.tablesorter.min.js') ?>" ></script>
	<script src="<?php echo base_url('assets/js/tablesorter/dist/js/jquery.tablesorter.widgets.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/parsley.js') ?>" ></script>
	<script src="<?php echo base_url('assets/js/parsley-pt-br.js') ?>" ></script>
	
	<script src="<?php echo base_url('assets/bibliotecas/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bibliotecas/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script> 
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.pt-BR.min.js') ?>" charset="UTF-8"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script> 
	<script src="<?php echo base_url('assets/js/bootstrap-datetimepicker.pt-BR.js') ?>" charset="UTF-8"></script>
	<script src="<?php echo base_url('assets/js/jquery.mask.min.js') ?>" charset="UTF-8"></script>



	<?php if(isset($js)){ ?>
		<script src="<?php echo base_url('assets/'. $js .' ') ?>" type="text/javascript"></script>
	<?php } ?>
	</div>
	<script src="<?php echo base_url('assets/js/SYS.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/PesquisarPaciente.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/PesquisaExame.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/PesquisaAgendamento.js') ?>"></script>
	
</head>
<body class="bg-light fixed-nav sticky-footer" id="page-top"> 
	 <?php include VIEWPATH . "_includes/_dialog.php";?> 
	<!-- Navegação !-->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
		<a class="navbar-brand" href="<?php echo base_url();  ?>">Allclinic</a>
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
							<a href="<?php echo base_url('Usuarios');  ?>"> Usuários</a>
						</li>	
						<li>
							<a href="<?php echo base_url('Gerador');  ?>"> Gerador</a>
						</li>
						<li>
							<a href="<?php echo base_url('Fabricante');  ?>"> Gerador / Radiofarmaco</a>
						</li>
						<li>
							<a href="<?php echo base_url('Instituicao');  ?>"> Instituição</a>
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
							<a href="<?php echo base_url('Agendamento');  ?>"> Agendamento</a>
						</li>
						<li>
							<a href="<?php echo base_url('Paciente');  ?>"> Paciente</a>
						</li>	
						<li>
							<a href="<?php echo base_url('ConfiguracoesAgenda');  ?>"> Configuração Agenda</a>
						</li>
						<li>
							<a href="<?php echo base_url('Procedimentos');  ?>"> Procedimentos</a>
						</li>	
						<li>
							<a href="<?php echo base_url('Agenda');  ?>"> Agenda</a>
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
							<a href="<?php echo base_url('Eluicao');  ?>"> Eluição</a>
						</li>
						<li>
							<a href="<?php echo base_url('Marcacao');  ?>"> Marcação</a>
						</li>
						<li>
							<a href="<?php echo base_url('Fracionamento');  ?>"> Fracionamento</a>
						</li>
						<li>
							<a href="<?php echo base_url('Evolucao');  ?>"> Evolução</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('usuarios/logout');  ?>">
						<i class="fa fa-sign-out"></i>
						<span class="nav-link-text">Sair</span>	
					</a>
				</li>				
				
			</ul>

			<ul class="navbar-nav sidenav-toggler">
				<li class="nav-item">
					<a id="sidenavToggler" name="sidenavToggler" class="nav-link text-center">
						<i class="fa fa-fw fa-angle-left"></i>	
					</a>
				</li>
			</ul>				
			<ul class="navbar-nav ml-auto">							
				<li class="nav-item dropdown">				
					<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-user-circle fa-fw"></i>
					</a>					
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
						<a class="dropdown-item" ><?php echo $_SESSION['NOME']?></a>
						<a class="dropdown-item" ><?php echo $_SESSION['INST_FANTASIA']?></a>
					<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo base_url('usuarios/logout');  ?>" >Sair</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>

