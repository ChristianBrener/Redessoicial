<?php
include_once ("conexao.php");
include_once ("top.php");
$nome = addslashes($_POST['nome']);
if(empty($nome)){
    echo "<script>location.href = 'perfil.php';</script> ";
}
$query = "SELECT * FROM usuario WHERE nome LIKE '$nome%' ";
$result = $conexao->query($query);
if(mysqli_fetch_assoc($result) == false){
    $alert = 'Usuário não encontrado'; 
}
?>
<div class="container">
  <div class="row">
    <div class="col-sm">
    </div>
    <div class="col-12">
        <div class="card mt-5">
            <div class="card-body">
                <?php
                echo $alert;
                foreach ($result as $r){
                    $nome = $r['nome'];
                    $img = $r['img'];
                    $id = $r['id_usuario'];
                    $descri = $r['descricao'];
                    echo'
                    <div class="card mb-5" style="max-width: 400px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                            <a href="perfil.php?id='.$id.'"> <img class=" rounded mx-auto d-block" width="150" height="100" src="'.$img.'" alt=""> </a>                           </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><a href="perfil.php?id='.$id.'">'.$nome.'</a></h5>
                                <p class="card-text">'.$descri.'</p>
                            </div>
                            </div>
                        </div>';
                        $query = "SELECT * FROM amigos WHERE iduser = '$usuariosession' AND id = '$id' or iduser = '$id' AND id = '$usuariosession' ";
                        $result = $conexao->query($query);
                        if ($id != $usuariosession){
                            if(mysqli_fetch_assoc($result) == false){
                                echo'<a  href="amigo.php?id='.$id.'" class="btn btn-primary">Solicitacão de amizade</a>';
                            }   
                            foreach($result as $t){
                                $amigos = $t['amigo']; 
                                    if ($t['id'] == $usuariosession || $t['iduser'] == $usuariosession){
                                        if($amigos == '1'){
                                            echo'<a href="amigo.php?caamg='.$id.'" class="btn btn-primary">Desfazer amizade</a>';
                                        }
                                        if($amigos == '2'){
                                            echo'<a href="amigo.php?caamg='.$id.'" class="btn btn-primary">Cancelar amizade</a>';
                                        }   
                                    }
                                }
                        }
                        echo'
                        </div>
                    <div class="mb-2">
                    </div>';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm">
    </div>
  </div>
</div>      
<?php 
include_once ("rodape.html");
?>