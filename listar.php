<?php
require('classe/classe.php');

// Instanciando a Classe com o nome da tabela 'usuarios'
$usuarios = new Classe('usuarios');

// Obtendo todos os registros da tabela de usuarios
$usuarioss = $usuarios->ObterTodos();

foreach ($usuarioss as $usuario) {
    echo $usuario['nome'].'<br>';
}
?>
