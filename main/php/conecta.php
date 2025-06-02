<?php
try {
	$conn = new PDO('mysql:host=localhost;dbname=u831824737_uniartgroup', 'u831824737_horizonuniart', 'N:a3>5f&');
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'algo deu errado: ' . $e->getmessage();
}
