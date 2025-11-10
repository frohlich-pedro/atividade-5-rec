<?php
session_start();
include_once 'db.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM clientes ORDER BY id_cliente DESC";
$stmt = $db->prepare($query);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Padaria Pãodango</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Gerenciar Clientes</h1>
            <nav>
                <a href="index.php">Início</a>
                <a href="produtos.php">Produtos</a>
                <a href="clientes.php">Clientes</a>
            </nav>
        </header>

        <main>
            <div class="actions">
                <a href="create_cliente.php" class="btn btn-primary">Novo Cliente</a>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['id_cliente']; ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['telefone']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data_cadastro'])); ?></td>
                            <td class="actions">
                                <a href="update_cliente.php?id=<?php echo $row['id_cliente']; ?>" class="btn btn-edit">Editar</a>
                                <a href="delete_cliente.php?id=<?php echo $row['id_cliente']; ?>" class="btn btn-delete" onclick="return confirm('Tem certeza?')">Excluir</a>
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
