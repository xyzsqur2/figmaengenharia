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
// Criar conexão
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if($_GET["password"] == 'mostreosipssalvosateagora') {
    // Consulta SQL
    $sql = "SELECT id, ip, largura_da_tela, altura_da_tela, dispositivo, latitude, longitude, cookies, data FROM ip_visitantes";
    $result = $conn->query($sql);

    // Início da tabela com estilo CSS embutido
    echo '<div class="container mt-5" id="table-container">';
    echo '<style>
            .table-container {
                margin-top: 20px;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            .table th, .table td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
            }
            .table tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            .table tr:hover {
                background-color: #ddd;
            }
          </style>';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>IP</th>';
    echo '<th>Largura da Tela</th>';
    echo '<th>Altura da Tela</th>';
    echo '<th>Dispositivo</th>';
    echo '<th>Latitude</th>';
    echo '<th>Longitude</th>';
    echo '<th>Cookies</th>';
    echo '<th>Data</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Verificar se há resultados
    if ($result->num_rows > 0) {
        // Exibir dados de cada linha
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . $row["ip"] . '</td>';
            echo '<td>' . $row["largura_da_tela"] . '</td>';
            echo '<td>' . $row["altura_da_tela"] . '</td>';
            echo '<td>' . $row["dispositivo"] . '</td>';
            echo '<td>' . $row["latitude"] . '</td>';
            echo '<td>' . $row["longitude"] . '</td>';
            echo '<td>' . $row["cookies"] . '</td>';
            echo '<td>' . $row["data"] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="9">0 resultados</td></tr>';
    }

    // Fim da tabela
    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    // Adicionar JavaScript para recarregar a div a cada 5 segundos
    echo '<script>
            function reloadDiv() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("table-container").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "consulta.php?password=mostreosipssalvosateagora", true);
                xhttp.send();
            }
            setInterval(reloadDiv, 5000);
          </script>';

    // Fechar conexão
    $conn->close();
} 
?>
