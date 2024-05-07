<?php

include_once './database_config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: Ocorreu um erro ao conectar ao banco de dados.";
    exit;
}

// Obter o endereço IP externo do usuário
function obterEnderecoIp()
{
    $ipServiceUrl = 'https://api.ipify.org?format=json';

    // Solicitação para obter o IP externo
    $response = file_get_contents($ipServiceUrl);

    // Decodifica a resposta JSON
    $ipData = json_decode($response, true);

    return $ipData['ip'];
}

$ip = obterEnderecoIp();

// Verifica se o formulário foi enviado e recuperar os dados do formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $cargo = $_POST["cargo"];
    $escolaridade = $_POST["escolaridade"];
    $observacoes = $_POST["observacoes"]; 
    $dataHoraEnvio = date("Y-m-d H:i:s");

    // Validações básicas
    if (empty($nome) || empty($email) || empty($telefone) || empty($cargo)) {
        echo "Erro: Todos os campos obrigatórios devem ser preenchidos.";
        exit;
    }

    // Validação do arquivo
    $tamanhoMaximo = 1 * 1024 * 1024; // 1MB
    $extensoesPermitidas = ["doc", "docx", "pdf"];
    $arquivo = $_FILES["arquivo"];

    if ($arquivo["error"] !== UPLOAD_ERR_OK) {
        echo "Erro ao enviar o arquivo.";
        exit;
    }

    $extensao = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
    if (!in_array($extensao, $extensoesPermitidas)) {
        echo "Erro: Extensão de arquivo não permitida.";
        exit;
    }

    if ($arquivo["size"] > $tamanhoMaximo) {
        echo "Erro: Tamanho do arquivo excede o limite permitido.";
        exit;
    }

    // local de armazenamento do arquivo 
    $diretorio = "../uploads/";
    $arquivoPath = $diretorio . basename($arquivo["name"]);
    if (!move_uploaded_file($arquivo["tmp_name"], $arquivoPath)) {
        echo "Erro ao salvar o arquivo.";
        exit;
    }

    // Insert dos dados no banco de dados
    $sql = "INSERT INTO curriculos (nome, email, telefone, cargo, escolaridade, observacoes, arquivo_path, data_hora_envio, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $nome);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $telefone);
    $stmt->bindParam(4, $cargo);
    $stmt->bindParam(5, $escolaridade);
    $stmt->bindParam(6, $observacoes);
    $stmt->bindParam(7, $arquivoPath);
    $stmt->bindParam(8, $dataHoraEnvio);
    $stmt->bindParam(9, $ip);
    $stmt->execute();

    echo "Formulário enviado com sucesso!";
} else {
    echo "Erro: O formulário não foi enviado.";
}
