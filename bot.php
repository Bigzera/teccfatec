<?php
error_reporting(0);
ini_set("display_errors", 0 );

// Grava chave EditaCódigo
if (!empty($_POST['editacodigo'])) {
    function gravar_editacodigo($texto) {
        $arquivo = "editacodigo.txt";
        $fp = fopen($arquivo, "w");
        fwrite($fp, $texto);
        fclose($fp);
    }
    gravar_editacodigo($_POST['editacodigo']);
}

// Grava chave OpenAI
if (!empty($_POST['openai'])) {
    function gravar_openai($texto) {
        $arquivo = "openai.txt";
        $fp = fopen($arquivo, "w");
        fwrite($fp, $texto);
        fclose($fp);
    }
    gravar_openai($_POST['openai']);
}

// Grava Prompt
if (!empty($_POST['prompt'])) {
    function gravar_prompt($texto) {
        $arquivo = "prompt.txt";
        $fp = fopen($arquivo, "w");
        fwrite($fp, $texto);
        fclose($fp);
    }
    gravar_prompt($_POST['prompt']);
}
?>
