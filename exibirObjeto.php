<?php
require 'classes/Produto_class.php';
$p = new Produto_class('mysql:host=localhost;dbname=bootstrap_projeto', 'root', '');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = addslashes($_GET['id']);
} else {
    header('location: produtos.php');
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
    <title>Document</title>
    <link href="css/3.css" rel="stylesheet">
    <link href="css/exibirstyle.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 20px;
        }

        .project-info-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .project-info-box h5 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .thumbnail-container {
            text-align: center;
        }

        .thumbnail {
            max-width: 80%;
            height: 80%;
            display: inline-block;
        }

        .project-info-box p {
            margin: 10px 0;
        }

        .back-button {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="project-info-box mt-0">
                    <section>
                        <?php
                        $dadosProduto = $p->buscarProdutos();
                        if (empty($dadosProduto)) {
                            echo 'Ainda não há produtos cadastrados aqui';
                        } else {
                        ?>
                            <h1><?php echo $dadosDoProduto['nome']; ?></h1>
                            <?php
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
                            <p class="mb-0"><?php echo $dadosDoProduto['descricao'] ?></p>
                                </div><!-- / project-info-box -->

                                <div class="project-info-box">
                                    <p><b>Data Aproximada:</b> <?php echo $dadosDoProduto['data_aproximada'] ?></p>
                                    <p><b>Número de Pátrimonio:</b> <?php echo $dadosDoProduto['numero_patrimonio'] ?></p>
                                    <p><b>Localização:</b> <?php echo $dadosDoProduto['localizacao'] ?></p>
                                    <p><b>Gênero Documental:</b> <?php echo $dadosDoProduto['genero_documental'] ?></p>
                                    <p><b>Formato do Objeto:</b> <?php echo $dadosDoProduto['formato'] ?></p>
                                    <p><b>Dimensões do Objeto:</b> <?php echo $dadosDoProduto['dimensoes'] ?></p>
                                    <p><b>Estado de conservação do Objeto:</b> <?php echo $dadosDoProduto['estado_conservacao'] ?></p>
                                    <p><b>Contéudo Basico:</b> <?php echo $dadosDoProduto['conteudo_basico'] ?></p>
                                </div><!-- / project-info-box -->

                                <a href="index.php" class="back-button">Voltar para a Página Principal</a>
                    </section>
                </div><!-- / column -->
            </div>
        </div>

</body>

</html>