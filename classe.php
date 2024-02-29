<?php

class Classe {
    private $conexao;
    private $tabela;
    private $camposPermitidos;
    private $camposBloqueados;

    public function __construct($Nome) {
        $this->conexao = new mysqli('localhost', 'root', '', 'bba');
        if ($this->conexao->connect_error) {
            die("Erro de conexão: " . $this->conexao->connect_error);
        }
        $this->tabela = $Nome;
    }

    public function CamposPermitidos($camposPermitidos) {
        $this->camposPermitidos = $camposPermitidos;
    }

    public function CamposBloqueados($camposBloqueados) {
        $this->camposBloqueados = $camposBloqueados;
    }

    public function ObterCampos() {
        $query = "SHOW COLUMNS FROM $this->tabela";
        $resultado = $this->conexao->query($query);

        $campos = array();
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                // Verifica se o campo está na lista de campos permitidos
                if (empty($this->camposPermitidos) || in_array($row['Field'], $this->camposPermitidos)) {
                    // Verifica se o campo não está na lista de campos bloqueados
                    if (empty($this->camposBloqueados) || !in_array($row['Field'], $this->camposBloqueados)) {
                        $campos[] = $row['Field'];
                    }
                }
            }
        }

        return $campos;
    }

    public function Criar($dados) {
        $camposPermitidos = array_intersect_key($dados, array_flip($this->camposPermitidos));
        $campos = implode(', ', array_keys($camposPermitidos));
        $valores = "'" . implode("', '", array_values($camposPermitidos)) . "'";
        $query = "INSERT INTO $this->tabela ($campos) VALUES ($valores)";
        $resultado = $this->conexao->query($query);

        if ($resultado) {
            return true; // Sucesso na inserção
        } else {
            return false; // Falha na inserção
        }
    }

    public function ObterTodos() {
    // Monta uma string com os nomes dos campos permitidos
    $camposPermitidos = !empty($this->camposPermitidos) ? implode(', ', $this->camposPermitidos) : "*";

    // Monta a consulta SQL apenas com os campos permitidos
    $query = "SELECT $camposPermitidos FROM $this->tabela";
    $resultado = $this->conexao->query($query);

    $registros = array();
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            // Se houver campos bloqueados, remove-os do registro retornado
            if (!empty($this->camposBloqueados)) {
                foreach ($this->camposBloqueados as $campoBloqueado) {
                    unset($row[$campoBloqueado]);
                }
            }
            $registros[] = $row;
        }
    }

    return $registros;
}



    public function ObterPeloID($id) {
        // Monta uma string com os nomes dos campos permitidos
        $camposPermitidos = empty($this->camposPermitidos) ? "*" : implode(', ', $this->camposPermitidos);

        // Monta uma string com os nomes dos campos bloqueados
        $camposBloqueados = empty($this->camposBloqueados) ? "" : implode(', ', $this->camposBloqueados);

        // Verifica se há campos bloqueados definidos
        $camposSelecionados = empty($camposBloqueados) ? $camposPermitidos : "*";

        // Monta a consulta SQL apenas com os campos permitidos
        $query = "SELECT $camposSelecionados FROM $this->tabela WHERE id = $id";
        $resultado = $this->conexao->query($query);

        if ($resultado->num_rows > 0) {
            // Se houver campos bloqueados, remove-os do registro retornado
            if (!empty($camposBloqueados)) {
                $registro = $resultado->fetch_assoc();
                foreach ($this->camposBloqueados as $campoBloqueado) {
                    unset($registro[$campoBloqueado]);
                }
                return $registro;
            } else {
                return $resultado->fetch_assoc(); // Retorna o registro encontrado
            }
        } else {
            return null; // Retorna null se não encontrar o registro
        }
    }

    public function Atualizar($id, $dados) {
        $set = '';
        foreach ($dados as $campo => $valor) {
            $set .= "$campo = '$valor', ";
        }
        $set = rtrim($set, ', ');

        $query = "UPDATE $this->tabela SET $set WHERE id = $id";
        $resultado = $this->conexao->query($query);

        if ($resultado) {
            return true; // Sucesso na atualização
        } else {
            return false; // Falha na atualização
        }
    }

    public function Delete($id) {
        $query = "DELETE FROM $this->tabela WHERE id = $id";
        $resultado = $this->conexao->query($query);

        if ($resultado) {
            return true; // Sucesso na exclusão
        } else {
            return false; // Falha na exclusão
        }
    }
}

?>
