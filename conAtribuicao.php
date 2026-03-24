<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexao.php';
$con->set_charset("utf8");

// SQL com JOIN selecionando todos os campos das duas tabelas
$sql = "SELECT 
            a.idAtribucao, 
            a.nmCargo, 
            a.nrHoras, 
            m.idMembro, 
            m.nmNome, 
            m.nrCPF, 
            m.nrEntrada, 
            m.flAtivo,
            m.Atribucao_idAtribucao 
        FROM atribucao a 
        JOIN membro m ON a.idAtribucao = m.Atribucao_idAtribucao";

$result = $con->query($sql);

$response = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    // Array completo com todos os campos das duas tabelas para manter a estrutura do JSON estável
    $response[] = [
        "idAtribucao" => 0,
        "nmCargo" => "",
        "nrHoras" => 0,
        "idMembro" => "",
        "nmNome" => "",
        "nrCPF" => "",
        "nrEntrada" => "0000-00-00",
        "flAtivo" => "",
        "Atribucao_idAtribucao" => 0
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_UNESCAPED_UNICODE);

$con->close();
?>