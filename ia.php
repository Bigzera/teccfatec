<?php
// Ativar relatórios de erros para depuração
error_reporting(E_ALL);
ini_set("display_errors", 1);

$data = json_decode(file_get_contents('php://input'), true);

// Correção do nome da chave
$mensagem = $data['senderMessage'];

function ler_arquivo($nome_arquivo) {
    if (!file_exists($nome_arquivo)) {
        return false;
    }

    $fp = fopen($nome_arquivo, "r");
    $conteudo = fread($fp, filesize($nome_arquivo));
    fclose($fp);

    return $conteudo;
}

$editacodigo = ler_arquivo("editacodigo.txt");
$openai = ler_arquivo("openai.txt");
$prompt = ler_arquivo("prompt.txt");

function chatWithOpenAI($system, $OPENAI_API_KEY, $userMessage) {
    $data = array(
        "model" => "gpt-3.5-turbo",
        "messages" => array(
            array("role" => "system", "content" => $system),
            array("role" => "user", "content" => $userMessage)
        )
    );

    $data_json = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . $OPENAI_API_KEY,
        "Content-Type: application/json"
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return 'Ocorreu um erro ao processar sua solicitação.';
    } else {
        $response_obj = json_decode($response);
        if (isset($response_obj->choices[0]->message->content)) {
            return $response_obj->choices[0]->message->content;
        } else {
            return 'Resposta inesperada da API.';
        }
    }
    curl_close($ch);
}

$system = $prompt;
$OPENAI_API_KEY =  $openai;
$userMessage = $mensagem;

$saida = chatWithOpenAI($system, $OPENAI_API_KEY, $userMessage);

$response = [
    "data" => [
        [
            "message" => $saida // Correção das aspas aqui
        ]
    ]
];

echo json_encode($response);
?>
