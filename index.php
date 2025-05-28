<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de IMC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Calcule seu IMC</h1>
    </header>
    <main>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <label>Nome</label>
            <input type="text" name="nome" required>
            
            <label>Idade</label>
            <input type="number" name="idade" required>

            <div class="sexo">
                <label>Sexo: </label>

                <label for="homem">Homem</label>
                <input type="radio" id="homem" value="homem" name="sexo" required>
                <label for="mulher">Mulher</label>
                <input type="radio" id="mulher" value="mulher" name="sexo" required>
            </div>
            
            <label>Sua altura</label>
            <input type="number" name="altura" required>
            
            <label>Peso</label>
            <input type="number" name="peso" required>

            <div class="buttons">
                <input type="reset" name="reset" id="reset">
                <input type="submit" name="submit" id="submit" value="continuar">
            </div>
        </form>
    </main>
</body>
</html>
<?php
include("database.php");
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$sexo = $_POST['sexo'];
$altura = $_POST['altura']/100;
$peso = $_POST['peso'];

    if ($idade >= 100 || $idade <= 0) {
        echo"idade invalida!<br>";
    }
    if ($altura <= 1.0 || $altura >= 3) {
        echo"altura inválida!<br>";
    }
    
$imc = round($peso/($altura ** 2), 2);
    if ($idade && $altura) {
        echo"Seu IMC: {$imc}<br>";
    }
$conteudo = file_get_contents('dados.json');
$dados = json_decode($conteudo, true);
    if (!$dados) {
        $dados = [];
    }
$dados[] = [
    'nome' => $nome,
    'idade' => $idade,
    'sexo' => $sexo,
    'altura' => $altura,
    'peso' => $peso,
    'imc' => $imc
];
file_put_contents('dados.json', json_encode($dados, JSON_PRETTY_PRINT));

$sql = "INSERT INTO imcsdb (nome, idade, sexo, altura, peso, imc)
        VALUES ('$nome', '$idade', '$sexo', '$altura', '$peso', '$imc')";
try{
    mysqli_query($conn, $sql);
    echo"Dados registrados";
}
catch(mysqli_sql_exception){
    echo"Não foi possivel o registro dos dados";
}
mysqli_close($conn);
?>