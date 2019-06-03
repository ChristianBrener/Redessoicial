<?php
    include_once ('conexao.php');
    include_once ('top.php');

    if (isset($_GET['id'])){
        $idAmigo= $_GET['id'];
        $query = "INSERT INTO amigos (id, iduser,amigo) VALUES ('$usuariosession','$idAmigo', 2)";
        $result = $conexao->query($query);
        header("LOCATION: perfil.php?id=$idAmigo");
    }
    if (isset($_GET['del'])){
        $idapagar = $_GET['del'];
        $query = "DELETE FROM amigos WHERE id = $idapagar";
        $retorno = $conexao->query($query);
        if ($retorno == true){
            echo " <script>
            location.href = 'perfil.php';
            </script>";
        }else{
            echo "<script>
            alert('Falha ao apagar');
            </script>";
        }
    }
    if (isset($_GET['acamg'])){
        $id = $_GET['acamg'];
        $query = "UPDATE amigos SET amigo = 1 WHERE id = '$id' and iduser = '$usuariosession' ";
        $retorno = $conexao->query($query);
        header("LOCATION: perfil.php");
    }
    if (isset($_GET['caamg'])){
        $id = $_GET['caamg'];
        $query = "DELETE FROM amigos WHERE id = '$id' AND iduser = '$usuariosession' or id = '$usuariosession' AND iduser = '$id' ";
        $retorno = $conexao->query($query);
        header("LOCATION: perfil.php");
    }
?>