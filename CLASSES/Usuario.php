<?php
class Usuario
{
    private $conn;
    private $table_name = "usuarios";


    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function registrar($nome, $email, $senha)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha) VALUES ( ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT); // Senha Criptografada
        $stmt->execute([$nome,   $email, $hashed_password]); //Executa o insart no banco
        return $stmt;
    }


    public function login($email, $senha)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }
    public function criar($nome, $fone, $email, $senha)
    {
        return $this->registrar($nome,  $fone, $email, $senha);
    }
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizar($id, $nome, $sexo, $fone, $email)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, fone = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $fone, $email, $id]);
        return $stmt;
    }


    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

    public function listarTodos()
    {
        $sql = "select*from usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
