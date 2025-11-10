<?php
session_start();
include_once 'db.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT p.*, c.nome as categoria_nome 
          FROM produtos p 
          LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
          ORDER BY p.id_produto DESC";
$stmt = $db->prepare($query);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Padaria Pãodango</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Gerenciar Produtos</h1>
            <nav>
                <a href="index.php">Início</a>
                <a href="produtos.php">Produtos</a>
                <a href="clientes.php">Clientes</a>
            </nav>
        </header>

        <main>
            <div class="actions">
                <a href="create_produto.php" class="btn btn-primary">Novo Produto</a>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['id_produto']; ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo $row['quantidade_estoque']; ?></td>
                            <td><?php echo $row['categoria_nome'] ?: 'Sem categoria'; ?></td>
                            <td class="actions">
                                <a href="update_produto.php?id=<?php echo $row['id_produto']; ?>" class="btn btn-edit">Editar</a>
                                <a href="delete_produto.php?id=<?php echo $row['id_produto']; ?>" class="btn btn-delete" onclick="return confirm('Tem certeza?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
