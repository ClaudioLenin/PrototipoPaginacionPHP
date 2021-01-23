<?php
include_once 'conexion.php';
//llamar a todos los articulos
$sql = 'SELECT * FROM articulos';
$sentencia = $pdo->prepare($sql);
$sentencia->execute();

$resultado = $sentencia->fetchAll(); //Datos de la bd
//var_dump($resultado); //Comprueba los datos

//ARTICULOS POR PAGINA
$articulos_x_pagina = 3;

//CONTAR LOS ARTICULOS DE LA BD
$total_articulos_db = $sentencia->rowCount();
$paginas = $total_articulos_db / $articulos_x_pagina;
$paginas = ceil($paginas);
?>
<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container my-5">
        <h1>Paginación</h1>

        <?php
        if (!$_GET || $_GET['pagina'] > $paginas || $_GET['pagina'] <= 0) {
            header('Location:index.php?pagina=1');
        }
        // if ($_GET['pagina']>$articulos_x_pagina) {
        //     header('Location:index.php?pagina=1');
        // }

        $iniciar = ($_GET['pagina'] - 1) * $articulos_x_pagina;

        $sql_articulos = 'SELECT * FROM articulos LIMIT :iniciar,:narticulos';
        $sentencia_articulos = $pdo->prepare($sql_articulos);
        $sentencia_articulos->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
        $sentencia_articulos->bindParam(':narticulos', $articulos_x_pagina, PDO::PARAM_INT);
        $sentencia_articulos->execute();

        $resultado_articulos = $sentencia_articulos->fetchAll();
        ?>

        <?php foreach ($resultado_articulos as $articulo) : ?>
            <div class="alert alert-primary" role='alert'>
                <?php echo $articulo['titulo'] ?>
            </div>
        <?php endforeach ?>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="index.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>

                <?php for ($i = 0; $i < $paginas; $i++) : ?>
                    <li class="page-item <?php echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>"><a class="page-link" href="index.php?pagina=<?php echo $i + 1 ?>"><?php echo $i + 1 ?></a></li>
                <?php endfor ?>

                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="index.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
            </ul>
        </nav>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

</body>

</html>