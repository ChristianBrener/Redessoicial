<?php
include_once("conexao.php");
if (isset($_POST['post'])){
    $idpost = $_POST['id'];
    $postbody = addslashes($_POST['postBody']);
    if (strlen($postbody) > 500 || strlen($postbody) < 1 ){
    echo "<script>alert('O comentário deve conter texto de até 500 caracteres')
    location.href = 'comment.php?id=$idpost';
    ;</script>";
    }else{
        
        $query = "INSERT INTO comentario (body, posted, iduser, idpost) VALUES ('$postbody', NOW() , '$usuariosession', '$idpost' )";
        $result = $conexao->query($query);
            header("Location: comment.php?id=$idpost");
    }
    
}
?>