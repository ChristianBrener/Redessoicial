<?php
define ('HOST','localhost');
define ('USUARIO', 'id9658889_christian');
define ('SENHA', 'christian2703');
define ('DBU', 'id9658889_redesocial');
$conexao = mysqli_connect(HOST, USUARIO, SENHA, DBU) or die('Não foi possível conectar');
error_reporting(1);
session_start();
$usuariosession = $_SESSION['id_usuario'];
?>