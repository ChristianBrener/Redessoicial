<?php 
include_once ('top.php');
include_once ('amigo.php');
    if (isset($_POST['post'])) { 
    $email = addslashes($_POST['email']);
    $nome = addslashes($_POST['nome']);
    $img = addslashes($_POST['img']);
    $descricao = addslashes($_POST['descri']);
    if (strlen($descricao) < 255){
    $query = "UPDATE usuario SET 
              nome = '$nome' , email = '$email', descricao = '$descricao', img = '$img'
              WHERE id_usuario = '$usuariosession'";
    $result = $conexao->query($query);
    }else{
        $alert = '<div class="alert alert-danger" role="alert">
        Coloque um texto na descrição de até 255 caracteres 
        </div>';
    }
}
    $query = "SELECT * FROM usuario WHERE(id_usuario = '$usuariosession')";
    $resultUsuario = $conexao->query($query);
    foreach($resultUsuario as $p){
        $nome = $p['nome'];
        $imgUsuario = $p['img'];
        $email = $p['email'];
        $descricao = $p['descricao'];
    }
?> 
<!--- \\\\\\\perfil-->
<div class="container-fluid gedf-wrapper">
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6 gedf-main">
            <!--- \\\\\\\ Form-->
            <div class="card gedf-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="'.$imgUsuario.'" alt="">
                                </div>
                                <div class="ml-2">
                                    <div class="h5 m-0">Editar Perfil</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <?php echo $alert;?>
                        <form method="post">
                        <div class="form-group">
                            <label for="EmailFormControlInput1">Email</label>
                            <input type="email" class="form-control" id="EmailFormControlInput1" name='email' value="<?php echo $email;?>">
                        </div>
                        <div class="form-group">
                            <label for="NomeFormControlInput1">Nome</label>
                            <input type="text" class="form-control" id="NomeFormControlInput1" name='nome' value="<?php echo $nome;?>">
                            <label for="ImagemFormControlInput1">Imagem do Perfil</label>
                            <input type="text" class="form-control" id="ImagemFormControlInput1" name='img' value="<?php echo $imgUsuario;?>">
                        </div>
                        <div class="form-group">
                            <label for="descriFormControlTextarea1"  >Descrição</label>
                            <textarea name='descri' class="form-control" id="descriFormControlTextarea1" rows="3"><?php echo $descricao;?></textarea>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" name="post" type="submit">Enviar</button>
                        </form>
                    </div>    
            </div>
            <!--  /////-->
        </div>
    </div>
</div>
<?php include_once ("rodape.html");?>