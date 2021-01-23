<?php
include 'class/grupo.class.php';

if(isset($_POST['nome']) && !empty($_POST['nome'])){
    $nome = addslashes($_POST['nome']);

    try {
        $grupo = new Grupo();

        $grupo->setNome($nome);
    
        $grupo->store();
       header("Location: index.php");

    } catch (\Throwable $th) {
        echo "<pre>";
        echo $th;
        echo "<pre>";
    }

}
