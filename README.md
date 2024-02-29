# Classe para Manipulação de Tabelas no MySQL

Esta classe em PHP oferece métodos simples para realizar operações básicas de manipulação de tabelas em um banco de dados MySQL, como criar, ler, atualizar e excluir registros.

## Requisitos

- PHP 5.6 ou superior
- MySQL

## Como usar

1. Baixe o arquivo `classe.php` e inclua-o no seu projeto PHP.
2. Crie uma instância da classe `Classe`, passando o nome da tabela como parâmetro:
    ```php
    $minhaClasse = new Classe('nome_da_tabela');
    ```
3. (Opcional) Defina os campos permitidos e bloqueados usando os métodos `CamposPermitidos` e `CamposBloqueados`:
    ```php
    $minhaClasse->CamposPermitidos(['campo1', 'campo2']);
    $minhaClasse->CamposBloqueados(['campo3', 'campo4']);
    ```
4. Utilize os métodos da classe conforme necessário:

### Operações Disponíveis:

- Criar um novo registro:
    ```php
    $dados = array('campo1' => 'valor1', 'campo2' => 'valor2');
    $minhaClasse->Criar($dados);
    ```

- Obter todos os registros:
    ```php
    $registros = $minhaClasse->ObterTodos();
    ```

- Obter um registro pelo ID:
    ```php
    $id = 1;
    $registro = $minhaClasse->ObterPeloID($id);
    ```

- Atualizar um registro:
    ```php
    $id = 1;
    $novosDados = array('campo1' => 'novo_valor1', 'campo2' => 'novo_valor2');
    $minhaClasse->Atualizar($id, $novosDados);
    ```

- Excluir um registro:
    ```php
    $id = 1;
    $minhaClasse->Delete($id);
    ```

## Contribuições

Sinta-se à vontade para contribuir com melhorias, correções de bugs ou novos recursos através de pull requests.
