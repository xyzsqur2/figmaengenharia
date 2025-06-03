<?php
require './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dbHost = $_ENV['DB_HOST'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];
$dbName = $_ENV['DB_NAME'];
// Definir cabeçalhos para permitir requisições de qualquer origem
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");

// Conexão com o banco de dados
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para redirecionar a página 


// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $experiencia = $_POST["experiencia"];
    $formacao = $_POST["formacao"];
    $habilidades = $_POST["habilidades"];
    
    // Processa o arquivo PDF do currículo
    $curriculo_path = null;
    if (isset($_FILES["curriculo"]) && $_FILES["curriculo"]["error"] == 0) {
        $target_dir = "uploads/curriculos/";
        $target_file = $target_dir . basename($_FILES["curriculo"]["name"]);
        if (move_uploaded_file($_FILES["curriculo"]["tmp_name"], $target_file)) {
            $curriculo_path = $target_file;
        } else {
            echo "Erro ao fazer upload do arquivo.";
            exit;
        }
    }

    // Insere os dados no banco de dados
    $stmt = $conn->prepare("INSERT INTO curriculos (nome, email, telefone, endereco, experiencia, formacao, habilidades, curriculo_pdf) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nome, $email, $telefone, $endereco, $experiencia, $formacao, $habilidades, $curriculo_path);

    if ($stmt->execute()) {
        echo "Currículo enviado com sucesso!"; 
        
    } else {
        echo "Erro ao enviar currículo: " . $stmt->error;
    }
   
    $stmt->close();
}

$conn->close();



?>
