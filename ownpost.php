<?php
    include_once ("conexao.php");
    include_once ("top.php");
    $usuario = $usuariosession;
    //perfil usuario
    $query = "SELECT * FROM usuario WHERE(id_usuario = '$usuario')";
    $resultUsuario = $conexao->query($query);
    foreach($resultUsuario as $p){
        $nomeUsuario = $p['nome']. ' ' . $p['sobrenome'];
        $imgUsuario = $p['img'];
        $descri = $p['descricao'];
    }
    //Verificar amizades
    $query = "SELECT * FROM amigos WHERE id = '$usuario' or iduser = '$usuario' AND amigo = 1 ";
    $resultAmg = $conexao->query($query);
    $row_cnt_amg = mysqli_num_rows($resultAmg);
    foreach ($resultAmg as $t) {
        if ($t['id'] == $usuariosession || $t['iduser'] == $usuariosession){
            $amigo = $t['amigo'];            
        }
    }
    //fazer postagem
    if (isset($_POST['post'])){
            $postbody = addslashes($_POST['postBody']);
        $postimage = addslashes($_POST['img']);
        if (strlen($postbody) < 1 && strlen($postimage) < 1){
            echo "<script>alert('Você precisa escrever alguma coisa ou Postar uma imagem') </script>";
        }else if (strlen($postbody) > 500){
            echo "<script>alert('Você atingiu o limite de 500 caracteres')</script>";
        }else{
            $query = "INSERT INTO post (body, posted, userid,img ) VALUES ('$postbody', NOW() , $usuario, '$postimage'  ) ";
            $result = $conexao->query($query);
            header("Location: ownpost.php");
        }
    }
    //Postagens dos usuarios
?> 
<!--- \\\\\\\perfil-->
<div class="container-fluid gedf-wrapper">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
            <div class="mx-auto mt-4">
                <img class="rounded-circle rounded" width="250" height="250" src="<?php echo $imgUsuario ?>" alt="">
            </div>  
            <div class="card-body">
                <div class="h5"><?php echo $nomeUsuario; ?></div>
                    <div class="h7"><?php echo $descri;?>
                    </div>
                    <?php
                    if($usuario != $usuariosession && $amigo == ''){
                        echo "<a href='amigo.php?id=$usuario'>Solicitacão de amizade </a> ";
                        }
                    if ($usuario != $usuariosession && $amigo == 1){
                        echo "<a href='amigo.php?caamg=$usuario'>Desfazer Amizade</a> ";
                    }
                    if ($usuario != $usuariosession && $amigo == 2){
                        echo "<a href='amigo.php?caamg=$usuario'>Cancelar amizade</a> ";
                    }
                    ?>
                </div>
                <ul class="list-group ">
                    <li class="list-group-item">
                        <div class="h6 text-muted"><a>Amigos </a><a class="h7"><?php echo $row_cnt_amg;?></a>
                        <?php
                        if ($row_cnt_amg > 5){
                            echo'<a href="lista-amigos.php" class="float-right">Ver mais</a>';
                        }
                        ?>    
                        </div>
                        <?php
                            $cont=0;
                            foreach ($resultAmg as $g){
                                if ($g['id'] != $usuario ){
                                    $idamg = $g['id'];
                                }else if ($g['iduser'] != $usuario){
                                    $idamg = $g['iduser'];
                                }
                                $isamigo = $g['amigo'];
                                $query = "SELECT * FROM usuario WHERE id_usuario = $idamg";
                                $result = $conexao->query($query);
                                foreach ($result as $c){
                                    $idLamg = $c['img'];
                                    if ($isamigo == 1){
                                        echo '<a href="perfil.php?id='.$idamg.'">
                                        <img class="rounded-circle" width="50" height="50" src="'.$idLamg.'" alt=""></a>';
                                    }
                                    
                                }
                                if($cont == 4){
                                    break;
                                 }
                                 $cont++; 
                            }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 gedf-main">
            <!-- perfil /////-->

            <!--- \\\\\\\Post-->
            <div class="card gedf-card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Texto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">Imagem</a>
                        </li>
                    </ul>
                </div>
                <form method="POST">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        
                    <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                            <div class="form-group">
                                <label class="sr-only" for="message">post</label>
                                <textarea class="form-control" id="message" rows="3" placeholder="O que você está pensando?" name="postBody"></textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                <input type="text" class="form-control" id="customFile" name='img' placeholder='Upload imagem da internet'>
                            <div class="py-4"></div>
                        </div>
                    </div>
                    <div class="btn-toolbar justify-content-between">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="post">Publicar</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!-- Post /////-->
            
            <!--- \\\\\\\ Timeline-->
            <div id="postagens">
            <?php 
                $query = "SELECT * FROM post WHERE (userid = '$usuario') ORDER BY id DESC LIMIT  10";
                $resultComent = $conexao->query($query); 
                $idP = 0;
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
            ?>
                
            </div>
            <div><h3 id="outPost" class="text-center">-----Não há mais postagens-----<h3></div>
            <!-- Timeline /////-->
        </div>
        </div>
    </div>
</div>
<script >
    $(document).ready(function(){
        $("#outPost").show();
        var prox = 1;
        var flag = true;
        var idItem = <?php echo $idP;?>;
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 1 && flag == true) {
                $("#outPost").hide();
                $.post("processar.php",
                {
                    prox: prox,
                    idP: idItem
                },
                function(data){
                    if (data != 1){
                        $("#postagens").append(data);
                        prox++;
                    }else{
                        if (flag == true){
                            $("#outPost").show();
                            flag = false;
                    }
                } 
                }); 
            }
        });
    });
</script>
<?php include_once ("rodape.html");?>
