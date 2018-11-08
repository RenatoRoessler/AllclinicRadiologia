<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Allclinic</title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bibliotecas/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bibliotecas/font-awesome/css/font-awesome.min.css') ?>">    

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bibliotecas/style3.css') ?>">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

   
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                <h3>Allclinic</h3>
            </div>

            <ul class="list-unstyled components">
                 <!--<p>Dummy Heading</p> -->
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Cadastros</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
							<a href="<?php echo base_url('Usuarios');  ?>"> Usuários</a>
						</li>	
						<li>
							<a href="<?php echo base_url('Gerador');  ?>"> Gerador</a>
						</li>
						<li>
							<a href="<?php echo base_url('Fabricante');  ?>"> Fabricante</a>
						</li>
						<li>
							<a href="registro.html"> Farmaco</a>
						</li>
						<li>
							<a href="<?php echo base_url('Instituicao');  ?>"> Instituição</a>
						</li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Agenda</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
							<a href="login.html"> Paciente</a>
						</li>	
						<li>
							<a href="recuperar.html"> Agenda</a>
						</li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Evolução</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
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
                <li>
                    <a class="nav-link" href="<?php echo base_url('usuarios/logout');  ?>">
						<i class="fa fa-sign-out"></i>
						<span class="nav-link-text">Sair</span>	
					</a>
                </li>

            </ul>

        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span> Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>