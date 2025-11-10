<?php
session_start();
include_once 'db.php';

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : die('ID do produto não especificado.');

$query = "DELETE FROM produtos WHERE id_produto = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $id);

if ($stmt->execute()) {
    header("Location: produtos.php");
    exit();
} else {
    echo "Erro ao excluir produto.";
}
?>
