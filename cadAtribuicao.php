<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define o cabeçalho para JSON
header('Content-Type: application/json');

// Conexão com o banco (certifique-se que o arquivo conexao.php define a variável $con)
require_once 'conexao.php';
$con->set_charset("utf8");

// Obtém o input JSON
$jsonParam = json_decode(file_get_contents('php://input'), true);

if (!$jsonParam) {
    echo json_encode(['success' => false, 'message' => 'Dados JSON inválidos ou ausentes.']);
    exit;
}

// Extração e sanitização dos dados baseados na tabela 'atribucao'
$idAtribucao = intval($jsonParam['idAtribucao'] ?? 0);
$nmCargo     = trim($jsonParam['nmCargo'] ?? '');
$nrHoras     = floatval($jsonParam['nrHoras'] ?? 0);

// Validação básica (campos obrigatórios conforme o seu CREATE TABLE)
if (empty($nmCargo)) {
    echo json_encode(['success' => false, 'message' => 'O campo nmCargo é obrigatório.']);
    exit;
}

// Preparar a query (Incluindo idAtribucao pois não está como auto_increment no seu SQL)
$stmt = $con->prepare("
    INSERT INTO atribucao (idAtribucao, nmCargo, nrHoras)
    VALUES (?, ?, ?)
");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta: ' . $con->error]);
    exit;
}

// Bind dos parâmetros: i (integer), s (string), d (double/decimal)
$stmt->bind_param("isd", $idAtribucao, $nmCargo, $nrHoras);

// Execução e resposta
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Atribuição inserida com sucesso!']);
} else {
    // Tratamento para caso o nmCargo já exista (UNIQUE KEY)
    if ($con->errno == 1062) {
        echo json_encode(['success' => false, 'message' => 'Erro: Este cargo já está cadastrado.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no registro: ' . $stmt->error]);
    }
}

$stmt->close();
$con->close();

?>