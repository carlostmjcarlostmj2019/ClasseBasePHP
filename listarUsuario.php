<?php
include 'classe/classe.php';

// Cria uma instância da classe Classe, especificando a tabela 'usuarios'
$minhaClasse = new Classe('usuarios');


// ---------------- CAMPOS QUE PODEM OU NAO SER EXIBIDOS ----------------//

// Definindo os campos que serão bloqueados ao exibir os registros
// $minhaClasse->CamposBloqueados(['id', 'data_cadastro']); 

// Definindo os campos que serão permitidos ao exibir os registros
 $minhaClasse->CamposPermitidos(['nome', 'email']); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o ID foi fornecido via formulário POST
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        // Busca o registro na tabela com o ID fornecido
        $registro = $minhaClasse->GetById($id);
        if ($registro) {
            $mensagem = "Registro encontrado!";
        } else {
            $mensagem = "Nenhum registro encontrado com o ID fornecido.";
        }
    } else {
        $mensagem = "Por favor, forneça um ID válido.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obter Registro por ID</title>
</head>
<body>
    <h2>Obter Registro por ID</h2>
    <?php if(isset($mensagem)) echo "<p>$mensagem</p>"; ?>
    <form method="post">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id">
        <button type="submit">Buscar</button>
    </form>

    <?php if(isset($registro)) { ?>
    <h3>Dados do Registro</h3>
    <ul>
        <?php 
        // Exibe os dados do registro encontrados, apenas os campos permitidos serão mostrados
        foreach ($registro as $campo => $valor) { ?>
            <li><strong><?php echo ucfirst($campo); ?>:</strong> <?php echo $valor; ?></li>
        <?php } ?>
    </ul>
    <?php } ?>
</body>
</html>
