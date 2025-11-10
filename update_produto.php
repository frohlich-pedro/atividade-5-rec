<?php
session_start();
include_once 'db.php';

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : die('ID do produto não especificado.');

$categorias_query = "SELECT * FROM categorias";
$categorias_stmt = $db->prepare($categorias_query);
$categorias_stmt->execute();

$query = "SELECT * FROM produtos WHERE id_produto = ? LIMIT 0,1";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_POST) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade_estoque = $_POST['quantidade_estoque'];
    $id_categoria = $_POST['id_categoria'];
    
    $update_query = "UPDATE produtos SET nome=:nome, descricao=:descricao, preco=:preco, 
                    quantidade_estoque=:quantidade_estoque, id_categoria=:id_categoria 
                    WHERE id_produto=:id";
    
    $stmt = $db->prepare($update_query);
    
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":descricao", $descricao);
    $stmt->bindParam(":preco", $preco);
    $stmt->bindParam(":quantidade_estoque", $quantidade_estoque);
    $stmt->bindParam(":id_categoria", $id_categoria);
    $stmt->bindParam(":id", $id);
    
    if ($stmt->execute()) {
        header("Location: produtos.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - Padaria Pãodango</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Editar Produto</h1>
            <nav>
                <a href="index.php">Início</a>
                <a href="produtos.php">Produtos</a>
                <a href="clientes.php">Clientes</a>
            </nav>
        </header>

        <main>
            <form action="update_produto.php?id=<?php echo $id; ?>" method="post" class="form">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Descrição:</label>
                    <textarea name="descricao" class="form-control"><?php echo htmlspecialchars($row['descricao']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Preço:</label>
                    <input type="number" name="preco" step="0.01" value="<?php echo $row['preco']; ?>" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Quantidade em Estoque:</label>
                    <input type="number" name="quantidade_estoque" value="<?php echo $row['quantidade_estoque']; ?>" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Categoria:</label>
                    <select name="id_categoria" class="form-control">
                        <option value="">Selecione uma categoria</option>
                        <?php 
                        $categorias_stmt->execute();
                        while ($categoria = $categorias_stmt->fetch(PDO::FETCH_ASSOB)): 
                        ?>
                            <option value="<?php echo $categoria['id_categoria']; ?>" 
                                <?php echo ($categoria['id_categoria'] == $row['id_categoria']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria['nome']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="produtos.php" class="btn btn-cancel">Cancelar</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
