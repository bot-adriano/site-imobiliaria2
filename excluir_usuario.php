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
        <h1>Excluir Usuario</h1>

        <?php /*cria rotina php ela vai verificar se o formulario foi submetido vai receber os dados do get e fazer a totina pra gravar no banco de dados, se n foi ele deixa a rotina <normal></normal> */

        if (isset($_GET["f_bt_excluir_colaborador"])) {
            $vid = $_GET["f_colaboradores"];/*aqui o id do colaborador que quero excluir*/
            $sql = "DELETE FROM usuario WHERE ID_COLABORADOR=$vid";/*colocamos o coamndo delete da tabela colaboradores quando quando o id colaborador for igual ao valor da variavel id*/
            mysqli_query($con, $sql);/*executa o mysql com a query com a conexao e o codigo sql que esta no codigo sql*/
            $linhas = mysqli_affected_rows($con);/*verifica se o codigo obteve sucesso , verificando quantas linhas foram afetadas*/
            if ($linhas >= 1) {/*verificamos se obteve sucesso com if */
                echo "<p> Colaborador deletado com sucesso </p> ";
            } else {
                echo "<p> Erro ao deletar colaborador</p>";
            }
        }
        ?>


        <form name="f_excluir_colaborador" action="excluir_usuario.php" class="f_colaborador" method="get">
            <!--para criar novo usuario se usa o form e criamos a class f_colaborador pra o css-->
            <input type="hidden" name="num" value="<?php echo $n1; ?>">
            <!--criamos a  rotina de gravação :temos que passsar o num para validar o log com o valor da variavel $n1-->
            <label>Selecione o colaborador</label>
            <select name="f_colaboradores" size="10">
                <!--pra n ao aparecer em formato de listagem usaremos o size 10-->

                <?php
                /*abaixo foi criado o codigo sql na primeira linha, na segunda linha foi executado,na terceira obteve o retorno em forma de vetor e guardar cada retorno no "exibe" e cria cada option a cada ciclo do while*/
                $sql = "SELECT * FROM usuario";/*rotina php com comando sql pra mostrar todos os colaboradoes da tabela usuario*/
                $col = mysqli_query($con, $sql);/*armazena com a query o resultado na variavel col passando a conexao e o comando sql*/
                //$total_col=mysqli_num_rows($col);/*colocamos o total de coladboradores aqui*/ 
                while ($exibe = mysqli_fetch_array($col)) {/*mysqli_fetch array para retornar em forma de array o total de colaboradores e while para para escrever um option enquanto estiver retornando linhas pelo fetch_array*/
                    echo "<option value='" . $exibe['ID_COLABORADOR'] . "'>" . $exibe['NOME'] . "</option>";/*na variavel exibe podemos colocar o indice 0 tb (que é o numero dele dentro do sql) e escreve o nome no lugar do id*/
                }
                ?>
            </select>

            <input type="submit" name="f_bt_excluir_colaborador" class="btmenu" value="excluir">
            <!--botao para gravar-->

        </form>

    </section>


</body>

</html>