<?php 

class Grupo{
    private $pdo;
    private $id;
    private $nome;

    public function __construct($dataArray = null) {
        $this->pdo = new PDO("mysql:dbname=teste;host=localhost", "mapi", "mapi");

        # Caso receba dados do grupo já preenche a classe
        if($dataArray)
        {
            $this->id = $dataArray['id'];
            $this->nome = $dataArray['nome'];
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

    
    public function setNome($nome)
    {   
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }


    # persiste grupo na base
    public function store() {
        if($this->nome) # Não possibilita o registro caso não tenha todos os campos preenchidos
        {
            $sql = "INSERT INTO grupos SET nome = :nome";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':nome', $this->nome);
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
        $sql = "SELECT * FROM grupos WHERE id = $id";
        $sql = $this->pdo->query($sql);

        $result = $sql->fetch();
        if($result)
        {
            $grupo = new Grupo();
            $grupo->setId($result['id']);
            $grupo->setNome($result['nome']);

            return $grupo;
        }
        else
        {
            return false;
        }
    }

    public function getAll(){
        $sql = "SELECT * FROM grupos";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0)
        {
            $users = array();
            foreach($sql->fetchAll() as $row)
            { # retorna todos os usuario na classe usuario
                array_push($users, new Grupo(array(
                    'id'    =>  $row['id'],
                    'nome'    =>  $row['nome']
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
        $sql = "DELETE grupo WHERE id = :id";
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
        $sql = "UPDATE grupo SET nome = :nome WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $this->id);
        $sql->bindValue(":nome", $dataArray['nome']);
        $sql->execute();

        if($sql->rowCount() > 0){
            return false;
        }else{
            return true;
        }
    }
}