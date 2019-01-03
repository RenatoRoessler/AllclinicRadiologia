<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $titulo. ' - '  ?>
        <?php 
                        if($subtitulo != ''){
                            echo $subtitulo;
                        }else {
                            foreach ($subtitulodb as $dbtitulo) {
                                echo $dbtitulo->titulo;
                            }
                        }
                        
                        ?>
        
    </title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/bibliotecas/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">


    

</head>

<body>