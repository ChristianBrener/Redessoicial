<?php
session_start();
include_once ("conexao.php");
include_once ("top.php");
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM post WHERE id = '$id'";
    $result = $conexao->query($query);
    foreach ($result as $key) {
        $posted = $key['posted'];
        $body = $key['body'];
        $userid = $key['userid'];
        $idpost = $key['id'];
        $imgpost = $key['img'];
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
    }
    $query = "SELECT * FROM usuario WHERE id_usuario = '$userid'";
    $result = $conexao->query($query);
    
    foreach ($result as $k) {
        $nomeUsuario = $k['nome'];
        $imgUsuario = $k['img'];
    }
}else{
    header('Location: perfil.php');
}
$query = "SELECT * FROM comentario WHERE idpost = '$idpost'";
$resultComent = $conexao->query($query);
?>
<div class="container">
  <div class="row">
    <div class="col-sm">
    </div>
    <div class="col-10">
        <div class="card mt-5">
        <!-- Corpo post              -->    
        <div class="card-body">
            <div class="card gedf-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-2">
                                        <img class="rounded-circle" width="50" height="50"src="<?php echo $imgUsuario;?>" alt="">
                                    </div>
                                    <div class="ml-2">
                                        <div class="h5 m-0"><?php echo $nomeUsuario;?></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                            <?php  
                                            if ($userid == $usuariosession){
                                                echo'<a class="dropdown-item" href="apagar.php?id='.$id.'">Deletar</a>';
                                            }else{
                                                echo' <a class="dropdown-item" href="#">Report</a>';
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-muted h7 mb-2"> <i class="far fa-clock"></i><?php echo $posted;?></div>
                            <a class="card-link" href="#">
                            </a>
                            <p class="card-text">
                            <?php echo ''.$body.'</br></br>
                            <img class="rounded mx-auto d-block w-100"src="'.$imgpost.'" alt="">';
                            ?>
                        </p>
                        
                        </div>
                        <div class="card-footer">
                        <?php
                            echo    '<button id="l'.$idP.'" type="button" class="btn btn-light"><i id="c'.$idP.'" class="'.$cass.'"><span class="badge badge-light"> <a id ="s'.$idP.'">'.$row_cnt_likes.'</a></span> </i> Amei</button>
                            
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
                        ?>
                        </div>
                               <!-- Corpo post              -->
                                  
                        <!-- Comentario Existentes            -->
                        <?php
                        foreach($resultComent as $t){
                            $idC = $t['iduser'];
                            $postedC = $t['posted'];
                            $bodyC = $t['body'];
                            $idpostC = $t['id'];

                            $query = "SELECT * FROM usuario WHERE id_usuario = '$idC'";
                            $result = $conexao->query($query);
                            
                            foreach ($result as $k) {
                                $nomeUsuarioC = $k['nome'];
                                $imgUsuarioC = $k['img'];
                            }
                            echo'
                            <div class="card-body">
                                <div class="card gedf-card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="mr-2">
                                                    <img class="rounded-circle" width="50" height="50"src="'.$imgUsuarioC.'" alt="">
                                                </div>
                                                <div class="ml-2">
                                                    <div class="h5 m-0">'.$nomeUsuarioC.'</div>
                                                </div>
                                            </div>
                                        <div>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                            '; 
                                            if ($userid == $usuariosession){
                                                echo'<a class="dropdown-item" href="apagar.php?idc='.$idpostC.'&idp='.$id.'">Deletar</a>';
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
                            <div class="text-muted h7 mb-2"> <i class="far fa-clock"></i>'.$postedC.'</div>
                            <a class="card-link" href="#">
                            </a>
                            <p class="card-text">
                            '.$bodyC.'</br></br>
                        </p>
                        </div></div></div>
                            
                        ';    
                        }
                        ?>
                               
                        <!-- Comentario Existentes            -->

                       <!-- Comentario caixa de texto              -->
                <form method="POST" action="comment-post.php">
                <input type="hidden" name="id" value="<?php echo $idpost;?>" />
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                    <h3>Fazer um Comentário:</h3> 
                    <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                            <div class="form-group">
                                <label class="sr-only" for="message">post</label>
                                <textarea class="form-control" id="message" rows="3" placeholder="" name="postBody"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="btn-toolbar justify-content-between">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="post">Publicar</button>
                        </div>
                    </div>
                </div>
                 <!-- Comentario caixa de texto              -->
                </div>
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