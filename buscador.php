<?php
//require_once("conexao.inc");
include "conexao.inc";
?>
<p class="titulo">Pesquisa</p>
<section id="imoveis">
    <?php


    /*cria rotina php ela vai verificar se o formulario foi submetido vai receber os dados do get e fazer a totina pra gravar no banco de dados, se n foi ele deixa a rotina <normal></normal> */
    if (isset($_POST["f_bt_buscar"])) {
        $vcidade = $_POST["f_city"];
        $sql = "SELECT * FROM tb_casa WHERE id_cidade LIKE '%$vcidade%' or  id_bairro like'%$vcidade%' or id_rua like '%$vcidade%'";
        $res = mysqli_query($con, $sql);
        /*  $lin = mysqli_num_rows($res);
    echo "$lin registros encontrados";*/
        while ($exibe = mysqli_fetch_array($res)) {/*mysqli_fetch array para retornar em forma de array o total de colaboradores e while para para escrever um option enquanto estiver retornando linhas pelo fetch_array*/
            echo "<option value='" . $exibe['id_casa'] . "'>" . $exibe['id_rua'] . "</option>";/*na variavel exibe podemos colocar o indice 0 tb (que é o numero dele dentro do sql) e escreve o nome no lugar do id*/


            /*aqui vamos controlar o controle de paginação*/



            $maximo_registros_exibidos = 3;/*limita em 5 o limite a ser exibido*/
            if (isset($_GET["pg"])) {/*verifica se o parametro pg existe*/
                $pagina_atual = $_GET["pg"];/*se existir ele carrega a pagina atual com o pg*/
            } else {
                $pagina_atual = 1;/*se nao carrega somente a primeira pagina*/
            }

            $inicio = $pagina_atual - 1;/*pagina atual fica definido como pagina atual -1 pq o indice comeca em 0*/
            $inicio *= $maximo_registros_exibidos;/*pra carregar apos o ultimo registro visualizado, sem isso ele vai carregar o indice 1, porém o indice 1 ja foi mostrado ja que aparece ate o 4*/

            /*$sql= "SELECT * FROM tb_casa limit 1,3 ";limit deixa limitando no numero de itens a ser exibido quando se usa somente 1 ele mostra a quantidade a ser exibido, mas se coloca 1,3 indica q a partir do indice 1 carrega 3 indices */
            $sql = "SELECT tb_casa.*,tb_imoveis.*,tb_tipo_imovel.* FROM tb_casa INNER JOIN tb_imoveis ON  tb_casa.id_qualimovel = tb_imoveis.id_imovel INNER JOIN tb_tipo_imovel on tb_casa.id_modelocasa = tb_tipo_imovel.id_tipo_imovel  WHERE id_cidade LIKE '%$vcidade%' or  id_bairro like'%$vcidade%' or id_rua like '%$vcidade%' limit $inicio,$maximo_registros_exibidos";
            $res = mysqli_query($con, $sql);
            $total_registros = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_casa"));/*vai guardar e registrar os registros */
            $total_paginas = $total_registros / $maximo_registros_exibidos;/*aqui calcula o numero de paginas*/

            /*variaveis pra controlar paginas (anterior e proxima)*/
            $anterior = $pagina_atual - 1;
            $proxima = $pagina_atual + 1;

            if ($pagina_atual > 1) {
                echo "<a class='btmenu' href='casa.php?pg=$anterior'>Anterior</a>";
            }
            if ($pagina_atual < $total_paginas) {
                echo "<a class='btmenu' href='casa.php?pg=$proxima'>Proxima</a>";
            }
            echo "<br>";
            for ($ip = 0; $ip < $total_paginas; $ip++) { /*para aparecer o numeros de paginas criamos a variavel ip e usamos o for*/
                echo "<a href='casa.php?pg=" . ($ip + 1) . "'>[";
                if ($pagina_atual == ($ip + 1)) {/*esse if é para deixar em negrito a pagina selecionada*/
                    echo "<strong>" . ($ip + 1) . "</strong>";
                } else {
                    echo ($ip + 1);
                }
                echo "]</a>";
            }
            echo "<br><br>";

            while ($exibe = mysqli_fetch_array($res)) {

                echo "<article>" .
                    "<div id='d1'>" . //"id_casa:  " . $exibe['id_casa'] . "<br>" .
                    " <a href='detalhes_imoveis.php?id=" . $exibe['id_casa'] . "&pg=$pagina_atual'><img src='" . $exibe['mini1'] . "'> </a>" .
                    /*o &pg=$pagina_atual é para quando voltarmos a pesquisa não retornar a primeira pagina de novo*/
                    " <img src='" . $exibe['mini2'] . "'>" .
                    "<img src='"  . $exibe['mini3'] . "'>" .
                    "</div>" .
                    "<div id='d2'>" .
                    "<div id=titulo>" .
                    "<div id='t1'>" .
                    " <a href='detalhes_imoveis.php?id=" . $exibe['id_casa'] . "&pg=$pagina_atual'>" .
                    $exibe['imovel'] . "&nbsp;" . $exibe['tipo'] . "&nbsp;" . $exibe['id_rua'] .
                    "</a>" .
                    /*"<p> " . $exibe['imovel'] . "&nbsp;</p>" .vamos trocar imovel, tipo e rua e tranformar em link
                "<p>" . $exibe['tipo'] . "&nbsp;</p>" .
                // "bairro:  " . $exibe['id_bairro'] . "<br>" .
                // "cidade:  " . $exibe['id_cidade'] . "<br>" .
                // "cep:  " . $exibe['id_cep'] . "<br>" .
                "<p>  " . $exibe['id_rua'] . "&nbsp;</p>" .*/
                    "</div>" .
                    "<div id='t2'>" .
                    //"texto internet:  " . $exibe['obs'] . "<br>" .
                    "<p> Venda R$: " . number_format($exibe['venda'], 2, ',', '.') . "</p>" ./*number_format(valor,casas decimais,sep_dec,sep_mil)*/
                    "<p> Locação R$: " . number_format($exibe['aluguel'], 2, ',', '.') . "</p>" .
                    //  "iptu:  R$" . number_format($exibe['iptu'], 2, ',', '.') . "<br>" .
                    // "condominio:  R$" . number_format($exibe['condominio'], 2, ',', '.') . "<br>" .
                    "</div>" .
                    "</div>" .
                    "<div id='dados'>" .
                    "Quartos:  " . $exibe['quartos'] . "<br>" .
                    "Suites:  " . $exibe['suite'] . "<br>" .
                    "Sala:  " . $exibe['sala'] . "<br>" .
                    "Vaga:  " . $exibe['vaga'] . "<br>" .
                    "Banheiro:  " . $exibe['banheiro'] . "<br>" .
                    // "foto1: <img src='"  . $exibe['foto1'] . "'><br>" .
                    // "foto2: <img src='" . $exibe['foto2'] . "'><br>" .
                    // "foto3: <img src='" . $exibe['foto3'] . "'><br>" .

                    //"vendido:  " . $exibe['vendido'] . "<br>" .
                    // "alugado:  " . $exibe['alugado'] . "<br>" .
                    // "bloqueado:  " . $exibe['bloqueado'] . "<hr>" .
                    "</div>" .
                    "</div>" .
                    "</article>";
            }
        }


        mysqli_close($con);
    }
    ?>
