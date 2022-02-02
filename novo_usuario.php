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
include "conexao.inc";/*colocamos o include da conexao para conectar com o sql*/
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
        <a href="gerenciamento.php?num=<?php echo $n1; ?>" target="_self" class="btmenu">voltar </a>
        <!--criar link para retornar para o gerenciamento e temos que passar o num com o conteudo da variavel n1 pra conseguir acessar*/-->
        <h1>Novo Usuario</h1>

        <?php /*cria rotina php ela vai verificar se o formulario foi submetido vai receber os dados do get e fazer a totina pra gravar no banco de dados, se n foi ele deixa a rotina <normal></normal> */

        if (isset($_GET["f_bt_novo_colaborador"])) {/*essa rotina só executa se o botao f_bt_novo_colaborador se ja foi executado*/
            $vnome = $_GET["f_nome"];
            $vuser = $_GET["f_user"];
            $vsenha = $_GET["f_senha"];
            $vacesso = $_GET["f_acesso"];

            $sql = "INSERT INTO usuario (nome,username,senha,acesso) VALUES ('$vnome','$vuser','$vsenha', $vacesso)";/*rotina sql, inserir dentro da tabela usuario os valores, colocamos entre apostrofes pq são strings e se for numerico é sem */
            mysqli_query($con, $sql);
            $linhas = mysqli_affected_rows($con);/*verifica se o insert obteve sucesso, armazenando na variavel linhas para ver qto ele esta retornando , se for maior q 0 foi bem sucedido*/
            /* if ($linhas >= 1) {
                echo " <p> Novo colaborador gravado com sucesso </p> ";
            } else {
                "<p> Erro ao gravar novo colaborador </p>";
            }*/
            if ($linhas >= 1) {
                echo "<script>alert('Novo colaborador adicionado com sucesso');</script>";
            } else {
                echo "<script>alert ('Erro ao Adicionar colaborador');</script>";
            }
        }
        ?>


        <form name="f_novo_colaborador" action="novo_usuario.php" class="f_colaborador" method="get">
            <!--para criar novo usuario se usa o form e criamos a class f_colaborador pra o css-->
            <input type="hidden" name="num" value="<?php echo $n1; ?>">
            <!--criamos a  rotina de gravação :temos que passsar o num para validar o log com o valor da variavel $n1-->
            <label>Nome</label>
            <input type="text" name="f_nome" maxlength="40" size="40" required="required">
            <!--required = obrigatorio-->
            <label>username</label>
            <input type="text" name="f_user" maxlength="20" size="20" required="required">
            <label>senha</label>
            <input type="text" name="f_senha" maxlength="20" size="20" required="required">
            <label>acesso</label>
            <input type="text" name="f_acesso" maxlength="11" size="11" required="required" pattern="[0-1]+$" placeholder="0 ou 1" title="0 ou 1">
            <!--patter é para deixar de opcao somente o 0,1 plaaceholder é para indicar as opcoes e o title é pra indicar as opcoes quando passar o mouse em cima-->
            <input type="submit" name="f_bt_novo_colaborador" class="btmenu" value="gravar">
            <!--botao para gravar-->

        </form>

    </section>


</body>

</html>