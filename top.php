<?php
include_once ('conexao.php');
if($_SESSION['id_usuario'] == false){
  header('Location: index.php ');
}
$query = "SELECT * FROM amigos WHERE iduser = '$usuariosession' and amigo = 2";
$result = $conexao->query($query);
foreach ($result as $o){
  if($o['iduser'] == $usuariosession){
    $row_cnt_frd = mysqli_num_rows($result);
  }
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>DiZ</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link rel="stylesheet" href="css/body.css">
        <script src="https://code.jquery.com/jquery-3.4.1.js" ></script>
      </head>
    <body>
        <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="perfil.php">DiZ</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                  <a class="nav-link" href="perfil.php">
                    <i class="fa fa-home"></i>
                    Inicio
                    <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="logoff.php">
                      <i class="fas fa-door-open"></i>
                    Sair
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-cog"></i>
                    Opções
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="ownpost.php">Minhas postagens</a>
                  <a class="dropdown-item" href="editar-perfil.php">Editar perfil</a> 
                    
                </li>
              </ul>
              <div class="dropdown">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown" >    
              <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user-friends"></i>
                  <span class="badge badge-success"><?php echo $row_cnt_frd;?></span>  
                </a>
                <div class="dropdown-menu" >
                  <?php
                  foreach ($result as $o){
                    if($o['iduser'] == $usuariosession){
                      $idamigo = $o['id'];
                      $queryfrd = "SELECT * FROM usuario WHERE id_usuario = $idamigo";
                      $resultado = $conexao->query($queryfrd);
                      
                      foreach ($resultado as $a){
                        $nomeAmigo = $a['nome'];
                        $imgAmigo = $a['img'];
                        echo '
                        <div class="dropdown-item">
                        <div  style="max-width: 800px;">
                            <a  href="perfil.php?id='.$idamigo.'"> <img class=" rounded mx-auto d-block" width="50" height="50" src="'.$imgAmigo.'" alt=""> </a>
                            </div>
                            <div class="card-body">
                                <h5 class=""><a href="perfil.php?id='.$idamigo.'">'.$nomeAmigo.'</a></h5>
                                <a class="" href="amigo.php?acamg='.$idamigo.'">Aceitar</a>
                                <a class="" href="amigo.php?caamg='.$idamigo.'">Recusar</a>
                            </div>
                            </div>
                           
                            
                        
                    ';
                      }
                      ;
                    }
                  }
                  if ($row_cnt_frd == 0){
                    echo '<p class="dropdown-item">Nenhuma solicitação de amizade </p>';
                  } 
                     ?> 
                     </li>
                    </ul>
                     </div>  
                
                <form class="form-inline my-2 my-lg-0" method="POST" action="search.php">
                <input class="form-control mr-sm-2" type="text" placeholder="Pesquisar"  name="nome" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                
              </form>
              
            </div>
          </nav>
