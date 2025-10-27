<?php
/**
 * API para gerenciar Insumos
 * Sistema de Gestão da Doceria
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';
require_once '../models/Insumo.php';

$database = new Database();
$db = $database->getConnection();
$insumo = new Insumo($db);

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch($method) {
    case 'GET':
        if(isset($_GET['id'])) {
            // Buscar insumo específico
            if($insumo->buscarPorId($_GET['id'])) {
                echo json_encode(array(
                    'success' => true,
                    'data' => array(
                        'id' => $insumo->id,
                        'nome' => $insumo->nome,
                        'descricao' => $insumo->descricao,
                        'unidade_medida' => $insumo->unidade_medida,
                        'estoque_atual' => $insumo->estoque_atual,
                        'estoque_minimo' => $insumo->estoque_minimo,
                        'custo_unitario_atual' => $insumo->custo_unitario_atual,
                        'categoria' => $insumo->categoria,
                        'fornecedor' => $insumo->fornecedor
                    )
                ));
            } else {
                http_response_code(404);
                echo json_encode(array('success' => false, 'message' => 'Insumo não encontrado'));
            }
        } elseif(isset($_GET['categoria'])) {
            // Buscar por categoria
            $stmt = $insumo->buscarPorCategoria($_GET['categoria']);
            $insumos = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $insumos[] = $row;
            }
            echo json_encode(array('success' => true, 'data' => $insumos));
        } else {
            // Listar todos os insumos
            $stmt = $insumo->listar();
            $insumos = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $insumos[] = $row;
            }
            echo json_encode(array('success' => true, 'data' => $insumos));
        }
        break;

    case 'POST':
        // Criar novo insumo
        if(!empty($input['nome']) && !empty($input['unidade_medida'])) {
            $insumo->nome = $input['nome'];
            $insumo->descricao = $input['descricao'] ?? '';
            $insumo->unidade_medida = $input['unidade_medida'];
            $insumo->estoque_atual = $input['estoque_atual'] ?? 0;
            $insumo->estoque_minimo = $input['estoque_minimo'] ?? 0;
            $insumo->custo_unitario_atual = $input['custo_unitario_atual'] ?? 0;
            $insumo->categoria = $input['categoria'] ?? '';
            $insumo->fornecedor = $input['fornecedor'] ?? '';

            if($insumo->criar()) {
                http_response_code(201);
                echo json_encode(array('success' => true, 'message' => 'Insumo criado com sucesso'));
            } else {
                http_response_code(500);
                echo json_encode(array('success' => false, 'message' => 'Erro ao criar insumo'));
            }
        } else {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'Dados obrigatórios não fornecidos'));
        }
        break;

    case 'PUT':
        // Atualizar insumo
        if(!empty($input['id'])) {
            $insumo->id = $input['id'];
            $insumo->nome = $input['nome'] ?? '';
            $insumo->descricao = $input['descricao'] ?? '';
            $insumo->unidade_medida = $input['unidade_medida'] ?? '';
            $insumo->estoque_atual = $input['estoque_atual'] ?? 0;
            $insumo->estoque_minimo = $input['estoque_minimo'] ?? 0;
            $insumo->custo_unitario_atual = $input['custo_unitario_atual'] ?? 0;
            $insumo->categoria = $input['categoria'] ?? '';
            $insumo->fornecedor = $input['fornecedor'] ?? '';

            if($insumo->atualizar()) {
                echo json_encode(array('success' => true, 'message' => 'Insumo atualizado com sucesso'));
            } else {
                http_response_code(500);
                echo json_encode(array('success' => false, 'message' => 'Erro ao atualizar insumo'));
            }
        } else {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'ID do insumo não fornecido'));
        }
        break;

    case 'DELETE':
        // Excluir insumo
        if(!empty($input['id'])) {
            $insumo->id = $input['id'];
            if($insumo->excluir()) {
                echo json_encode(array('success' => true, 'message' => 'Insumo excluído com sucesso'));
            } else {
                http_response_code(500);
                echo json_encode(array('success' => false, 'message' => 'Erro ao excluir insumo'));
            }
        } else {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'ID do insumo não fornecido'));
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(array('success' => false, 'message' => 'Método não permitido'));
        break;
}
?>
