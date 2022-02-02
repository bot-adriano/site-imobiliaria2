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
    <script>/*funcao para exibir e esconder menu de adicionar e deletar*/
        function add() {
            document.getElementById("f_add").style.display="block";
            document.getElementById("f_del").style.display="none";
        }
        function del() {
            document.getElementById("f_del").style.display="block";
            document.getElementById("f_add").style.display="none";
        }
    </script>

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
        <h1>imoveis_tipo</h1>

        <button class="btmenu" onclick="add()">adicionar</button>
        <button class="btmenu" onclick="del()">  deletar</button>

        <?php
        if (isset($_GET["codigo"])) {
            $vcod = $_GET["codigo"];
            if ($vcod == 1) {
                //nova marca
                $vimovel = $_GET["f_imovel"];
                $sql = "INSERT INTO tb_imoveis (imovel) VALUES ('$vimovel')";
                mysqli_query($con, $sql);
                $linhas = mysqli_affected_rows($con);
                if ($linhas >= 1) {
                    echo "<script>alert('Novo Imóvel adicionado com sucesso');</script>";
                } else {
                    echo "<script>alert ('Erro ao Adicionar Imóvel');</script>";
                }
            } else if ($vcod == 2) {
                //novo tipo
                $vtipo = $_GET["f_tipo"];
                $vidimoveis = $_GET["f_imoveis"];

                $sql = "INSERT INTO tb_tipo_imovel (tipo,id_tipo_imovel) VALUES ('$vtipo',$vidimoveis)";
                mysqli_query($con, $sql);
                $linhas = mysqli_affected_rows($con);
                if ($linhas >= 1) {
                    echo "<script>alert('Novo tipo adicionado com sucesso');</script>";
                } else {
                    echo "<script>alert ('Erro ao Adicionar novo tipo');</script>";
                }
            } else if ($vcod == 3) {
                ////deleta imovel
                $vidimovel = $_GET["f_del_imoveis"];
                $sql = "DELETE FROM tb_imoveis WHERE id_imovel = $vidimovel";
                mysqli_query($con, $sql);
                $linhas = mysqli_affected_rows($con);
                if ($linhas >= 1) {
                    echo "<script>alert(' Imóvel deletado com sucesso');</script>";
                } else {
                    echo "<script>alert ('Erro ao deletar Imóvel');</script>";
                }
            } else if ($vcod == 4) {
                //deleta tipo
                $vidtipo = $_GET["f_del_tipos"];
                $sql = "DELETE FROM tb_tipo_imovel WHERE id_tipo_imovel = $vidtipo";
                mysqli_query($con, $sql);
                $linhas = mysqli_affected_rows($con);
                if ($linhas >= 1) {
                    echo "<script>alert(' tipo deletado com sucesso');</script>";
                } else {
                    echo "<script>alert ('Erro ao deletar tipo');</script>";
                }
            }
        }
        ?>


        <!--criar formulario para adicionar e remover imoveis e tipode imoveis-->
        <div id="f_add" class="f_add_del">
            <form name="f_novo_imovel" action="imoveis_tipo.php" method="get" class=""><!--marca-->
                <input type="hidden" name="num" value="<?php echo $n1; ?>">
                <input type="hidden" name="codigo" value="1">
                <label>Novo Imovel</label>
                <input type="text" name="f_imovel" maxlength="50" size="50" required="required">
                <input type="submit" value="gravar imovel" class="btmenu" name="f_bt_novo_imovel">
            </form>

            <form name="f_novo_tipo" action="imoveis_tipo.php" method="get" class="">
                <input type="hidden" name="num" value="<?php echo $n1; ?>">
                <input type="hidden" name="codigo" value="2">
                <label>selecione um imóvel</label>
                <select name="f_imoveis" size="10" required="required">
                    <?php
                    
                
                /*abaixo foi criado o codigo sql na primeira linha, na segunda linha foi executado,na terceira obteve o retorno em forma de vetor e guardar cada retorno no "exibe" e cria cada option a cada ciclo do while*/
                $sql = "SELECT * FROM tb_imoveis";/*rotina php com comando sql pra mostrar todos os colaboradoes da tabela usuario*/
                $col = mysqli_query($con, $sql);/*armazena com a query o resultado na variavel col passando a conexao e o comando sql*/
                //$total_col=mysqli_num_rows($col);/*colocamos o total de coladboradores aqui*/ 
                while ($exibe = mysqli_fetch_array($col)) {/*mysqli_fetch array para retornar em forma de array o total de colaboradores e while para para escrever um option enquanto estiver retornando linhas pelo fetch_array*/
                    echo "<option value='" . $exibe['id_imovel'] . "'>" . $exibe['imovel'] . "</option>";/*na variavel exibe podemos colocar o indice 0 tb (que é o numero dele dentro do sql) e escreve o nome no lugar do id*/
                }
               
                    /*
                    $slq = "SELECT * FROM tb_tipo_imovel ";


                    $col = mysqli_query($con, $sql);
                    // $total_col=mysqli_num_rows($col);
                    while ($exibe = mysqli_fetch_array($col)) {
                        echo "<option value='" . $exibe['id_tipo_imovel'] . "'>" . $exibe['tipo'] . "</option>";
                    }*/
                    ?>
                </select>

                <label>tipo de imóvel</label>
                <input type="text" name="f_tipo" maxlength="50" size="50" required="required">
                <input type="submit" value="gravar tipo" class="btmenu" name="f_bt_novo_tipo">
            </form>

        </div>

        <div id="f_del" class="f_add_del" >
            <form name="f_del_tipo" action="imoveis_tipo.php" method="get" class="">
                <input type="hidden" name="num" value="<?php echo $n1; ?>">
                <input type="hidden" name="codigo" value="4">
                <label>selecione um imóvel</label>
                <select name="f_del_tipos" size="10" required="required">
                    <?php
                             $sql = "SELECT * FROM tb_tipo_imovel";/*rotina php com comando sql pra mostrar todos os colaboradoes da tabela usuario*/
                             $col = mysqli_query($con, $sql);/*armazena com a query o resultado na variavel col passando a conexao e o comando sql*/
                             //$total_col=mysqli_num_rows($col);/*colocamos o total de coladboradores aqui*/ 
                             while ($exibe = mysqli_fetch_array($col)) {/*mysqli_fetch array para retornar em forma de array o total de colaboradores e while para para escrever um option enquanto estiver retornando linhas pelo fetch_array*/
                                 echo "<option value='" . $exibe['id_tipo_imovel'] . "'>" . $exibe['tipo'] . "</option>";/*na variavel exibe podemos colocar o indice 0 tb (que é o numero dele dentro do sql) e escreve o nome no lugar do id*/
                             }
                  //  $slq = "SELECT * FROM tb_tipo_imoveis ";
                   // $col =  mysqli_query($sql);
                  // $col = mysqli_query($con, $sql);
                    //$total_col=mysqli_num_rows($col);
                   
                   // echo "<option value='id_tipo_imovel'>" . $exibe[tipo] . "</options>";
                   
                 /*   while ($exibe = mysqli_fetch_array($col)) {
                        echo// "<option value='id_tipo_imovel'>" . $exibe[tipo] . "</options>";

                       "<option value='" . $exibe['id_tipo_imovel'] . "'>" . $exibe['tipo'] . "</option>";
                    }*/
                    ?>
                </select>
                <input type="submit" value="deletar tipo" class="btmenu" name="f_bt_del_tipo">
            </form>

            <form name="f_del_imovel" action="imoveis_tipo.php" method="get" class="">
                <input type="hidden" name="num" value="<?php echo $n1; ?>">
                <input type="hidden" name="codigo" value="3">
                <label>selecione um tipo</label>
                <select name="f_del_imoveis" size="10" required="required">
                    <?php
                    $sql = "SELECT * FROM tb_imoveis ";
                    $col = mysqli_query($con, $sql);
                    // $total_col=mysqli_num_rows($col);
                    while ($exibe = mysqli_fetch_array($col)) {
                        echo "<option value='" . $exibe['id_imovel'] . "'>" . $exibe['imovel'] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="deletar imovel" class="btmenu" name="f_bt_del_imovel">
            </form>



        </div>






    </section>
    <?php
        if(isset($_GET["codigo"])){/*aqui colocamos para que quando a pagina atualizar, verificar qual das abas estao ativas e manter depois tb*/
            if(($vcod==1)or ($vcod==2)){
                echo "<script> document.getElementById('f_add').style.display='block';</script>";
            }else if(($vcod==3)or ($vcod==4)){
                echo "<script> document.getElementById('f_del').style.display='block';</script>";
            }
        }

    ?>


</body>

</html>