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

        include "conexao.inc";/*aqui chamamos a conexao com o banco de dados criada , podemos chamar toda vez que precisarmos usar o banco de dados*/


        if (isset($_POST["f_logar"])) {/*aqui verifica se foi clicado*/
            $user = $_POST["f_user"];/*aqui ele ira armazenar o usuario e asenha*/
            $senha = $_POST["f_senha"];

            //mysql
            $sql = "SELECT * FROM usuario WHERE username='$user' AND senha='$senha'";/*aqiui verifica se o usuario esenha é igual o que esta na tabela "usuario"*/
            $res = mysqli_query($con, $sql);/*comando que executa o comando sql e guarda o resultado, estamos passando a string conexao na variavel $con e o comando sql que vai ser executado que esta armazenado na variavel$sql*/
            $ret = mysqli_fetch_array($res);/*a variavel ret vai verificar quantas linhas foram retornadas por esta conexao sql*/

            /*aqui ele verifica a senha*/
            if (($ret == 0)) {/*ele verifica se a variavel ret é igual a 0 significa que ele nao encontrou o usuario ou senha*/
                echo "<p id='lgErro'> Login incorreto</p>";
            } else {/*se a senha for correta ele cria a chave a armazena na SESSION*/
                $chave1 = "abcdefghijklmnopqrstuvxz";
                $chave2 = "ABCDEFGHIJKLMNOPQRSTUVXYZ";
                $chave3 = "123456789";
                $chave = str_shuffle($chave1 . $chave2 . $chave3);/*aqui juntmos as 3 chaves e vamos chamar a funcao surfle para embaralhar a chave*/
                $tam = strlen($chave);/*usamos o strlen pra ver quantos caracteres tem aqui*/
                $num = "";
                $qtde = rand(20, 50);/*tamanho da chave de 20 a 50 caracteres*/
                for ($i = 0; $i < $qtde; $i++) {
                    $pos = rand(0, $tam);/*a variavel pos recebe um unumero aleatorio de 0 a o tamanho da chave */
                    $num .= substr($chave, $pos, 1);/*pegamos um elemento com o substr, a string q pegaremos a posicao do elemento que iremos pegar e a quantidade de elementos que pegaremos*/
                }
                session_start();/*iniciamos uma sessao e armazenamos o login e o username*/
                $_SESSION['numlogin'] = $num;
                $_SESSION['username'] = $user;
                $_SESSION['acesso'] = $ret['acesso']; //o=restrito, 1 =ilimmitado/*campo criado para armazenar o valor do 'acesso' em forma de array*/
                header("location:gerenciamento.php?num=$num");
            }
        }/* vai usar o elemento pra ver se algum elemento dos arquivos enviados pelo submit existem*/
        mysqli_close($con);/*quando termina a rotina é sempre bom fechar ela */

        ?>
        <form action="login.php" method="post" name="f_login" id="f_login">
            <!--aqui vamos chamar ele mesmmo aqui pra fazer a verificação do login-->
            <label>Usuario</label>
            <input type="text" name="f_user">
            <label>Senha</label>
            <input type="password" name="f_senha">
            <input type="submit" value="Logar" name="f_logar">
        </form>


    </section>

    <footer>
        <!--rodapé-->
        <?php
        include "rodape.html";

        ?>
    </footer>
</body>

</html>