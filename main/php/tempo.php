<?php
//date_default_timezone_set('America/Sao_Paulo'); // Defina o fuso horário para São Paulo
function tempo_corrido($dataPublicacao) {
    $dataAtual = new DateTime();
    $dataPostagem = new DateTime($dataPublicacao);
    $intervalo = $dataPostagem->diff($dataAtual);

    if ($intervalo->y > 0) {
        return $intervalo->y . ' ano' . ($intervalo->y > 1 ? 's' : '');
    } elseif ($intervalo->m > 0) {
        return $intervalo->m . ' mês' . ($intervalo->m > 1 ? 'es' : '');
    } elseif ($intervalo->d > 0) {
        return $intervalo->d . ' dia' . ($intervalo->d > 1 ? 's' : '');
    } elseif ($intervalo->h > 0) {
        return $intervalo->h . ' hora' . ($intervalo->h > 1 ? 's' : '');
    } elseif ($intervalo->i > 0) {
        return $intervalo->i . ' minuto' . ($intervalo->i > 1 ? 's' : '');
    } else {
        return 'Agora Mesmo';
    }
}
?>
