<?php
include_once ("conexao.php");
if(isset($_POST['postE'])){
$idpost = $_POST['postE'];
$iduser = $_POST['iduserE'];
echo $idpost ." ". $iduser;

$query = "SELECT * FROM curtir WHERE iduser = $iduser and idpost =  $idpost ";
$result = $conexao->query($query);
$row = mysqli_fetch_assoc($result);
if ($row != false){
    $query = "DELETE FROM curtir WHERE idpost = $idpost and iduser = $iduser";
    $result = $conexao->query($query);
}else{
    $query = "INSERT INTO curtir (idpost,iduser) VALUES ($idpost, $iduser)";
    $result = $conexao->query($query);
}

}
?>