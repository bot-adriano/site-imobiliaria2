<?php
session_start();
if (isset($_SESSION["numlogin"])) {
    if (isset($_GET["num"])) { /*aqui modificamos o issetparareconhecer o  GET ou POSTcom o  if*/
        $n1 = $_GET["num"];
    } else if (isset($_POST["num"])) {
        $n1 = $_POST["num"];
    }
    /* $n1 = $_GET["num"];*/
    $n2 = $_SESSION["numlogin"]; /*armazena o num log que esta na sessaão e verificaar se os valores são iguais para entrar no site*/

    if ($n1 != $n2) { /*se n1 for diferente de n2 ele vai barrar e fechar a execução */
        echo "<p>Login não efetuado</p>";
        exit;
    }
} else { /*para nao entrar na pagina por digitação direta bloqueamos aqui*/
    echo "<p>Login não efetuado</p>";
    exit;
}
include "conexao.inc"; /*colocamos o include da conexao para conectar com o sql*/

?>
<!doctype html>
<html lang="pt-br">

<head>
    <title>casa dos sonhos</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="estilos.css">
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            /*quando mudar o valor do select ele vai filtar e exibir somete os imoveis relacionados ao tipo*/
            $('select[name="f_imovel"]').on('change', function() {
                /*seleciona imovel quando tiver o valor alterado ele executa*/
                var vmarcas = this.value; /*cria variavel vmarcas atribuindo valor do id do imoveis dos elementos que foi mudado*/
                $('select[name="f_tipo"] option').each(function() {
                    /*para cada elementos do ftipo verifica se é igual ao selecionado*/
                    var $this = $(this); /*o this do jquery pega o elemento do select de cima e adiciona no this*/
                    if ($this.data('tipo') == vmarcas) {
                        /*se o data-tipo  for igual a variavel vmarca aparece */
                        $this.show();
                    } else {
                        /*se não ele esconde*/
                        $this.hide();

                    }
                });
            });
            $('select[name="f_tipo"]').val('');
        });
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
        <h1>Novo imovel</h1>

        <?php /*cria rotina php ela vai verificar se o formulario foi submetido vai receber os dados do get e fazer a totina pra gravar no banco de dados, se n foi ele deixa a rotina <normal></normal> */
        if (isset($_POST["f_bt_novoimovel"])) {
            $vetFotos = array();
            $vetMini = array();
            $if = 0;
            $qtdeFotos = 3;

            $dir = 'imoveis/';/*quando for usar no servidortem q colocar o diretorio do patch fica mais  ou manos assim'home/cfbveiculos/public_html/carros/*/

            for ($if = 0; $if < $qtdeFotos; $if++) {

                if ($_FILES['f_foto' . ($if + 1)]['name'] != "") {/*verifica se ele contem o nome de arquivo  comparando o nome dele é diferente de vazio e verifica se foi clicado e selecionado aí ele vai fazer a rotina pra copiar pro servidor e gerar miniatura*/
                    /*rotina para fazer o upload da imagem para o servidor, obter a extensão , o nome do arquivo (temos q ter cuidado para n ter arquivos com o  mesmo nome e acabar sobreescrever )
                                para evitar criamos um nome unico usando uma função do php uniquid e para isso precisamos obter a extensão da foto*/
                    $ex = strtolower(substr($_FILES['f_foto' . ($if + 1)]['name'], -4));/*-4 indicaos 4 ultimos caracteres q no caso aqui preciso pegara extensão*/
                    $novo_nome = uniqid() . $ex;/*texto criado pelo uniqid+ extensão pego pelo ex*/
                    move_uploaded_file($_FILES['f_foto' . ($if + 1)]['tmp_name'], $dir . $novo_nome);/*move o arquivo para o local com o novo nome*/

                    list($largura, $altura, $tipo) = getimagesize($dir . $novo_nome);/*para pegar o tamanho da imagem (getimagesize)ele eretorna em vetor e ele coloca no elemento list que recebe a largura, altura e tipo */
                    $imagem = imagecreatefromjpeg($dir . $novo_nome);/*criar a imagem jpg a partir da outra imagem , armazenado no diretório*/
                    $thumb = imagecreatetruecolor(117, 88);/*cria uma imagem menor(117x88) e armazena na variavel thumb*/
                    imagecopyresampled($thumb, $imagem, 0, 0, 0, 0, 117, 80, $largura, $altura);/*anexa a imagem no thumb, para issotemosque passar algumas informações:o destino,a origem, o x e p y do destino, o x e o y da origem,o tamanho das imagens da origem e destino */
                    imagejpeg($thumb, $dir . "mini_" . $novo_nome, 50);/*envia a imagem para a pasta e renomeia (imagemjpeg cria uma imagem a partir dos dados informados)usamos o nome original e acrescentamos o o mini antes do nome e no final colocamos a qualidade q no caso deixamos em 50% */


                    $vetFotos[$if] = $dir . $novo_nome;
                    $vetMini[$if] = $dir . "mini_" . $novo_nome;
                } else {
                    $vetFotos[$if] = "";
                    $vetMini[$if] = "";
                }
            }

            $vid_imovel = $_POST['f_imovel'];
            $vid_modelo = $_POST['f_tipo'];
            $vid_bairro = $_POST['f_bairro'];
            $vid_cidade = $_POST['f_cidade'];
            $vid_cep = $_POST['f_cep'];
            $vid_rua = $_POST['f_rua'];
            $v_obs = $_POST['f_obs'];
            $v_venda = number_format((float)$_POST['f_venda'], 2, '.', '');
            $v_aluguel = number_format((float)$_POST['f_aluguel'], 2, '.', '');
            $v_iptu = number_format((float)$_POST['f_iptu'], 2, '.', '');
            $v_condominio = number_format((float)$_POST['f_condominio'], 2, '.', '');
            $v_quartos = $_POST['f_quartos'];
            $v_suite = $_POST['f_suite'];
            $v_sala = $_POST['f_sala'];
            $v_vaga = $_POST['f_vaga'];
            $v_banheiro = $_POST['f_banheiro'];
            $vfoto1 = $vetFotos[0];
            $vfoto2 = $vetFotos[1];
            $vfoto3 = $vetFotos[2];
            $vmini1 = $vetMini[0];
            $vmini2 = $vetMini[1];
            $vmini3 = $vetMini[2];
            $vvendido = 0;
            $valugado = 0;
            $vbloqueado = 0;
            $zona = substr($vid_cep, 1, 1);
            //$zona1;
            if ($zona == 1) {
                $zona1 = 'centro';
            } else if ($zona == 2) {
                $zona1 = 'zona norte';
            } else if ($zona == 3) {
                $zona1 = 'zona leste';
            } else if ($zona == 4) {
                $zona1 = 'zona sul';
            } else {
                $zona1 = 'zona leste';
            }
            $zona1 = $_POST['f_zona'];


            $sql = "INSERT INTO tb_casa ( id_qualimovel, id_modelocasa, id_bairro,id_cidade,id_cep,id_rua,obs,venda,aluguel,iptu,condominio,quartos,suite,sala,vaga,banheiro,foto1,foto2,foto3,mini1,mini2,mini3,vendido,alugado,bloqueado,zona) VALUES ($vid_imovel, $vid_modelo, '$vid_bairro', '$vid_cidade', $vid_cep, '$vid_rua', '$v_obs', $v_venda, $v_aluguel, $v_iptu, $v_condominio, $v_quartos, $v_suite, $v_sala, $v_vaga, $v_banheiro, '$vfoto1', '$vfoto2', '$vfoto3', '$vmini1', '$vmini2', '$vmini3', $vvendido, $valugado, $vbloqueado,'$zona1')";
            mysqli_query($con, $sql);
            $linhas = mysqli_affected_rows($con);
            if ($linhas >= 1) {
                echo "<script>alert('Novo Imóvel adicionado com sucesso');</script>";
                //echo " <p> Novo imovel gravado com sucesso </p> ";
            } else {
                echo "<script>alert ('Erro ao Adicionar Imóvel');</script>";
                //echo "<p> Erro ao gravar novo imovel </p>";
            }
        }




        ?>


        <form name="f_novo_imovel" action="novoimovel.php" class="f_novoimovel" method="POST" enctype="multipart/form-data">
            <!--para funcionar postar as fotos temos que mudar  para post e acrescentar multipat/fform-data-->
            <input type="hidden" name="num" value="<?php echo $n1; ?>">
            <label>tipo de imóvel</label>
            <select name="f_imovel">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM tb_imoveis";
                $res = mysqli_query($con, $sql);
                while ($linha = mysqli_fetch_row($res)) {
                    echo "<option value='" . $linha[1] . "'>" . $linha[0] . "</option>";/*insere o codigo da tabela imoveis guardando o indice e na linha [0]pegamos a descrição do imóvel*/
                }
                ?>
            </select>

            <label>tipo</label>
            <select name="f_tipo">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM tb_tipo_imovel";
                $res = mysqli_query($con, $sql);
                while ($linha = mysqli_fetch_row($res)) {


                    echo "<option value='" . $linha[0] . "' data-tipo='" . $linha[2] . "' >" . $linha[1] . "</option>";/*data tipo é pra separar os tipos de imoveis*/
                }
                ?>

            </select>

            <!--  <label>bairro</label>
            <input type="text" name="f_bairro" maxlength="50" size="50" required="required">-->
            <label for="cep">CEP</label>
            <input id="cep" type="text" name="f_cep" maxlength="50" size="50" pattern="[0-9]+$" required="required" />
            <label for="logradouro">Logradouro</label>
            <input id="logradouro" type="text" name="f_rua" maxlength="50" size="50" required="required" />
            <label for="numero">Número</label>
            <input id="numero" type="text" />
            <label for="complemento">Complemento</label>
            <input id="complemento" type="text" />
            <label for="bairro">Bairro</label>
            <input id="bairro" type="text" name="f_bairro" maxlength="50" size="50" required="required" />

            <!-- <label>cidade</label>
            <input type="text" name="f_cidade" maxlength="50" size="50" required="required">-->
            <label for="cidade">localidade</label>
            <input id="cidade" type="text" name="f_cidade" required />
            <!--   <label for="bairro">Bairro</label>
        <input id="bairro" type="text" name="f_bairro" maxlength="50" size="50" required="required"/>-->
            <label for="uf">Estado</label>
            <select id="uf">
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>

                <!--  
                <label>cep</label>
                 <input type="text" name="f_cep" maxlength="50" size="50" pattern="[0-9]+$" required="required">
            <label>rua</label>
            <input type="text" name="f_rua" maxlength="50" size="50" required="required">-->

                <label>detalhes</label>
                <textarea name="f_obs" rows="5" cols="51" required="required"></textarea>
                <label>venda</label>
                <input type="text" name="f_venda" maxlength="50" size="50" pattern="[0-9]+$" required="required">
                <label>aluguel</label>
                <input type="text" name="f_aluguel" maxlength="50" size="50" pattern="[0-9]+$" required="required">
                <label>iptu</label>
                <input type="text" name="f_iptu" maxlength="50" size="50" pattern="[0-9]+$" required="required">
                <label>condominio</label>
                <input type="text" name="f_condominio" maxlength="50" size="50" pattern="[0-9]+$" required="required">
                <label>quartos</label>
                <input type="text" name="f_quartos" maxlength="50" size="50" pattern="[0-9]+$" required="required">
                <label>suite</label>
                <input type="text" name="f_suite" maxlength="50" size="50" pattern="[0-9]+$" required="required">
                <label>sala</label>
                <input type="text" name="f_sala" maxlength="50" size="50" pattern="[0-9]+$" required="required">
                <label>vaga</label>
                <input type="text" name="f_vaga" maxlength="50" size="50" pattern="[0-9]+$" required="required">
                <label>banheiro</label>
                <input type="text" name="f_banheiro" maxlength="50" size="50" pattern="[0-9]+$" required="required">
                <label>foto1</label>
                <input type="file" name="f_foto1">
                <label>foto2</label>
                <input type="file" name="f_foto2">
                <label>foto3</label>
                <input type="file" name="f_foto3">
                <!--<label>vendido</label>
             <input type="text" name="f_vendido" maxlenght="50" size="50" required="required" >
            <label>alugado</label>
            <input type="text" name="f_alugado" maxlenght="50" size="50" required="required" >
            <label>bloqueado</label>
            <input type="text" name="f_bloqueado" maxlenght="50" size="50" required="required" >-->

                <input type="submit" name="f_bt_novoimovel" class="btmenu" value="gravar">



        </form>

    </section>
    <!--Importando Script Jquery-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!--Formulário-->
    <!--  <form class="formula">
        <label for="cep">CEP</label>
        <input id="cep" type="text" required />
        <label for="logradouro">Logradouro</label>
        <input id="logradouro" type="text" required />
        <label for="numero">Número</label>
        <input id="numero" type="text" />
        <label for="complemento">Complemento</label>
        <input id="complemento" type="text" />
        <label for="bairro">Bairro</label>
        <input id="bairro" type="text" name="f_bairro" maxlength="50" size="50" required="required" />
        
        <label for="localidade">localidade</label>
        <input id="localidade" type="text" name="f_cidade" required />-->
    <!--
    <label for="uf">Estado</label>
    <select id="uf">
        <option value="AC">Acre</option>
        <option value="AL">Alagoas</option>
        <option value="AP">Amapá</option>
        <option value="AM">Amazonas</option>
        <option value="BA">Bahia</option>
        <option value="CE">Ceará</option>
        <option value="DF">Distrito Federal</option>
        <option value="ES">Espírito Santo</option>
        <option value="GO">Goiás</option>
        <option value="MA">Maranhão</option>
        <option value="MT">Mato Grosso</option>
        <option value="MS">Mato Grosso do Sul</option>
        <option value="MG">Minas Gerais</option>
        <option value="PA">Pará</option>
        <option value="PB">Paraíba</option>
        <option value="PR">Paraná</option>
        <option value="PE">Pernambuco</option>
        <option value="PI">Piauí</option>
        <option value="RJ">Rio de Janeiro</option>
        <option value="RN">Rio Grande do Norte</option>
        <option value="RS">Rio Grande do Sul</option>
        <option value="RO">Rondônia</option>
        <option value="RR">Roraima</option>
        <option value="SC">Santa Catarina</option>
        <option value="SP">São Paulo</option>
        <option value="SE">Sergipe</option>
        <option value="TO">Tocantins</option>-->
    </select>
    <script type="text/javascript">
        $("#cep").focusout(function() {
            //Início do Comando AJAX
            $.ajax({
                //O campo URL diz o caminho de onde virá os dados
                //É importante concatenar o valor digitado no CEP
                url: 'https://viacep.com.br/ws/' + $(this).val() + '/json/unicode/',
                //Aqui você deve preencher o tipo de dados que será lido,
                //no caso, estamos lendo JSON.
                dataType: 'json',
                //SUCESS é referente a função que será executada caso
                //ele consiga ler a fonte de dados com sucesso.
                //O parâmetro dentro da função se refere ao nome da variável
                //que você vai dar para ler esse objeto.
                success: function(resposta) {
                    //Agora basta definir os valores que você deseja preencher
                    //automaticamente nos campos acima.
                    $("#logradouro").val(resposta.logradouro);
                    $("#complemento").val(resposta.complemento);
                    $("#bairro").val(resposta.bairro);
                    $("#cidade").val(resposta.localidade);
                    $("#uf").val(resposta.uf);
                    //Vamos incluir para que o Número seja focado automaticamente
                    //melhorando a experiência do usuário
                    $("#numero").focus();
                }
            });
        });
    </script>
    </form>


</body>

</html>