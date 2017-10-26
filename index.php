<?php
ini_set('memory_limit', '-1');
include('simple_html_dom.php');
include('SaveText.php');
include('noticia.php');
$pagina = 0;
Noticia::Run($pagina);
