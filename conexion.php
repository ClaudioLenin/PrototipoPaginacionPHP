<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=paginacion', 'root', '');
    echo 'conectado';
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
