<?php
/**
 * Modelo para gerenciar Insumos
 * Sistema de Gestão da Doceria
 */

require_once '../config/database.php';

class Insumo {
    private $conn;
    private $table_name = "insumos";

    public $id;
    public $nome;
    public $descricao;
    public $unidade_medida;
    public $estoque_atual;
    public $estoque_minimo;
    public $custo_unitario_atual;
    public $categoria;
    public $fornecedor;
    public $ativo;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Criar novo insumo
     */
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, descricao, unidade_medida, estoque_atual, estoque_minimo, 
                   custo_unitario_atual, categoria, fornecedor) 
                  VALUES (:nome, :descricao, :unidade_medida, :estoque_atual, :estoque_minimo, 
                          :custo_unitario_atual, :categoria, :fornecedor)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->unidade_medida = htmlspecialchars(strip_tags($this->unidade_medida));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->fornecedor = htmlspecialchars(strip_tags($this->fornecedor));

        // Bind dos parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':unidade_medida', $this->unidade_medida);
        $stmt->bindParam(':estoque_atual', $this->estoque_atual);
        $stmt->bindParam(':estoque_minimo', $this->estoque_minimo);
        $stmt->bindParam(':custo_unitario_atual', $this->custo_unitario_atual);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':fornecedor', $this->fornecedor);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Listar todos os insumos
     */
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ativo = 1 ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Buscar insumo por ID
     */
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id AND ativo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'];
            $this->unidade_medida = $row['unidade_medida'];
            $this->estoque_atual = $row['estoque_atual'];
            $this->estoque_minimo = $row['estoque_minimo'];
            $this->custo_unitario_atual = $row['custo_unitario_atual'];
            $this->categoria = $row['categoria'];
            $this->fornecedor = $row['fornecedor'];
            $this->ativo = $row['ativo'];
            return true;
        }
        return false;
    }

    /**
     * Atualizar insumo
     */
    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, descricao = :descricao, unidade_medida = :unidade_medida,
                      estoque_atual = :estoque_atual, estoque_minimo = :estoque_minimo,
                      custo_unitario_atual = :custo_unitario_atual, categoria = :categoria,
                      fornecedor = :fornecedor
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->unidade_medida = htmlspecialchars(strip_tags($this->unidade_medida));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->fornecedor = htmlspecialchars(strip_tags($this->fornecedor));

        // Bind dos parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':unidade_medida', $this->unidade_medida);
        $stmt->bindParam(':estoque_atual', $this->estoque_atual);
        $stmt->bindParam(':estoque_minimo', $this->estoque_minimo);
        $stmt->bindParam(':custo_unitario_atual', $this->custo_unitario_atual);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':fornecedor', $this->fornecedor);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Excluir insumo (soft delete)
     */
    public function excluir() {
        $query = "UPDATE " . $this->table_name . " SET ativo = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Buscar insumos por categoria
     */
    public function buscarPorCategoria($categoria) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE categoria = :categoria AND ativo = 1 
                  ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Atualizar estoque após compra
     */
    public function atualizarEstoque($quantidade, $custo_unitario) {
        $query = "UPDATE " . $this->table_name . " 
                  SET estoque_atual = estoque_atual + :quantidade,
                      custo_unitario_atual = :custo_unitario
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':custo_unitario', $custo_unitario);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