</section>


<body>
    <form name="fbuscador" id="fbuscador" method="POST" action="buscador.php">
        <label>Digite: cidade, bairro ou rua</label>
        <input type="text" name="f_city" /> </br></br>
        <input type="submit" name="f_bt_buscar" class="btmenu" value="buscar" />
    </form>
</body>

<p class="titulo">aluguel</p><br>
<form name="fbuscador" id="fbuscador" action="consulta.php" method="post">
    <div class="divbusca">
        <!--colocamos tudo dentro de uma div pra facilitar a formatação -->
        <label>selecione a região</label>
        <!--/*ele vai oreencher automaticamente com os dados do bd*/-->
        <select name="regiao" id="id_regiao">

            <option value=""></option>
        </select>
    </div>
    <div class="divbusca">
        <!--colocamos tudo dentro de uma div pra facilitar a formatação -->
        <label>selecione o bairro</label>
        <!--/*ele vai oreencher automaticamente com os dados do bd*/-->
        <select name="bairro" id="id_bairro">

            <option value=""></option>
        </select>
    </div>
    <div id="divbusca">
        <input type="submit" value="buscar" name="f_submit" class="btmenu">
        <!--aqui vamos manter a formatação do btmenu-->
    </div>
</form>

<p class="titulo">compra</p><br>
<form name="fbuscador" id="fbuscador" action="#" method="post">
    <div class="divbusca">
        <!--colocamos tudo dentro de uma div pra facilitar a formatação -->
        <label>selecione a região</label>
        <!--/*ele vai oreencher automaticamente com os dados do bd*/-->
        <select name="regiao" id="id_regiao">

            <option value=""></option>
        </select>
    </div>
    <div class="divbusca">
        <!--colocamos tudo dentro de uma div pra facilitar a formatação -->
        <label>selecione o bairro</label>
        <!--/*ele vai oreencher automaticamente com os dados do bd*/-->
        <select name="bairro" id="id_bairro">

            <option value=""></option>
        </select>
    </div>
    <div id="divbusca">
        <input type="submit" value="buscar" name="f_submit" class="btmenu">
        <!--aqui vamos manter a formatação do btmenu-->
    </div>
</form>