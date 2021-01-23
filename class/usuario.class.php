<?php 

class Usuario{
    private $pdo;
    private $id;
    private $nome;
    private $login;
    private $password;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=teste;host=localhost", "admin", "");

    }

    public function setId($id)
    {   
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNome($nome)
    {   
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setLogin($login)
    {   
        $this->login = $login;
    }

    public function getlogin()
    {
        return $this->login;
    }

    public function setPassword($password)
    {   
        $this->password = $password;
    }

    # persiste usuario na base
    public function store() {
        if($this->nome and $this->login and $this->password) # Não possibilita o registro caso não tenha todos os campos preenchidos
        {
            $sql = "INSERT INTO usuarios SET nome = ". "'" .$this->nome."', login = ". "'" .$this->login."', password = ". "'" .md5($this->password)."'";

            $sql = $this->pdo->exec($sql);
            
            if($sql)
            {
                $this->id = $this->pdo->lastInsertId();
                return True;
            }
        }
        return false;
    }

    # procura e retorna usuario
    public function find($id){
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $sql = $this->pdo->query($sql);

        $result = $sql->fetch();
        if($result)
        {
            $user = new Usuario();
            $user->setId($result['id']);
            $user->setLogin($result['login']);
            $user->setNome($result['nome']);
            $user->setPassword($result['password']);

            return $user;
        }
        else
        {
            return false;
        }
    }

    public function getAll(){
        $sql = "SELECT * FROM usuarios";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0)
        {
            $users = array();
            foreach($sql->fetchAll() as $row)
            { # retorna todos os usuario na classe usuario
                $user = new Usuario();
                $user->setId($row['id']);
                $user->setLogin($row['login']);
                $user->setNome($row['nome']);
                $user->setPassword($row['password']);

                array_push($users, $user); 
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
        $sql = "DELETE usuarios WHERE id = :id";
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
        $sql = "UPDATE usuarios SET nome = :nome, login = :login, password = :password WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $this->id);
        $sql->bindValue(":nome", $dataArray['nome']);
        $sql->bindValue(":login", $dataArray['login']);
        $sql->bindValue(":password", md5($dataArray['password']));
        $sql->execute();

        if($sql->rowCount() > 0){
            return false;
        }else{
            return true;
        }
    }
}