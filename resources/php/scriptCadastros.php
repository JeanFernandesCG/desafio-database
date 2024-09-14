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

$stmt = $conn->prepare("INSERT INTO cadastros (nome, documento, cep, estado, cidade, endereco) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nome, $documento, $cep, $estado, $cidade, $endereco);

for ($i = 0; $i < 100; $i++) {

    $nome = $faker->name;
    $documento = (rand(0, 1) == 1) ? $faker->cpf(false) : $faker->cnpj(false);
    $cep = $faker->postcode;
    $estado = $faker->stateAbbr;
    $cidade = $faker->city;
    $endereco = $faker->streetAddress;

    $sql = "INSERT INTO cadastros (nome, documento, cep, estado, cidade, endereco)
            VALUES ('$nome', '$documento', '$cep', '$estado', '$cidade', '$endereco')";

    $stmt->execute();

    if ($stmt->error) {
        echo "Erro ao inserir o cadastro $i: " . $stmt->error . "\n";
    } else {
        echo "Cadastro $i inserido com sucesso.\n";
    }
}

$stmt->close();
$conn->close();
