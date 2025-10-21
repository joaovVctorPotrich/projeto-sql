<?php
include "conexao.php";

// Atualizar recado
if(isset($_POST['atualiza'])){
    $idatualiza = intval($_POST['id']);
    $nome       = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email      = mysqli_real_escape_string($conexao, $_POST['email']);
    $msg        = mysqli_real_escape_string($conexao, $_POST['msg']);

    $sql = "UPDATE recados SET nome='$nome', email='$email', mensagem='$msg' WHERE id=$idatualiza";
    mysqli_query($conexao, $sql) or die("Erro ao atualizar: " . mysqli_error($conexao));
    header("Location: moderar.php");
    exit;
}

// Excluir recado
if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
    $id = intval($_GET['id']);
    mysqli_query($conexao, "DELETE FROM recados WHERE id=$id") or die("Erro ao deletar: " . mysqli_error($conexao));
    header("Location: moderar.php");
    exit;
}

// Editar recado
$editar_id = isset($_GET['acao']) && $_GET['acao'] == 'editar' ? intval($_GET['id']) : 0;
$recado_editar = null;
if($editar_id){
    $res = mysqli_query($conexao, "SELECT * FROM recados WHERE id=$editar_id");
    $recado_editar = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<title>Moderar pedidos</title>
<link rel="stylesheet" href="styles.css"/>
</head>
<body>
<div id="main">
<div id="geral">
<div id="header">
    <h1>Mural de pedidos</h1>
</div>

<div id="formulario_mural">
<form id="mural" method="post">
    <label>Nome:</label>
    <input type="text" name="nome"/><br/>
    <label>Email:</label>
    <input type="text" name="email"/><br/>
    <label>Mensagem:</label>
    <textarea name="msg"></textarea><br/>
    <input type="submit" value="Publicar no Mural" name="cadastra" class="btn"/>
</form>
</div>
    <h1>Mural de pedidos</h1>
</div>

<?php if($recado_editar): ?>
<div id="formulario_mural">
<form method="post">
    <label>Nome:</label>
    <input type="text" name="nome" value="<?php echo htmlspecialchars($recado_editar['nome']); ?>"/><br/>
    <label>Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($recado_editar['email']); ?>"/><br/>
    <label>Mensagem:</label>
    <textarea name="msg"><?php echo htmlspecialchars($recado_editar['mensagem']); ?></textarea><br/>
    <input type="hidden" name="id" value="<?php echo $recado_editar['id']; ?>"/>
    <input type="submit" name="atualiza" value="Modificar Recado" class="btn"/>
</form>
</div>
<?php endif; ?>

<?php
$seleciona = mysqli_query($conexao, "SELECT * FROM recados ORDER BY id DESC");
if(mysqli_num_rows($seleciona) <= 0){
    echo "<p>Nenhum pedido no mural!</p>";
}else{
    while($res = mysqli_fetch_assoc($seleciona)){
        echo '<ul class="recados">';
        echo '<li><strong>ID:</strong> ' . $res['id'] . ' | 
              <a href="moderar.php?acao=excluir&id=' . $res['id'] . '">Remover</a> | 
              <a href="moderar.php?acao=editar&id=' . $res['id'] . '">Modificar</a></li>';
        echo '<li><strong>Nome:</strong> ' . htmlspecialchars($res['nome']) . '</li>';
        echo '<li><strong>Email:</strong> ' . htmlspecialchars($res['email']) . '</li>';
        echo '<li><strong>Mensagem:</strong> ' . nl2br(htmlspecialchars($res['mesagem'])) . '</li>';
        echo '</ul>';
    }
}
?>




<div id="footer">
</div>
</div>
</div>
</body>
</html>

body{
    background-image: linear-gradient(#fffff);

}

<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
  }

  #main {
    max-width: 800px;
    margin: 30px auto;
    background: white;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    padding: 20px 30px;
    border-radius: 8px;
  }

  #header h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
  }

  #formulario_mural {
    margin-bottom: 40px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background-color: #fafafa;
  }

  #formulario_mural label {
    display: block;
    font-weight: bold;
    margin-top: 12px;
    color: #555;
  }

  #formulario_mural input[type="text"],
  #formulario_mural textarea {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    resize: vertical;
  }

  #formulario_mural textarea {
    min-height: 80px;
  }

  #formulario_mural .btn {
    margin-top: 15px;
    background-color: #4285f4;
    color: white;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  #formulario_mural .btn:hover {
    background-color: #3367d6;
  }

  ul.recados {
    list-style-type: none;
    padding: 15px 20px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background-color: #fff;
    box-shadow: 1px 1px 5px rgba(0,0,0,0.05);
  }

  ul.recados li {
    margin-bottom: 8px;
    color: #444;
  }

  ul.recados li:first-child {
    font-weight: bold;
    font-size: 14px;
    color: #222;
  }

  ul.recados li:first-child a {
    margin-left: 12px;
    text-decoration: none;
    color: #e74c3c;
    font-weight: normal;
  }

  ul.recados li:first-child a:hover {
    text-decoration: underline;
  }

  ul.recados li:nth-child(1) a:nth-child(3) {
    color: #3498db;
  }

  ul.recados li:nth-child(1) a:nth-child(3):hover {
    text-decoration: underline;
  }

  #footer {
    text-align: center;
    font-size: 12px;
    color: #aaa;
    margin-top: 40px;
  }
</style>
