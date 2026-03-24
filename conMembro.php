<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexao.php';
$con->set_charset("utf8");

/**
 * SQL ajustado para trazer os dados do Membro e o nome do cargo (nmCargo) 
 * da tabela Atribucao através do JOIN.
 */
$sql = "SELECT 
            m.idMembro, 
            m.nmNome, 
            m.nrCPF, 
            m.nrEntrada, 
            m.flAtivo,
            m.Atribucao_idAtribucao,
            a.nmCargo,
            a.nrHoras
        FROM membro m
        INNER JOIN atribucao a ON a.idAtribucao = m.Atribucao_idAtribucao";

$result = $con->query($sql);

$response = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    // Retorno de um array vazio ou objeto estruturado se não houver registros
    // Dica: Retornar um array vazio [] é mais comum para listagens sem dados
    $response = []; 
    
    /* Caso você precise MESMO do objeto vazio para manter a estrutura no front-end, 
    descomente as linhas abaixo:
    
    $response[] = [
        "idMembro" => "",
        "nmNome" => "",
        "nrCPF" => "",
        "nrEntrada" => "0000-00-00",
        "flAtivo" => "",
        "Atribucao_idAtribucao" => 0,
        "nmCargo" => "",
        "nrHoras" => 0
    ];
    */
}

// Define o cabeçalho e entrega o JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$con->close();
?>