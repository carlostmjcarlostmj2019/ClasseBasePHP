<?php
include 'classe/classe.php';

// Substitua 'usuarios' pelo nome da sua tabela de usuários
$minhaClasse = new Classe('usuarios');

// Verificar se o ID foi fornecido na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obter os dados do registro pelo ID
    $registroAntigo = $minhaClasse->ObterPeloID($id);

    // Verificar se o registro existe
    if ($registroAntigo) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obter os novos dados do formulário
            $novosDados = array();
            foreach ($registroAntigo as $campo => $valorAntigo) {
                // Verificar se o campo existe no $_POST antes de atribuir
                if (isset($_POST[$campo])) {
                    $novosDados[$campo] = $_POST[$campo];
                } else {
                    // Se o campo não existir no $_POST, manter o valor antigo
                    $novosDados[$campo] = $valorAntigo;
                }
            }

            // Atualizar o registro com os novos dados
            if ($minhaClasse->Atualizar($id, $novosDados)) {
                $mensagem = "Registro atualizado com sucesso!";
            } else {
                $mensagem = "Erro ao atualizar registro.";
            }
        }
    } else {
        $mensagem = "Nenhum registro encontrado com o ID fornecido.";
    }
} else {
    $mensagem = "Por favor, forneça um ID válido na URL.";
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Registro por ID</title>
</head>
<body>
    <h2>Atualizar Registro por ID</h2>
    <?php if(isset($mensagem)) echo "<p>$mensagem</p>"; ?>
    <form method="get">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id">
        <button type="submit">Buscar</button>
    </form>

    <?php if(isset($registroAntigo)) { ?>
    <h3>Dados do Registro Atual</h3>
    <form method="post">
        <?php foreach ($registroAntigo as $campo => $valorAntigo) { ?>
            <div>
                <label for="<?php echo $campo; ?>"><?php echo ucfirst($campo); ?>:</label>
                <input type="text" id="<?php echo $campo; ?>" name="<?php echo $campo; ?>" value="<?php echo $valorAntigo; ?>">
            </div>
        <?php } ?>
        <button type="submit">Atualizar</button>
    </form>
    <?php } ?>
</body>
</html>
