<?php
require_once ('conecta.php');
try	{
$stmt = $conn->prepare("SELECT COUNT(*) AS total_posts FROM post WHERE id_perfil = :user_id");
$stmt->bindParam(':user_id', $_POST['id'], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result) {
  $total_posts = $result['total_posts'];
  if ($total_posts < 1) {
    echo "Sem Publicações";
  } elseif ($total_posts == 1) {
    echo " $total_posts Publicação feita";
  } else
    echo " $total_posts Publicações feitas";
}
}catch(PDOException $e) {
  echo "error". $e->getMessage();
}
?>

