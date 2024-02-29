<?php
include 'classe/classe.php';

// Substitua 'usuarios' pelo nome da sua tabela de usuários
$minhaClasse = new Classe('usuarios');
$minhaClasse->CamposPermitidos([]); // Definindo campos permitidos vazios por enquanto
$minhaClasse->CamposBloqueados(['id', 'data_cadastro']); // Definindo campos bloqueados
$campos = $minhaClasse->ObterCampos();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar o formulário quando enviado
    $dados = array();
    foreach ($campos as $campo) {
        $dados[$campo] = $_POST[$campo];
    }
    
    if ($minhaClasse->criarRegistro($dados)) {
        $mensagem = "Registro criado com sucesso!";
    } else {
        $mensagem = "Erro ao criar registro.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
</head>
<body>
    <h2>Cadastro de Usuários</h2>
    <?php if(isset($mensagem)) echo "<p>$mensagem</p>"; ?>
    <form method="post">
        <?php foreach ($campos as $campo) { ?>
            <div>
                <label for="<?php echo $campo; ?>"><?php echo ucfirst($campo); ?>:</label>
                <input type="text" id="<?php echo $campo; ?>" name="<?php echo $campo; ?>">
            </div>
        <?php } ?>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
