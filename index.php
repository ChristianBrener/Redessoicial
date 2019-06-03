<?php
  session_start();
  include_once ("conexao.php");
  
  if($_SESSION['id_usuario'] == true){
    header('Location: perfil.php ');
  }
  if (isset($_POST['post'])){
    $usuario = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $query = "SELECT id_usuario FROM usuario Where (email = '$usuario' AND senha = md5('$senha'))";
    $result = $conexao->query($query);
    $row = mysqli_num_rows($result);
    if($row == 1){ 
      foreach($result as $p){
        $_SESSION['id_usuario'] = $p['id_usuario']; 
      }
      header('Location: perfil.php');
      exit();
    }else{
      $alert ='<div class="alert alert-danger" role="alert">
      Usuário ou senha incorreto!
      </div>';
    }
  }
  
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
	<title>DiZ</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="css/login1.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Entrar</h3>

			</div>
			<div class="card-body">
			    <?php echo $alert; ?>
				<form method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-at"></i></span>
						</div>
						<input type="text" class="form-control" name="email" placeholder="Email">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" name="senha" placeholder="Senha">
					</div>

					<div class="form-group">
						<input type="submit" value="Login" name="post" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Não tem conta? <a href="cadastrar.php"> Cadastrar</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>