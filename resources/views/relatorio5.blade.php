<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "desafio_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$relatorio = "";

$sql = "SELECT categorias.titulo, MONTH(lancamentos.liquidacao) as mes, SUM(lancamentos.valor_liquidado) as total_despesa
        FROM lancamentos
        LEFT JOIN categorias ON lancamentos.categoria_id = categorias.id
        WHERE lancamentos.tipo = 'receber' AND lancamentos.status = 'liquidado'
        GROUP BY categorias.titulo, MONTH(lancamentos.liquidacao)
        ORDER BY MONTH(lancamentos.liquidacao) ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $relatorio .= "<table>";
    $relatorio .= "<tr><th>Categoria</th><th>Mês</th><th>Total Despesas</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $relatorio .= "<tr>
            <td>{$row['titulo']}</td>
            <td>{$row['mes']}</td>
            <td>{$row['total_despesa']}</td>
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
    <title>Relatório 5</title>

</head>

<body>

    <div class="container">
        <button onclick="window.location.href='/desafio-database/public/'">Voltar</button>
        <h1>Relatório 5</h1>

        <div class="description">
            Total de despesas liquidadas, por categoria mensal:
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