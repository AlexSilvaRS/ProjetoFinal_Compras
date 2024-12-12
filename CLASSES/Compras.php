<?php
class Compras{
    private $conn;
    private $table_name = "compras";


    public function __construct($db)    {
        $this->conn = $db;
    }

    public function registrar($nome, $fkidcategoria, $quantidade, $preco, $data_adicao)    {
        $query = "INSERT INTO " . $this->table_name . " (nome, fkidcategoria,quantidade, preco, data_adicao) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $fkidcategoria, $quantidade, $preco, $data_adicao]); //Executa o insart no banco
        return $stmt;
    }

  
    public function ler()    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function lerTodos()    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lerPorId($id)    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizar($id, $nome, $quantidade, $preco, $data_adicao)    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, quantidade = ?, preco = ?, data_compra = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $quantidade, $preco, $data_adicao, $id]);
        return $stmt;
    }


    public function deletar($id)    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

    public function listarTodos()    {
        $sql = "select*from usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarExcel()    {
        $query_compras = "SELECT id, nome, quantidade, preco, data_adicao FROM compras ORDER BY id DESC";
        $stmt = $this->conn->prepare($query_compras);
        $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC);;
    }
}
?>