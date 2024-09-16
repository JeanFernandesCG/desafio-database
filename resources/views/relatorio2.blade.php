<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "desafio_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

function formatarDocumento($documento)
{

    $documento = preg_replace("/[^0-9]/", "", $documento);


    if (strlen($documento) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $documento);
    } elseif (strlen($documento) === 14) {
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $documento);
    }


    return $documento;
}


$relatorio = "";


$sql = "SELECT cadastros.nome, cadastros.documento, lancamentos.descricao, lancamentos.liquidacao, lancamentos.valor_liquidado 
        FROM lancamentos
        LEFT JOIN cadastros ON lancamentos.cadastro_id = cadastros.id
        WHERE lancamentos.tipo = 'receber' AND lancamentos.status = 'liquidado'
        ORDER BY cadastros.nome";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $relatorio .= "<table>";
    $relatorio .= "<tr><th>Nome</th><th>Documento</th><th>Descrição</th><th>Liquidação</th><th>Valor Liquidado</th></tr>";
    while ($row = $result->fetch_assoc()) {

        $liquidacao = date("d/m/Y", strtotime($row['liquidacao']));

        $documento_formatado = formatarDocumento($row['documento']);

        $relatorio .= "<tr>
            <td>{$row['nome']}</td>
            <td>{$documento_formatado}</td>
            <td>{$row['descricao']}</td>
            <td>{$liquidacao}</td>
            <td>{$row['valor_liquidado']}</td>
        </tr>";
    }
    $relatorio .= "</table>";
} else {
    $relatorio = "Nenhum registro encontrado.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório 2</title>

</head>

<body>

    <div class="container">
        <button onclick="window.location.href='/desafio-database/public/'">Voltar</button>
        <h1>Relatório 2</h1>

        <div class="description">
            Lista de receitas liquidadas em um determinado período:
        </div>

        <div class="box">
            <h3>Resultado do Relatório</h3>
            <?php if (!empty($relatorio)) {
                echo $relatorio;
            } else {
                echo "Nenhum dado encontrado.";
            } ?>

        </div>

    </div>

</body>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 40px auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .description {
        text-align: center;
        margin: 20px 0;
        font-size: 18px;
        color: #555;
    }

    .box {
        border: 1px solid #ccc;
        padding: 15px;
        margin: 20px 0;
        background: #f9f9f9;
        border-radius: 8px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    table,
    th,
    td {
        border: 1px solid #ccc;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    button {
        padding: 10px 15px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: block;
        margin: 0 left;
    }

    button:hover {
        background-color: #0056b3;
    }

    .order-form {
        text-align: left;
        margin: 0px left;
    }

    .order-form select {
        padding: 0px;
        font-size: 16px;
    }
</style>

</html>