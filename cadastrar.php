<?php
    include_once ("conexao.php");
    session_start();
    if($_SESSION['id_usuario'] == true){
        header('Location: perfil.php ');
    }
    if (isset($_POST['post'])){
        $nome = addslashes($_POST['nome']);
        $email = addslashes($_POST['email']);
        $senha = addslashes(md5($_POST['senha']));
        $query = "SELECT * FROM usuario WHERE email = '$email'";
        $result = $conexao->query($query);
        $row = mysqli_fetch_assoc($result);
        if (empty($senha) || empty($nome) || empty($email)){
          $alert = '<div class="alert alert-danger" role="alert">
          Campo em Branco!
          </div>';
        }else{
        if($row == true){
            $alert = '<div class="alert alert-danger" role="alert">
            Usuário já existe!
            </div>';
        
        }else{
            
            $sql = "INSERT INTO usuario (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
            $resposta = $conexao->query($sql);
            if($resposta == true){
                $alert = '<div class="alert alert-success" role="alert">
                Cadastrado com sucesso!
                </div>';
            }
          } 
        }
    }
?>
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
				<h3>Cadastrar</h3>
        <div class="d-flex justify-content-end social_icon">
					<a href="index.php"><span><i class="fas fa-arrow-circle-left"></i></span><a>
				</div>
			</div>
			<div class="card-body">
      <?php echo $alert;?> 
      
      <form method="post">
        <div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" name="nome" placeholder="Nome" require>
            </div>
            <div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-at"></i></span>
						</div>
						<input type="text" class="form-control" name="email" placeholder="Email" require>
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" name="senha" placeholder="Senha" require>
					</div>

					<div class="form-group">
						<input type="submit" value="Login" name="post" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>