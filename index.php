<?php
// Função para ler arquivos
function ler_arquivo($nome_arquivo) {
    if (!file_exists($nome_arquivo)) {
        return '';
    }
    return file_get_contents($nome_arquivo);
}

// Lê os valores dos arquivos
$titulo = ler_arquivo("titulo.txt");
$editacodigo = ler_arquivo("editacodigo.txt");
$openai = ler_arquivo("openai.txt");
$prompt = ler_arquivo("prompt.txt");

// Processamento dos formulários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['editacodigo'])) {
        file_put_contents("editacodigo.txt", $_POST['editacodigo']);
    }
    if (!empty($_POST['openai'])) {
        file_put_contents("openai.txt", $_POST['openai']);
    }
    if (!empty($_POST['prompt'])) {
        file_put_contents("prompt.txt", $_POST['prompt']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .input-group button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .input-group button:hover {
            background-color: #0056b3;
        }
        .progress-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($titulo) ?></h1>

        <h3>Editar API "EditaCódigo"</h3>
        <form method="POST">
            <div class="input-group">
                <input type="password" name="editacodigo" value="<?= htmlspecialchars($editacodigo) ?>" placeholder="Digite a API do EditaCódigo">
                <button type="submit">Salvar</button>
            </div>
        </form>

        <h3>Editar API da OpenAI</h3>
        <form method="POST">
            <div class="input-group">
                <input type="password" name="openai" value="<?= htmlspecialchars($openai) ?>" placeholder="Digite a API da OpenAI">
                <button type="submit">Salvar</button>
            </div>
        </form>

        <h3>Editar Prompt</h3>
        <form method="POST">
            <div class="input-group">
                <textarea name="prompt" placeholder="Digite o prompt aqui"><?= htmlspecialchars($prompt) ?></textarea>
            </div>
            <button type="submit">Salvar</button>
        </form>

        <!-- Barra de progresso simulada -->
        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
            <div class="progress-label" id="progressLabel">Processando</div>
        </div>
    </div>

    <script>
    let progress = 0;
    const progressBar = document.getElementById('progressBar');
    const progressLabel = document.getElementById('progressLabel');

    function updateProgress() {
        if (progress < 100) {
            progress += 10;
            progressBar.style.width = progress + '%';
            progressLabel.innerText = `Processando ${progress}%`;
            setTimeout(updateProgress, 100);
        } else {
            progressLabel.innerText = 'Processo concluído!';
            // Remova o redirecionamento aqui
        }
    }

    updateProgress();
</script>

</body>
</html>
