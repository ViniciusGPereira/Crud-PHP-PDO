<?php 

class UsuarioGrupo{
    private $pdo;
    private $id;
    private $usuario_id;
    private $grupo_id;

    public function __construct($dataArray = null) {
        $this->pdo = new PDO("mysql:dbname=teste;host=localhost", "mapi", "mapi");

        # Caso receba dados já preenche a classe
        if($dataArray)
        {
            $this->id = $dataArray['id'];
            $this->usuario_id = $dataArray['usuario_id'];
            $this->grupo_id = $dataArray['grupo_id'];
        }
    }

    public function setId($id)
    {   
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUserId($usuario_id)
    {   
        $this->usuario_id = $usuario_id;
    }

    public function getUserId()
    {
        return $this->usuario_id;
    }

    public function setGrupoId($grupo_id)
    {   
        $this->grupo_id = $grupo_id;
    }

    public function getGrupoId()
    {
        return $this->grupo_id;
    }

    # persiste grupo na base
    public function store() {
        if($this->usuario_id and $this->grupo_id) # Não possibilita o registro caso não tenha todos os campos preenchidos
        {
            $sql = "INSERT INTO usuarios_grupos SET usuario_id = :usuario_id, grupo_id = :grupo_id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':usuario_id', $this->usuario_id);
            $sql->bindValue(':grupo_id', $this->grupo_id);
            if($sql->execute())
            {
                $this->id = $this->pdo->lastInsertId();
                return True;
            }
        }
        return false;
    }

    # procura e retorna usuario
    public function find($id){
        print_r("teste");
        $sql = "SELECT * FROM usuarios_grupos WHERE id = $id";
        $sql = $this->pdo->query($sql);

        $result = $sql->fetch();
        if($result)
        {
            $user = new UsuarioGrupo();
            $user->setId($result['id']);
            $user->setUserId($result['usuario_id']);
            $user->setGrupoId($result['grupo_id']);

            return $user;
        }
        else
        {
            return false;
        }
    }

    public function getAll(){
        $sql = "SELECT * FROM usuarios_grupos";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0)
        {
            $users = array();
            foreach($sql->fetchAll() as $row)
            { # retorna todos os usuario na classe usuario
                array_push($users, new UsuarioGrupo(array(
                    'usuario_id'    =>  $row['usuario_id'],
                    'grupo_id'    =>  $row['grupo_id']
                )));
            }
            return $users;
        }
        else
        {
            return array();
        }
    }

    public function destroy()
    {
        $sql = "DELETE usuarios_grupos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $this->id);
        $sql->execute();

        if($sql->rowCount() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    function update($dataArray){
        $sql = "UPDATE usuarios_grupos SET usuario_id = :usuario_id, grupo_id = :grupo_id WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usuario_id", $dataArray('usuario_id'));
        $sql->bindValue(":grupo_id", $dataArray('grupo_id'));
        $sql->execute();

        if($sql->rowCount() > 0){
            return false;
        }else{
            return true;
        }
    }
}