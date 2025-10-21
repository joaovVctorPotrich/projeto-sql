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
<link rel="stylesheet" href="style.css"/>
</head>
<body>
<div id="main">
<div id="geral">
<div id="header">
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
        echo '<li><strong>Mesagem:</strong> ' . nl2br(htmlspecialchars($res['mesagem'])) . '</li>';
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

<style>
{
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f5f7fa;
  margin: 0;
  padding: 0;
  color: #333;
}

#main {
  max-width: 800px;
  margin: 30px auto;
  background: #fff;
  padding: 25px 30px;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

#geral {
  width: 100%;
}

#header h1 {
  text-align: center;
  color: #222;
  margin-bottom: 30px;
  font-weight: 700;
}

#formulario_mural {
  background: #fefefe;
  padding: 20px 25px;
  border: 1px solid #ddd;
  border-radius: 6px;
  margin-bottom: 35px;
}

#formulario_mural label {
  display: block;
  font-weight: 600;
  margin-top: 12px;
  color: #444;
}

#formulario_mural input[type="text"],
#formulario_mural textarea {
  width: 100%;
  padding: 10px 12px;
  margin-top: 6px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  font-family: inherit;
  resize: vertical;
  transition: border-color 0.3s ease;
}

#formulario_mural input[type="text"]:focus,
#formulario_mural textarea:focus {
  border-color: #4285f4;
  outline: none;
}

#formulario_mural textarea {
  min-height: 90px;
}

#formulario_mural .btn {
  margin-top: 18px;
  background-color: #4285f4;
  color: white;
  border: none;
  padding: 13px 22px;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

#formulario_mural .bt_
