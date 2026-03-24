<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once 'conexao.php';
$con->set_charset("utf8");

$jsonParam = json_decode(file_get_contents('php://input'), true);

if (!$jsonParam) {
    echo json_encode(['success' => false, 'message' => 'Dados JSON inválidos ou ausentes.']);
    exit;
}

// Extração e sanitização dos dados baseados na tabela 'membro'
$idMembro              = trim($jsonParam['idMembro'] ?? '');
$nmNome                = trim($jsonParam['nmNome'] ?? '');
$nrCPF                 = trim($jsonParam['nrCPF'] ?? '');
$nrEntrada             = $jsonParam['nrEntrada'] ?? date('Y-m-d'); // Assume data atual se vazio
$flAtivo               = trim($jsonParam['flAtivo'] ?? 'S');       // 'S' ou 'N'
$Atribucao_idAtribucao = intval($jsonParam['Atribucao_idAtribucao'] ?? 0);

// Validação de campos obrigatórios
if (empty($idMembro) || empty($nmNome) || empty($nrCPF) || $Atribucao_idAtribucao <= 0) {
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios (ID, Nome, CPF e Atribuição).']);
    exit;
}

// Preparar a query de inserção
$stmt = $con->prepare("
    INSERT INTO membro (idMembro, nmNome, nrCPF, nrEntrada, flAtivo, Atribucao_idAtribucao)
    VALUES (?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta: ' . $con->error]);
    exit;
}

// Bind dos parâmetros: 
// s = string, i = integer
// Ordem: idMembro(s), nmNome(s), nrCPF(s), nrEntrada(s), flAtivo(s), Atribucao_idAtribucao(i)
$stmt->bind_param("sssssi", $idMembro, $nmNome, $nrCPF, $nrEntrada, $flAtivo, $Atribucao_idAtribucao);

// Execução e resposta
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Membro cadastrado com sucesso!']);
} else {
    // Tratamento para erro de duplicidade (Entry duplicate for key 'nrCPF_UNIQUE' ou 'PRIMARY')
    if ($con->errno == 1062) {
        echo json_encode(['success' => false, 'message' => 'Erro: O ID ou CPF informado já está cadastrado.']);
    } else if ($con->errno == 1452) {
        echo json_encode(['success' => false, 'message' => 'Erro: A Atribuição informada não existe.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no registro: ' . $stmt->error]);
    }
}

$stmt->close();
$con->close();

?>