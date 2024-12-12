<?php
class Categorias{
    private $conn;
    private $table_name = "categorias";


    public function __construct($db)    {
        $this->conn = $db;
    }

    public function registrar($nome_categoria)    {
        $query = "INSERT INTO " . $this->table_name . " (nome_categoria	) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome_categoria]); //Executa o insart no banco
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lerPorId($id)    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_categoria = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizar($id_categoria, $nome_categoria)    {
        $query = "UPDATE " . $this->table_name . " SET nome_categoria = ? WHERE id_categoria = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome_categoria	, $id_categoria]);
        return $stmt;
    }


    public function deletar($id)    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_categoria = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

   

    public function listarExcel()    {
        $query_compras = "SELECT id_categoria, nome_categoria FROM compras ORDER BY id_categoria DESC";
        $stmt = $this->conn->prepare($query_compras);
        $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC);;
    }
}
?>