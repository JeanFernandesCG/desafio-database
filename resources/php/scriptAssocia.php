<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "desafio_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$cadastros = [];
$tags = [];

$result = $conn->query("SELECT id FROM cadastros");
while ($row = $result->fetch_assoc()) {
    $cadastros[] = $row['id'];
}

$result = $conn->query("SELECT id FROM tags");
while ($row = $result->fetch_assoc()) {
    $tags[] = $row['id'];
}

$stmt = $conn->prepare("INSERT INTO cadastros_tags (cadastro_id, tag_id) VALUES (?, ?)");
$stmt->bind_param("ii", $cadastro_id, $tag_id);

foreach ($cadastros as $cadastro_id) {

    $tag_ids = array_rand($tags, rand(1, 5));

    if (!is_array($tag_ids)) {
        $tag_ids = [$tag_ids];
    }

    foreach ($tag_ids as $tag_index) {
        $tag_id = $tags[$tag_index];

        $stmt->execute();

        if ($stmt->error) {
            echo "Erro ao associar a tag $tag_id ao cadastro $cadastro_id: " . $stmt->error . "\n";
        } else {
            echo "Tag $tag_id associada ao cadastro $cadastro_id com sucesso.\n";
        }
    }
}

$stmt->close();
$conn->close();
