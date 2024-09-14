<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "desafio_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$stmt_tag = $conn->prepare("INSERT INTO tags (titulo) VALUES (?)");
$stmt_tag->bind_param("s", $tag);

$tags = [
    'Mega Sena',
    'Quina',
    'Lotofácil',
    'Lotomania',
    'Dupla Sena',
    'Timemania',
    'Dia de Sorte',
    'Super Sete',
    'Loteria Federal',
    'Milionaria+'
];

$categorias = [
    'Sorteio Diário',
    'Sorteio Semanal',
    'Sorteio Especial',
    'Loteria Federal',
    'Loteria Estadual',
    'Sorteio de Natal',
    'Sorteio de Ano Novo',
    'Sorteios Comemorativos',
    'Promoções do Dia',
    'Mega da Virada'
];

foreach ($tags as $tag) {
    $stmt_tag->execute();
    if ($stmt_tag->error) {
        echo "Erro ao inserir a tag '$tag': " . $stmt_tag->error . "\n";
    } else {
        echo "Tag '$tag' inserida com sucesso.\n";
    }
}

$stmt_categoria = $conn->prepare("INSERT INTO categorias (titulo) VALUES (?)");
$stmt_categoria->bind_param("s", $categoria);


foreach ($categorias as $categoria) {
    $stmt_categoria->execute();
    if ($stmt_categoria->error) {
        echo "Erro ao inserir a categoria '$categoria': " . $stmt_categoria->error . "\n";
    } else {
        echo "Categoria '$categoria' inserida com sucesso.\n";
    }
}

$stmt_tag->close();
$stmt_categoria->close();
$conn->close();
