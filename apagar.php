<?php
include_once ('conexao.php');
    if($_SESSION['id_usuario'] == false){
        header('Location: index.php ');
      }
if(isset($_GET['id'])){
    $idapagar = $_GET['id'];
    $query = "DELETE FROM post WHERE id = $idapagar AND userid = '$usuariosession'";
    $retorno = $conexao->query($query);
    if ($retorno == true){
        header('Location: ownpost.php');
    }else{
        echo "<script>
        alert('Falha ao apagar Postagem');
        location.href = 'ownpost.php';
        </script>";
    }
}
if(isset($_GET['idc'])){
    $idapagar = $_GET['idc'];
    $idpost = $_GET['idp'];
    $query = "DELETE FROM comentario WHERE id = $idapagar AND iduser = '$usuariosession'";
    $retorno = $conexao->query($query);
    if ($retorno == true){
        header("Location: comment.php?id=$idpost");
        exit();
    }else{
        echo "<script>
        alert('Falha ao apagar comentario');
        location.href = 'ownpost.php';
        </script>";
    }
}
header('Location: ownpost.php');
?>