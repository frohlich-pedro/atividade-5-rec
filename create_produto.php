<?php
session_start();
include_once 'db.php';

$database = new Database();
$db = $database->getConnection();

$categorias_query = "SELECT * FROM categorias";
$categorias_stmt = $db->prepare($categorias_query);
$categorias_stmt->execute();

if ($_POST) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade_estoque = $_POST['quantidade_estoque'];
    $id_categoria = $_POST['id_categoria'];
    
    $query = "INSERT INTO produtos SET nome=:nome, descricao=:descricao, preco=:preco, 
              quantidade_estoque=:quantidade_estoque, id_categoria=:id_categoria, id_usuario=1";
    
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":descricao", $descricao);
    $stmt->bindParam(":preco", $preco);
    $stmt->bindParam(":quantidade_estoque", $quantidade_estoque);
    $stmt->bindParam(":id_categoria", $id_categoria);
    
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
    <title>Novo Produto - Padaria Pãodango</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Novo Produto</h1>
            <nav>
                <a href="index.php">Início</a>
                <a href="produtos.php">Produtos</a>
                <a href="clientes.php">Clientes</a>
            </nav>
        </header>

        <main>
            <form action="create_produto.php" method="post" class="form">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Descrição:</label>
                    <textarea name="descricao" class="form-control"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Preço:</label>
                    <input type="number" name="preco" step="0.01" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Quantidade em Estoque:</label>
                    <input type="number" name="quantidade_estoque" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Categoria:</label>
                    <select name="id_categoria" class="form-control">
                        <option value="">Selecione uma categoria</option>
                        <?php while ($categoria = $categorias_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $categoria['id_categoria']; ?>">
                                <?php echo htmlspecialchars($categoria['nome']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="produtos.php" class="btn btn-cancel">Cancelar</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
