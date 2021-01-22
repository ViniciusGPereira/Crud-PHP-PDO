<?php
include 'class/grupo.class.php';

if(isset($_POST['nome']) && !empty($_POST['nome'])){
    $nome = addslashes($_POST['nome']);

    $grupo = new Grupo();

    $grupo->setNome($nome);

    $grupo->store();
}
header("Location: index.php");
//