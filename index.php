<?php
include 'class/usuario.class.php';
include 'class/usuario_grupo.php';
include 'class/grupo.class.php';

try {
    $UGClass = new UsuarioGrupo();
    $usuarios_grupos = $UGClass->getAll();
    
    $grupo = new Grupo();
    $grupos = $grupo->getAll();
} catch (\Throwable $th) {
    echo '<pre>';
    print_r($th);
    echo '</pre>';
    echo '<br>';
    echo '<div class="alert alert-danger" role="alert">';
    echo '<br>';
    echo '<h2>Olá, possivélmente você esta com problema de conexão com o DB</h2>';
    echo '<p>Verifique na documentação como configura-lo acessando o <a href="https://github.com/ViniciusGPereira/Crud-PHP-PDO">link</a></p>';
    echo '<br>';
    echo '</div>';
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
</head>

<body class="container">
    <br><br>
    <h2>CRUD com PHP</h2>
    <br>
    <div id="content-button" class="row d-flex justify-content-end">
        <button data-toggle="modal" data-target="#adiciona_usuario" class="btn btn-success">ADICIONAR USUARIO</button>
        <button data-toggle="modal" data-target="#adiciona_grupo" class="btn btn-info">ADICIONAR GRUPO</button>
    </div>
    <br><br>
    <h3>Usuário e Grupos</h3>
    <table class="table">
        <thead>
            <th>Usuário</th>
            <th>Grupo</th>
        </thead>
        <tbody>
            <?php foreach($usuarios_grupos as $row):?>
            <tr>
                <?php 
                    $user = new Usuario();
                    $user = $user->find($row->getUserId());
                    echo "<td>". $user->getNome(). "</td>";

                    $grupo = new Grupo();
                    $grupo = $grupo->find($row->getGrupoId());  

                    echo "<td>". $grupo->getNome(). "</td>";

                ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

<!-- Modal - Adicionar Usuario-->
<div class="modal fade" id="adiciona_usuario" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="adicionar_usuario.php" method="POST" id="cadastrar">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input required type="text" name="nome" id="nome" class="form-control" placeholder=""
                                aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                            <label for="login">Login</label>
                            <input required type="text" name="login" id="login" class="form-control" placeholder=""
                                aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                            <label for="grupo">Grupo</label>
                            <select required class="form-control" name="grupo_id" id="grupo_id">
                                <?php foreach($grupos as $grupo):?>
                                <option value="<?php echo $grupo->getId();?>"><?php echo $grupo->getNome();?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input required type="password" onkeyup="validaSenha(1);" name="password" id="password_1"
                                class="form-control" placeholder="" aria-describedby="helpId">
                            <small style="color:red;" id="erro_1">Senhas não coferem</small>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input required type="password" onkeyup="validaSenha(2);" name="password" id="password_2"
                                class="form-control" placeholder="" aria-describedby="helpId">
                            <small style="color:red;" id="erro_2">Senhas não coferem</small>
                        </div>
                        <button type="submit" id="submit_cadastro" class="hidden"></button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" id="btn_cadastro" onclick="$('#submit_cadastro').trigger('click');"
                    class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Adicionar Grupo -->
<div class="modal fade" id="adiciona_grupo" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="adicionar_grupo.php" method="POST" id="cadastrar_grupo">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" class="form-control" placeholder=""
                                aria-describedby="helpId">
                        </div>
                        <button type="submit" id="submit_cadastro_grupo" class="hidden"></button>
                    </form>
                    <hr>
                    <b>Grupos Criados</b>
                    <ul>
                        <?php foreach($grupos as $grupo): ?>
                        <li><?php echo $grupo->getNome();?></li>
                        <?php endforeach;?>
                    </ul>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" id="btn_cadastro" onclick="$('#submit_cadastro_grupo').trigger('click');"
                    class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
$('#erro_1').hide();
$('#erro_2').hide();

function validaSenha(id_erro) {
    key1 = $('#password_1').val();
    key2 = $('#password_2').val();

    let element = '#erro_' + id_erro;

    if (key2 != key1) {
        $(element).show();
        $('#btn_cadastro').attr("disabled", 'disabled');
    } else {
        $('#erro_1').hide();
        $('#erro_2').hide();
        $('#btn_cadastro').removeAttr("disabled");

    }
}
</script>

</html>