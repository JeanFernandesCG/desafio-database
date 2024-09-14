<?php
require_once 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "desafio_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$faker = Faker\Factory::create('pt_BR');

$cadastros = [];
$categorias = [];

$result = $conn->query("SELECT id FROM cadastros");
while ($row = $result->fetch_assoc()) {
    $cadastros[] = $row['id'];
}

$result = $conn->query("SELECT id FROM categorias");
while ($row = $result->fetch_assoc()) {
    $categorias[] = $row['id'];
}

if (count($cadastros) === 0 || count($categorias) === 0) {
    die("Erro: Não há cadastros ou categorias suficientes no banco de dados para continuar.");
}

$stmt = $conn->prepare("INSERT INTO lancamentos (tipo, status, descricao, valor, valor_liquidado, vencimento, liquidacao, cadastro_id, categoria_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssdsssii", $tipo, $status, $descricao, $valor, $valor_liquidado, $vencimento, $liquidacao, $cadastro_id, $categoria_id);

for ($i = 0; $i < 1000; $i++) {
    $tipo = (rand(0, 1) == 1) ? 'pagar' : 'receber';
    $status = (rand(0, 1) == 1) ? 'aberto' : 'liquidado';
    $descricao = $faker->sentence;
    $valor = $faker->randomFloat(2, 10, 1000);
    $valor_liquidado = ($status == 'liquidado') ? $valor : null;
    $vencimento = $faker->date();
    $liquidacao = ($status == 'liquidado') ? $faker->date() : null;
    $cadastro_id = $cadastros[array_rand($cadastros)];
    $categoria_id = $categorias[array_rand($categorias)];

    if (is_null($valor_liquidado)) {
        $valor_liquidado = null;
    }
    if (is_null($liquidacao)) {
        $liquidacao = null;
    }

    $stmt->execute();

    if ($stmt->error) {
        echo "Erro ao inserir o lançamento $i: " . $stmt->error . "\n";
    } else {
        echo "Lançamento $i inserido com sucesso.\n";
    }
}

$stmt->close();
$conn->close();
