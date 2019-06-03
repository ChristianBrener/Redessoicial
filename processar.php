<?php
include_once ("conexao.php");
if (isset($_POST['idP'])){
    $prox = $_POST['prox'];
    $idP = $_POST['idP'];
    $num_update = 10;
    $prox = $prox * 10;

    $query = "SELECT * FROM post WHERE (userid = '$usuariosession') ORDER BY id DESC LIMIT $prox, $num_update";
    $resultComent = $conexao->query($query);
    if(mysqli_fetch_assoc($resultComent) == false){
        echo 1;
    }
    foreach ($resultComent as $p){ 
        $idpost = $p['id'];
        $idP++;
        $query = "SELECT * FROM comentario WHERE idpost =  $idpost";
        $result = $conexao->query($query);
        $row_cnt_com = mysqli_num_rows($result);
        $query = "SELECT * FROM curtir WHERE idpost = $idpost";
        $result = $conexao->query($query);
        $row_cnt_likes = mysqli_num_rows($result);
        $query = "SELECT * FROM curtir WHERE iduser = $usuariosession and idpost =  $idpost ";
        $result = $conexao->query($query);
        if (mysqli_fetch_assoc($result) != false){
            $cass = " fa-heart fas red";
            $i = 1;
        }else{
            $i = 0;
            $cass = "fa-heart far red";
        }
        echo '
        <div class="card gedf-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mr-2">
                            <img class="rounded-circle" width="50" height="50"src="'.$imgUsuario.'" alt="">
                        </div>
                        <div class="ml-2">
                            <div class="h5 m-0">'.$nomeUsuario.'</div>
                        </div>
                    </div>
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                ';  
                                if ($p["userid"] == $usuariosession){
                                    echo'<a class="dropdown-item" href="apagar.php?id='.$p["id"].'">Deletar</a>';
                                }else{
                                    echo' <a class="dropdown-item" href="#">Report</a>';
                                }
                                echo'
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-muted h7 mb-2"> <i class="far fa-clock"></i> '.$p["posted"].'</div>
                <a class="card-link" href="#">
                </a>
                <p class="card-text">
                '.$p["body"].'</br></br>
                <img class="rounded mx-auto d-block w-100"src="'.$p["img"].'" alt=""></p>
            </div>
            <div class="card-footer">
                <button id="l'.$idP.'" type="button" class="btn btn-light"><i id="c'.$idP.'" class="'.$cass.'"><span class="badge badge-light"> <a id ="s'.$idP.'">'.$row_cnt_likes.'</a></span> </i> Amei</button>
                <a href="comment.php?id='.$idpost.'" class="card-link"><button type="button" class="btn btn-light"><i class="fa fa-comment"><span class="badge badge-light" >'.$row_cnt_com.'</span></i> Comentários</button></a>
            </div>
        </div>
            <script>
                    $(document).ready(function(){
                        var i = '.$i.';
                        var cont_likes = '.$row_cnt_likes.';
                        $("#l'.$idP.'").click(function(){
                            if(i == 0){
                                cont_likes++;
                                i = 1;
                            }else{
                                cont_likes--;
                                i = 0;
                            }
                            $("#s'.$idP.'").text(cont_likes);
                            $("#c'.$idP.'").toggleClass("far red");
                            $("#c'.$idP.'").toggleClass("fas red");
                            $.post("curtir.php",
                            {
                                postE: '.$idpost.' ,
                                iduserE: '.$usuariosession.'
                            },
                            function(data, status){
                            });
                        });
                        });
            </script>
    ';
    }

}
if (isset($_POST['idPT'])){
    $prox = $_POST['prox'];
    $idP = $_POST['idPT'];
    $usuario = $_POST['idUser'];
    $num_update = 10;
    $prox = $prox * 10;
    if ($usuariosession == $usuario){
        $query = "SELECT * FROM amigos WHERE id = '$usuariosession' and  amigo = 1 or iduser = '$usuariosession' and amigo = 1  ";
        $result = $conexao->query($query);
        $i = TRUE;
        foreach($result as $p){
            if ($p['id'] != $usuariosession ){
                $id = $p['id'];
            }else if ($p['iduser'] != $usuariosession){
                $id = $p['iduser'];
            }
            
            if($i == TRUE ){
            $queryPost =  "SELECT * FROM post WHERE userid =  $id";
            $i = FALSE;
            }else{
            $queryPost .= ' or  userid = '.$id;
            }
        }
        $queryPost = $queryPost . " ORDER BY id DESC LIMIT $prox, $num_update";
        $resultComent = $conexao->query($queryPost); 
        if(mysqli_fetch_assoc($resultComent) == false){
            echo 1;
        }             
        $idP = 0;    
        foreach ($resultComent as $p){ 
            $idpost = $p['id'];
            $userid = $p['userid'];
            $query = "SELECT * FROM usuario WHERE(id_usuario = '$userid')";
            $result = $conexao->query($query);
            foreach($result as $t){
            $nomenoPost = $t['nome'];
            $nomenoImg = $t['img'];
        }
            $idP++;
            $query = "SELECT * FROM comentario WHERE idpost =  $idpost";
            $result = $conexao->query($query);
            $row_cnt_com = mysqli_num_rows($result);
            $query = "SELECT * FROM curtir WHERE idpost = $idpost";
            $result = $conexao->query($query);
            $row_cnt_likes = mysqli_num_rows($result);
            $query = "SELECT * FROM curtir WHERE iduser = $usuariosession and idpost =  $idpost ";
            $result = $conexao->query($query);
            if (mysqli_fetch_assoc($result) != false){
                $cass = " fa-heart fas red";
                $i = 1;
            }else{
                $i = 0;
                $cass = "fa-heart far red";
            }
            echo '
            <div class="card gedf-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <img class="rounded-circle" width="50" height="50"src="'.$nomenoImg .'" alt="">
                            </div>
                            <div class="ml-2">
                                <div class="h5 m-0"><a class="text-decoration-none" href="perfil.php?id='.$userid.'">'.$nomenoPost.'</a></div>
                            </div>
                        </div>
                        <div>
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                    ';  
                                    if ($p["userid"] == $usuariosession){
                                        echo'<a class="dropdown-item" href="apagar.php?id='.$p["id"].'">Deletar</a>';
                                    }else{
                                        echo' <a class="dropdown-item" href="#">Report</a>';
                                    }
                                    echo'
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-muted h7 mb-2"> <i class="far fa-clock"></i> '.$p["posted"].'</div>
                    <a class="card-link" href="#">
                    </a>
                    <p class="card-text">
                    '.$p["body"].'</br></br>
                    <img class="rounded mx-auto d-block w-100"src="'.$p["img"].'" alt=""></p>
                </div>
                <div class="card-footer">
                    <button id="l'.$idP.'" type="button" class="btn btn-light"><i id="c'.$idP.'" class="'.$cass.'"><span class="badge badge-light"> <a id ="s'.$idP.'">'.$row_cnt_likes.'</a></span> </i> Amei</button>
                    <a href="comment.php?id='.$idpost.'" class="card-link"><button type="button" class="btn btn-light"><i class="fa fa-comment"><span class="badge badge-light" >'.$row_cnt_com.'</span></i> Comentários</button></a>
                </div>
            </div>
                <script>
                        $(document).ready(function(){
                            var i = '.$i.';
                            var cont_likes = '.$row_cnt_likes.';
                            $("#l'.$idP.'").click(function(){
                                if(i == 0){
                                    cont_likes++;
                                    i = 1;
                                }else{
                                    cont_likes--;
                                    i = 0;
                                }
                                $("#s'.$idP.'").text(cont_likes);
                                $("#c'.$idP.'").toggleClass("far red");
                                $("#c'.$idP.'").toggleClass("fas red");
                                $.post("curtir.php",
                                {
                                    postE: '.$idpost.' ,
                                    iduserE: '.$usuariosession.'
                                },
                                function(data, status){
                                });
                            });
                            });
                </script>
        '; 
        }
    
    }else{
        $query = "SELECT * FROM post WHERE (userid = '$usuario') ORDER BY id DESC LIMIT  $prox, $num_update";
        $resultComent = $conexao->query($query); 
        $idP = 0;
        $query = "SELECT * FROM usuario WHERE (id_usuario = '$usuario')";
        $result = $conexao->query($query); 
        if(mysqli_fetch_assoc($resultComent) == false){
            echo 1;
        }  
        foreach ($result as $p){
            $nomeUsuario = $p['nome'];
            $imgUsuario = $p['img'];
        }
        foreach ($resultComent as $p){ 
            $idpost = $p['id'];
            $idP++;
            $query = "SELECT * FROM comentario WHERE idpost =  $idpost";
            $result = $conexao->query($query);
            $row_cnt_com = mysqli_num_rows($result);
            $query = "SELECT * FROM curtir WHERE idpost = $idpost";
            $result = $conexao->query($query);
            $row_cnt_likes = mysqli_num_rows($result);
            $query = "SELECT * FROM curtir WHERE iduser = $usuariosession and idpost =  $idpost ";
            $result = $conexao->query($query);
            if (mysqli_fetch_assoc($result) != false){
                $cass = " fa-heart fas red";
                $i = 1;
            }else{
                $i = 0;
                $cass = "fa-heart far red";
            }
            echo '
            <div class="card gedf-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <img class="rounded-circle" width="50" height="50"src="'.$imgUsuario.'" alt="">
                            </div>
                            <div class="ml-2">
                            <div class="h5 m-0"><a class="text-decoration-none" href="perfil.php?id='.$p['userid'].'">'.$nomeUsuario.'</a></div>
                            </div>
                        </div>
                        <div>
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                    ';  
                                    if ($p["userid"] == $usuariosession){
                                        echo'<a class="dropdown-item" href="apagar.php?id='.$p["id"].'">Deletar</a>';
                                    }else{
                                        echo' <a class="dropdown-item" href="#">Report</a>';
                                    }
                                    echo'
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-muted h7 mb-2"> <i class="far fa-clock"></i> '.$p["posted"].'</div>
                    <a class="card-link" href="#">
                    </a>
                    <p class="card-text">
                    '.$p["body"].'</br></br>
                    <img class="rounded mx-auto d-block w-100"src="'.$p["img"].'" alt=""></p>
                </div>
                <div class="card-footer">
                    <button id="l'.$idP.'" type="button" class="btn btn-light"><i id="c'.$idP.'" class="'.$cass.'"><span class="badge badge-light"> <a id ="s'.$idP.'">'.$row_cnt_likes.'</a></span> </i> Amei</button>
                    <a href="comment.php?id='.$idpost.'" class="card-link"><button type="button" class="btn btn-light"><i class="fa fa-comment"><span class="badge badge-light" >'.$row_cnt_com.'</span></i> Comentários</button></a>
                </div>
            </div>
                <script>
                        $(document).ready(function(){
                            var i = '.$i.';
                            var cont_likes = '.$row_cnt_likes.';
                            $("#l'.$idP.'").click(function(){
                                if(i == 0){
                                    cont_likes++;
                                    i = 1;
                                }else{
                                    cont_likes--;
                                    i = 0;
                                }
                                $("#s'.$idP.'").text(cont_likes);
                                $("#c'.$idP.'").toggleClass("far red");
                                $("#c'.$idP.'").toggleClass("fas red");
                                $.post("curtir.php",
                                {
                                    postE: '.$idpost.' ,
                                    iduserE: '.$usuariosession.'
                                },
                                function(data, status){
                                });
                            });
                            });
                </script>
        ';
        }
    } 
}
?>

