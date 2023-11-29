<?php
$pdo = new PDO('mysql:host=localhost;dbname=bootstrap_projeto', 'root', '');
$sobre = $pdo->prepare("SELECT * FROM `tb_sobre`");
$sobre->execute();
$sobre = $sobre->fetch()['sobre'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel de controle</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Controle de acervo</a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul id="menu-principal" class="nav navbar-nav">
          <li><a ref_sys="cadastrar_equipe" href="#about">Cadastrar Objeto</a></li>
          <li><a ref_sys="lista_equipe" href="#contact">Listar Objetos</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>
  <div style="position: relative;top:50px;" class="box">
    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <h2><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Painel de controle</h2>
          </div>
        </div>
      </div>
    </header>

    <section class="bread">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Home</li>
        </ol>
      </div>
    </section>

    <section class="principal">

      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a href="#" class="list-group-item" ref_sys="cadastrar_equipe">Cadastrar Objeto <span class="glyphicon glyphicon-pencil"></span></a>
              <a href="#" class="list-group-item" ref_sys="lista_equipe">Listar Objetos <span class="glyphicon glyphicon-list-alt"></span></a>
            </div>

          </div>

          <div class="col-md-9">
            <?php

            if (isset($_POST['cadastrar_equipe'])) {
              $nome = $_POST['nome_membro'];
              $descricao = $_POST['descricao'];
              $data_aproximada = $_POST['data_aproximada'];
              $num_patrimonio = $_POST['numero_patrimonio'];
              $localizacao = $_POST['localizacao'];
              $conteudo_basico = $_POST['conteudo_basico'];
              $genero_documental = $_POST['genero_documental'];
              $formato = $_POST['formato'];
              $dimensoes = $_POST['dimensoes'];
              $estado_conservacao = $_POST['estado_conservacao'];
              $fotos = array();
              if (isset($_FILES['pic'])) {
                $ext = strtolower(substr($_FILES['pic']['name'], -4)); //Pegando extensão do arquivo
                $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
                $dir = './imagens/'; //Diretório para uploads

                move_uploaded_file($_FILES['pic']['tmp_name'], $dir . $new_name); //Fazer upload do arquivo
                array_push($fotos, $new_name);
              }


              if (!empty($nome) && !empty($descricao)) {
                require 'classes/Produto_class.php';
                $p = new Produto_class('bootstrap_projeto', 'root', '');
                $p->enviarProduto($nome, $descricao, $data_aproximada, $num_patrimonio, $localizacao, $conteudo_basico, $genero_documental, $formato, $dimensoes, $estado_conservacao, $fotos);
              }

              echo '<div class="alert alert-success" role="alert">O Objeto foi cadastrado com sucesso!</div>';
            }
            ?>

            <div id="cadastrar_equipe_section" class="panel panel-default">
              <div class="panel-heading cor-padrao">
                <h3 class="panel-title">Cadastrar Objeto:</h3>
              </div>
              <div class="panel-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="nome_membro">Nome do Objeto:</label>
                    <input type="text" name="nome_membro" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="descricao">Descrição do Objeto:</label>
                    <textarea name="descricao" rows="4" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="data_aproximada">Data do Objeto:</label>
                    <input type="date" name="data_aproximada" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="numero_patrimonio">Número do Patrimônio:</label>
                    <input type="text" name="numero_patrimonio" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="localizacao">Localização do Objeto:</label>
                    <input type="text" name="localizacao" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="conteudo_basico">Conteúdo Básico do Objeto:</label>
                    <textarea name="conteudo_basico" rows="3" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="genero_documental">Gênero Documental:</label>
                    <input type="text" name="genero_documental" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="formato">Formato:</label>
                    <input type="text" name="formato" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="dimensoes">Dimensões:</label>
                    <input type="text" name="dimensoes" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="estado_conservacao">Estado de Conservação:</label>
                    <input type="text" name="estado_conservacao" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="pic">Imagem do Objeto:</label>
                    <input type="file" name="pic" accept="image/*" class="form-control">
                  </div>
                  <input type="hidden" name="cadastrar_equipe">
                  <button type="submit" class="btn btn-primary form-control">Enviar</button>
                </form>
              </div>
            </div>



            <div id="lista_equipe_section" class="panel panel-default">
              <div class="panel-heading cor-padrao">
                <h3 class="panel-title">Objetos Cadastrados:</h3>
              </div>
              <div class="panel-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Nome do Objeto</th>
                      <th>Imagem</th>
                      <th>Editar</th>
                      <th>Excluir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $selecionarMembros = $pdo->prepare("SELECT `id`,`nome` FROM `tb_equipe`");
                    $selecionarMembros->execute();
                    $membros = $selecionarMembros->fetchAll();
                    foreach ($membros as $key => $value) {
                    ?>
                      <tr>
                        <td><?php echo $value['nome'] ?></td>
                        <td><a href="exibirObjeto.php?id=<?php echo $value['id']; ?>">Ver Imagem</a></td>
                        <td>
                          <a href="editarObjeto.php?id=<?php echo $value['id']; ?>" class="btn btn-primary btn-sm">
                            <span class="glyphicon glyphicon-edit"></span> Editar
                          </a>
                        </td>
                        <td>
                          <button id_membro="<?php echo $value['id']; ?>" class="deletar-membro btn btn-sm btn-danger">
                            <span class="glyphicon glyphicon-trash"></span> Excluir
                          </button>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>

    </section>

  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(function() {

      cliqueMenu();
      scrollItem();

      function cliqueMenu() {
        $('#menu-principal a, .list-group a').click(function() {
          $('.list-group a').removeClass('active').removeClass('cor-padrao');
          $('#menu-principal a').parent().removeClass('active');
          //console.log('#menu-principal a[ref_sys='+$(this).attr('ref_sys')+']');
          $('#menu-principal a[ref_sys=' + $(this).attr('ref_sys') + ']').parent().addClass('active');
          $('.list-group a[ref_sys=' + $(this).attr('ref_sys') + ']').addClass('active').addClass('cor-padrao');
          return false;
        })
      }

      function scrollItem() {
        $('#menu-principal a, .list-group a').click(function() {
          var ref = '#' + $(this).attr('ref_sys') + '_section';
          var offset = $(ref).offset().top;
          $('html,body').animate({
            'scrollTop': offset - 50
          });
          if ($(window)[0].innerWidth <= 768) {
            $('.icon-bar').click();
          }
        });
      }


      $('button.deletar-membro').click(function() {
        var id_membro = $(this).attr('id_membro');
        var el = $(this).parent().parent();
        $.ajax({
          method: 'post',
          data: {
            'id_membro': id_membro
          },
          url: 'deletar.php'
        }).done(function() {
          el.fadeOut(function() {
            el.remove();
          });
        })


      })

    })
  </script>
</body>

</html>