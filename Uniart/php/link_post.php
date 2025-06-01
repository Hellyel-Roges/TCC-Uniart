<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // A solicitação foi feita usando o método POST
    $id = $_POST['id'];
    echo '<a href="https://uniart.site/Uniart/perfil2.php?vizu_perfil='.$id.'" id="visitar" class="button" style="margin-top:0.5em;">Visitar Perfil</a>';
} else {
    // A solicitação não foi feita com o método POST
    echo "A solicitação não foi feita com o método POST.";
}
?>