<?php

session_start();

// Remove todas as informações da sessão
session_unset();

// Destrói a sessão
session_destroy();

// Volta para a página de login
header("Location: login.php");
exit;

?>
