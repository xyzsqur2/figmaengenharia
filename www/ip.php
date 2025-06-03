<?php
require './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dbHost = $_ENV['DB_HOST'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];
$dbName = $_ENV['DB_NAME'];
echo "Host do Banco de Dados: " . $dbHost;

// Definir cabeçalhos para permitir requisições de qualquer origem
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Configuração do banco de dados
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter dados do POST
$data = json_decode(file_get_contents('php://input'), true);
$ip = $data['ip'];
$largura_da_tela = $data["largura_da_tela"];
$altura_da_tela = $data["altura_da_tela"];
$dispositivo = $data["dispositivo"];
$latitude = $data["latitude"];
$longitude = $data["longitude"];
$cookies = json_encode($data["cookies"]); // Convertendo cookies para JSON

if ($ip) {
    // Preparar e vincular
    $stmt = $conn->prepare("INSERT INTO ip_visitantes (ip, largura_da_tela, altura_da_tela, dispositivo, latitude, longitude, cookies) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $ip, $largura_da_tela, $altura_da_tela, $dispositivo, $latitude, $longitude, $cookies);

    // Executar a declaração
    if ($stmt->execute()) {
        echo "Novo IP inserido com sucesso";
    } else {
        echo "Erro ao inserir IP: " . $stmt->error;
    }

    // Fechar a declaração
    $stmt->close();
} else {
    echo "Dados de IP inválidos";
}

// Fechar a conexão
$conn->close();
?>
