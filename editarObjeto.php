<?php
require 'classes/Produto_class.php';
$p = new Produto_class('mysql:host=localhost;dbname=bootstrap_projeto', 'root', '');


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = addslashes($_GET['id']);
} else {
    header('location: produtos.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novosDados = array(
        'nome' => $_POST['nome'],
        'descricao' => $_POST['descricao'],
        'data_aproximada' => $_POST['data_aproximada'],
        'numero_patrimonio' => $_POST['numero_patrimonio'],
        'localizacao' => $_POST['localizacao'],
        'genero_documental' => $_POST['genero_documental'],
        'formato' => $_POST['formato'],
        'dimensoes' => $_POST['dimensoes'],
        'estado_conservacao' => $_POST['estado_conservacao'],
        'conteudo_basico' => $_POST['conteudo_basico']
    );

    $fotos = array();
    if (isset($_FILES['pic'])) {
        $ext = strtolower(substr($_FILES['pic']['name'], -4));
        $new_name = date("Y.m.d-H.i.s") . $ext;
        $dir = './imagens/';

        if (move_uploaded_file($_FILES['pic']['tmp_name'], $dir . $new_name)) {
            // Arquivo movido com sucesso
            array_push($fotos, $new_name);
        } else {
            // Houve um problema ao mover o arquivo
            echo "Erro ao fazer upload do arquivo.";
        }
    }

    $p->atualizarProduto($id, $novosDados, $fotos);

    // Redirecionar para a página de exibição do produto
    header("Location: exibirObjeto.php?id=$id");
    exit;
}

$dadosDoProduto = $p->buscarProdutoporId($id);
$imagensDoProduto = $p->buscarImagensPorId($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Objeto</title>
    <link rel="stylesheet" href="css/3.css">
    <link rel="stylesheet" href="css/exibirstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .project-info-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .project-info-box h5 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .thumbnail-container {
            text-align: center;
        }

        .thumbnail {
            max-width: 80%;
            height: 80%;
            display: inline-block;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="project-info-box mt-0">
                        <?php
                        $dadosProduto = $p->buscarProdutos();
                        if (empty($dadosProduto)) {
                            echo 'Ainda não há produtos cadastrados aqui';
                        } else {
                            foreach ($imagensDoProduto as $value) {
                        ?>

                                <div class="project-info-box">
                                    <p class="thumbnail-container">
                                        <img class="thumbnail" src="imagens/<?php echo $value['nome_imagem']; ?>">
                                    </p>

                            <?php
                            }
                        }
                            ?>
                            <h5>Descrição do Objeto</h5>
                            <!-- Mostrar o formulário de edição -->
                            <form method="POST">
                                <div class="form-group">
                                    <label for="formato">Nome</label>
                                    <input type="text" name="nome" class="form-control" value="<?php echo $dadosDoProduto['nome'] ?>"></input>
                                </div>
                                <div class="form-group">
                                    <label for="formato">Descrição:</label>
                                    <input type="text" name="descricao" class="form-control" value="<?php echo $dadosDoProduto['descricao'] ?>"></input>
                                </div>
                                <div class="form-group">
                                    <label for="formato">Data Aproximada:</label>
                                    <input type="text" name="data_aproximada" class="form-control" value="<?php echo $dadosDoProduto['data_aproximada'] ?>"></input>
                                </div>
                                <div class="form-group">
                                    <label for="formato">Número de Pátrimonio:</label>
                                    <input type="text" name="numero_patrimonio" class="form-control" value="<?php echo $dadosDoProduto['numero_patrimonio'] ?>"></input>
                                </div>
                                <div class="form-group">
                                    <label for="formato">Localização:</label>
                                    <input type="text" name="localizacao" class="form-control" value="<?php echo $dadosDoProduto['localizacao'] ?>"></input>
                                </div>
                                <div class="form-group">
                                    <label for="formato">Gênero Documental:</label>
                                    <input type="text" name="genero_documental" class="form-control" value="<?php echo $dadosDoProduto['genero_documental'] ?>"></input>
                                </div>
                                <div class="form-group">
                                    <label for="formato">Formato do Objeto:</label>
                                    <input type="text" name="formato" class="form-control" value="<?php echo $dadosDoProduto['formato'] ?>"></input>
                                </div>
                                <div class="form-group">
                                    <label for="formato">Dimensões do Objeto:</label>
                                    <input type="text" name="dimensoes" class="form-control" value="<?php echo $dadosDoProduto['dimensoes'] ?>"></input>
                                </div>
                                <div class="form-group">
                                    <label for="formato">Estado de conservação do Objeto:</label>
                                    <input type="text" name="estado_conservacao" class="form-control" value="<?php echo $dadosDoProduto['estado_conservacao'] ?>"></input>
                                </div>
                                <div class="form-group">
                                    <label for="formato">Contéudo Basico:</label>
                                    <input type="text" name="conteudo_basico" class="form-control" value="<?php echo $dadosDoProduto['conteudo_basico'] ?>"></input>
                                </div>
                                <button type="submit">Salvar Alterações</button>
                            </form>
                                </div><!-- / project-info-box -->
                    </div><!-- / column -->
                </div>
            </div>
    </section>
</body>

</html>