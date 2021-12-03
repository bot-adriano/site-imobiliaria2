<?php
session_start();
if (isset($_SESSION["numlogin"])) {/*verificar se session possui o compo "numlogin"estiver definido na sessão armazenar na variavel n1 o numero que esta sendo passado*/
    $n1 = $_GET["num"];
    $n2 = $_SESSION["numlogin"];/*armazena o num log que esta na sessaão e verificaar se os valores são iguais para entrar no site*/

    if ($n1 != $n2) {/*se n1 for diferente de n2 ele vai barrar e fechar a execução */
        echo "<p>Login não efetuado</p>";
        exit;
    }
} else {/*para nao entrar na pagina por digitação direta bloqueamos aqui*/
    echo "<p>Login não efetuado</p>";
    exit;
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <title>casa dos sonhos</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="estilos.css">
    <script src="jquery-3.6.0.min.js"></script>
    <!--adiciona a bibliotecajquery-->
    <script>
        $(document).ready(function() {
            /*quando a pagina estiver toda carregada vai carregar o script*/
            $("#menub1", "#menub2", "#menub4", "#menub3").css("visibility", "hidden"); /*para esconder os menus*/
            $("#menua1").click(function() {
                $("#menub1").css("visibility", "visible");
                $("#menub2").css("visibility", "hidden");
                $("#menub3").css("visibility", "hidden");
                $("#menub4").css("visibility", "hidden");
            });
            $("#menua2").click(function() {
                $("#menub2").css("visibility", "visible");
                $("#menub1").css("visibility", "hidden");
                $("#menub3").css("visibility", "hidden");
                $("#menub4").css("visibility", "hidden");
            });
            $("#menua3").click(function() {
                $("#menub3").css("visibility", "visible");
                $("#menub2").css("visibility", "hidden");
                $("#menub1").css("visibility", "hidden");
                $("#menub4").css("visibility", "hidden");
            });
            $("#menua4").click(function() {
                $("#menub4").css("visibility", "visible");
                $("#menub2").css("visibility", "hidden");
                $("#menub3").css("visibility", "hidden");
                $("#menub1").css("visibility", "hidden");
            });
            $("#menub1,#menub2,#menub4,#menub3").mouseover(function() {
                /*para quando o mouse estiver em cima aparecer e quando n estuver desaparecer*/
                $(this).css("visibility", "visible");
            });
            $("#menub1,#menub2,#menub4,#menub3").mouseout(function() {
                $(this).css("visibility", "hidden");
            });
        });
    </script>

</head>

<body>
    <header>
        <?php
        include "topo.php";
        ?>
    </header>


    <section>
        <p>Menu Principal de Gerenciamento</p>
    </section>

    <nav">
        <div class="menu_ger">
            <button id="menua1" class="btmenu">locação</button>
            <div id="menub1" class="menub">
                <a href="#" target="_self">novo</a>
                <a href="#" target="_self">editar</a>
                <a href="#" target="_self">excluir</a>
                <a href="#" target="_self">bairro</a>
            </div>
        </div>
        <div class="menu_ger">
            <button id="menua2" class="btmenu">slider</button>
            <div id="menub2" class="menub">
                <a href="#" target="_self">configurar</a>

            </div>
        </div>


        <div class="menu_ger">
            <button id="menua3" class="btmenu">venda</button>
            <div id="menub3" class="menub">
                <a href="#" target="_self">novo</a>
                <a href="#" target="_self">editar</a>
                <a href="#" target="_self">excluir</a>
                <a href="#" target="_self">bairro</a>
            </div>

        </div>
        <!-- /*vamos carregar a rotina de baixo somente se o acesso for = 1*/
             /*colocamos o novo_ususarioo.php e colocamos para ele verificar a variavel num com  o conteudo da variavel n1-->

        <?php
        if ($_SESSION['acesso'] == 1) {

            echo "
                        <div class='menu_ger'>
                            <button id='menua4' class='btmenu'>usuarios</button>
                            <div id='menub4' class='menub'>
                                <a href='novo_usuario.php?num=$n1' target='_self'>novo</a>
                                <a href='editar_usuario.php?num=$n1' target='_self'>editar</a>
                                <a href='excluir_usuario.php?num=$n1' target='_self'>excluir</a>
                            </div>
                        </div> 
                        ";
        }
        ?>
        <div class="menu_ger">
            <button id="menua5" class="btmenu"> logoff</button>
            <div id="menub5" class="menub">
                <a href="#" target="_self">sair</a>

            </div>
        </div>
        </nav>

</body>

</html>