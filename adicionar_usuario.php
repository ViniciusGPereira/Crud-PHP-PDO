<?php
include 'class/usuario.class.php';
include 'class/usuario_grupo.php';

if(isset($_POST['nome']) && !empty($_POST['login']) && isset($_POST['password'])){
    $usuario = new Usuario();

    $usuario->setNome(addslashes($_POST['nome']));
    $usuario->setLogin(addslashes($_POST['login']));
    $usuario->setPassword(addslashes($_POST['password']));

    # Realiza vinculo de usuario com grupo
    if($usuario->store())
    {
        $usuario_grupo = new UsuarioGrupo();

        $usuario_grupo->setUserId($usuario->getId());
        $usuario_grupo->setGrupoId(addslashes($_POST['grupo_id']));

        $usuario_grupo->store();
    }
}
header("Location: index.php");
//