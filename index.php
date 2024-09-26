<?php
// Inclui a configuração de conexão
include('config.php');

// Verifica se o formulário foi enviado
if (isset($_POST['usuario']) || isset($_POST['senha'])) {
    // Verifica se o campo de usuário foi preenchido
    if (strlen($_POST['usuario']) == 0) {
        echo "<div class='error-message'>Preencha seu Usuário</div>";
    }
    // Verifica se o campo de senha foi preenchido
    else if (strlen($_POST['senha']) == 0) {
        echo "<div class='error-message'>Preencha sua senha</div>";
    } 
    else {
        // Protege contra SQL Injection
        $usuario = $conexao->real_escape_string($_POST['usuario']);
        $senha = $conexao->real_escape_string($_POST['senha']);

        // Executa a consulta no banco de dados
        $sql_code = "SELECT * FROM login1 WHERE usuario = '$usuario' AND senha = '$senha'";
        $sql_query = $conexao->query($sql_code) or die("Falha na execução do código SQL: " . $conexao->error);
        
        // Verifica se o login foi bem-sucedido
        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            // Inicia a sessão caso ainda não tenha sido iniciada
            if (!isset($_SESSION)) {
                session_start();
            }

            // Define variáveis de sessão
            $_SESSION['id'] = $usuario['id_login'];
            $_SESSION['nome'] = $usuario['usuario'];

            // Redireciona para outra página após login bem-sucedido
            header("Location: pedido.php");
        } else {
            echo "<div class='error-message'>Falha ao logar! Usuário ou senha incorretos</div>";
        }
    }
}
?>
