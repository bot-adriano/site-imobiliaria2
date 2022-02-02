<?php
require_once("conexao.inc");
?>
<!doctype html>
<html lang="pt-br">

<head>
    <title>casa dos sonhos</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="estilos.css">
    <script>
        /*script para ampliar as fotos quando clicar nas miniaturas*/
        function clique(img) {
            /*aqui vamos passar a imagem para a funca ooclique*/
            var modalj = document.getElementById("janelaModal");
            /*quando clicar na miniatura tem q apresentar imagem grande*/
            var modali = document.getElementById("imgModal");
            var modalB = document.getElementById("btFechar");

            modalj.style.display = "block";
            /*comeca bloqueando a img*/
            modali.src = img;
            /*pega a variavel img e apresenta*/
            modalB.onclick = function() {
                modalj.style.display = "none";
                /*qdo fechar ele oculta a janela*/
            }

        }
    </script>

</head>

<body>
    <header>
        <?php
        require_once("topo.php");
        ?>
    </header>


    <section id="imoveis">
        <?php

        $id = $_GET['id'];
        $pg = $_GET['pg'];/*pega a variavel pg para retornar na pagina que estavamos vendo*/
        echo "<a href=casa.php?pg=$pg>voltar</a>";

        /*$sql= "SELECT * FROM tb_casa limit 1,3 ";limit deixa limitando no numero de itens a ser exibido quando se usa somente 1 ele mostra a quantidade a ser exibido, mas se coloca 1,3 indica q a partir do indice 1 carrega 3 indices */
        $sql = "SELECT tb_casa.*,tb_imoveis.*,tb_tipo_imovel.* FROM tb_casa INNER JOIN tb_imoveis ON  tb_casa.id_qualimovel = tb_imoveis.id_imovel INNER JOIN tb_tipo_imovel on tb_casa.id_modelocasa = tb_tipo_imovel.id_tipo_imovel WHERE tb_casa.id_casa = $id ";
        $res = mysqli_query($con, $sql);


        $exibe = mysqli_fetch_array($res);

        echo "<article>" .

            "<div id='dvminis'>" .
            "<img src='" . $exibe['mini1'] . "' class='mini' onclick='clique(\"" . $exibe['foto1'] . "\")'> " ./*onclick épra passar a img pra variavel do js*/
            "<img src='" . $exibe['mini2'] . "' class='mini' onclick='clique(\"" . $exibe['foto2'] . "\")'>" .
            "<img src='"  . $exibe['mini3'] . "' class='mini' onclick='clique(\"" . $exibe['foto3'] . "\")'>" .
            "</div>" .

            "<div id='dvdetalhes'>" .
            "<div id='dvc1'>" .
            " id:" . $exibe['id_imovel'] . "<br>" .
            " imovel:" . $exibe['imovel'] . "<br>" .
            " tipo:" . $exibe['tipo'] . "<br>" .
            " rua:" . $exibe['id_rua'] . "<br>" .
            "Venda <span class='preco'>R$" . number_format($exibe['venda'], 2, ',', '.') . "</span> <br>" . /*number_format(valor,casas decimais,sep_dec,sep_mil)*/
            "Aluguel <span class='preco'>R$" . number_format($exibe['aluguel'], 2, ',', '.') . "</span><br>" .
            "iptu:  <span class='preco'>R$" . number_format($exibe['iptu'], 2, ',', '.') . "</span><br>" .
            "condominio: <span class='preco'> R$" . number_format($exibe['condominio'], 2, ',', '.') . "</span><br>" .
            "</div>" .
            "<div id='dvc2'>" .
            "quartos:  " . $exibe['quartos'] . "<br>" .
            "suites:  " . $exibe['suite'] . "<br>" .
            "sala:  " . $exibe['sala'] . "<br>" .
            "vaga:  " . $exibe['vaga'] . "<br>" .
            "banheiro:  " . $exibe['banheiro'] . "<br>" .
            // "foto1: <img src='"  . $exibe['foto1'] . "'><br>" .
            // "foto2: <img src='" . $exibe['foto2'] . "'><br>" .
            // "foto3: <img src='" . $exibe['foto3'] . "'><br>" .

            //"vendido:  " . $exibe['vendido'] . "<br>" .
            // "alugado:  " . $exibe['alugado'] . "<br>" .
            // "bloqueado:  " . $exibe['bloqueado'] . "<hr>" .
            "</div>" .
            "</div>" .

            "</article>";

        ?>

        <div id="janelaModal">
            <span id="btFechar">X</span>
            <img id="imgModal">
        </div>
    </section>
    <footer>
        <!--rodapé-->
        <?php
        require_once("rodape.html");

        ?>
    </footer>
</body>

</html>