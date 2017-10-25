<?php
function gravar($texto){
    //Variável arquivo armazena o nome e extensão do arquivo.
    $arquivo = "meu_arquivo.txt";

    //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
    $fp = fopen($arquivo, "a+");

    //Escreve no arquivo aberto.
    fwrite($fp, $texto);

    //Fecha o arquivo.
    fclose($fp);
}
