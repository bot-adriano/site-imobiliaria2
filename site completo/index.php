<!doctype html>
<html lang="pt-br">

<head>
    <title>casa dos sonhos</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="estilos.css">

</head>

<body>
    <header>
        <?php
        require_once("topo.php");
        ?>
    </header>

    <section class="banner">
        <?php
        require_once("slider.html");
        ?>
    </section>

    <section class="buscador">
        <?php
        require_once("buscador.php");
        ?>
    </section>

    <section class="destaques">
        <?php
        require_once("destaques.html");

        ?>
    </section>
    <footer>
        <!--rodapé-->
        <?php
        require_once("rodape.html");

        ?>
    </footer>
</body>

</html>