<?php
include "conexao.inc";
?>
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
        include "topo.php";
        ?>
    </header>


    <section id="main">
        <?php
      /*  $sql= "SELECT * FROM tb_casa";
        $res=mysqli_query($con,$sql);*/
    /*aqui vamos controlar o controle de paginação*/
        $pagina_atual=1;


        $maximo_registros_exibidos=5;/*limita em 5 o limite a ser exibido*/
        $inicio=0;
        /*$sql= "SELECT * FROM tb_casa limit 1,3 ";limit deixa limitando no numero de itens a ser exibido quando se usa somente 1 ele mostra a quantidade a ser exibido, mas se coloca 1,3 indica q a partir do indice 1 carrega 3 indices */
        $sql= "SELECT * FROM tb_casa LIMIT $inicio, $maximo_registros_exibidos";
        $res=mysqli_query($con,$sql);
        $total_registros=mysqli_num_rows(mysqli_query($con,"SELECT * FROM tb_casa));/*vai guardar e registrar os registros */
        $total_paginas=$total_registros/$maximo_registros_exibidos;/*aqui calcula o numero de paginas*/

        /*variaveis pra controlar paginas (anterior e proxima)*/
        $anterior = $pagina_atual -1;
        $proxima = $pagina_atual +1;


        
        while($exibe=mysqli_fetch_array($res)){
            echo "id_casa:  ".$exibe['id_casa']."<br>".
            "tipo de imovel:  ".$exibe['id_qualimovel']."<br>".
             "modelo do imovel:  ".$exibe['id_modelocasa']."<br>".
             "bairro:  ".$exibe['id_bairro']."<br>".
             "cidade:  ".$exibe['id_cidade']."<br>".
             "cep:  ".$exibe['id_cep']."<br>".
             "rua:  ".$exibe['id_rua']."<br>".
             "texto internet:  ".$exibe['obs']."<br>".
             "venda:  R$" .number_format ($exibe['venda'],2,',','.')."<br>"./*number_format(valor,casas decimais,sep_dec,sep_mil)*/
             "aluguel:  R$" .number_format ($exibe['aluguel'],2,',','.')."<br>".
             "iptu:  R$" .number_format ($exibe['iptu'],2,',','.')."<br>".
             "condominio:  R$" .number_format ($exibe['condominio'],2,',','.')."<br>".
             "quartos:  ".$exibe['quartos']."<br>".
             "suites:  ".$exibe['suite']."<br>".
             "sala:  ".$exibe['sala']."<br>".
             "vaga:  ".$exibe['vaga']."<br>".
             "banheiro:  ".$exibe['banheiro']."<br>".
             "foto1: <img src='"  .$exibe['foto1']."'><br>".
             "foto2: <img src='" .$exibe['foto2']."'><br>".
             "foto3: <img src='" .$exibe['foto3']."'><br>".
             "mini1: <img src='" .$exibe['mini1']."'><br>".
             "mini2: <img src='" .$exibe['mini2']."'><br>".
             "mini3: <img src='"  .$exibe['mini3']."'><br>".
             "vendido:  ".$exibe['vendido']."<br>".
             "alugado:  ".$exibe['alugado']."<br>".
             "bloqueado:  ".$exibe['bloqueado']."<hr>";
            
        }

        ?>
    </section>
    <footer>
        <!--rodapé-->
        <?php
        include "rodape.html";

        ?>
    </footer>
</body>

</html>