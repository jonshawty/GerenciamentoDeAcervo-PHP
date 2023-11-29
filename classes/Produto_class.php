<?php
class Produto_class{
private $pdo;
    public function __construct($dbname,$user,$senha){
try {
    $this ->pdo = new PDO("mysql:host=127.0.0.1;dbname=$dbname", $user, $senha);
    

} catch (PDOException $e) {
    echo 'Erro com o banco de dados:'.$e ->getMessage();
}catch (Exception $e) {
    echo 'Erro generico'.$e ->getMessage();
}
   }

public function enviarProduto($nome,$descricao, $data_aproximada, $num_patrimonio,$localizacao,$conteudo_basico,$genero_documental,$formato,$dimensoes, $estado_conservacao, $fotos = array()){
$cmd =$this ->pdo->prepare('INSERT INTO tb_equipe (nome,descricao, data_aproximada, numero_patrimonio, localizacao, conteudo_basico,genero_documental,formato,dimensoes, estado_conservacao) values(:n,:d, :data_aproximada, :numero_patrimonio, :localizacao, :conteudo_basico, :genero_documental, :formato, :dimensoes, :estado_conservacao)');
$cmd->bindValue(':n', "$nome");
$cmd->bindValue(':d', "$descricao");
$cmd->bindValue(':data_aproximada', "$data_aproximada");
$cmd->bindValue(':numero_patrimonio', "$num_patrimonio");
$cmd->bindValue(':localizacao', "$localizacao");
$cmd->bindValue(':conteudo_basico', "$conteudo_basico");
$cmd->bindValue(':genero_documental', "$genero_documental");
$cmd->bindValue(':formato', "$formato");
$cmd->bindValue(':dimensoes', "$dimensoes");
$cmd->bindValue(':estado_conservacao', "$estado_conservacao");
$cmd->execute();
$id_produto = $this ->pdo->LastinsertId();

if (count($fotos)) {
    for ($i = 0; $i < count($fotos); $i++) {
      $nome_foto = $fotos[$i];

      $cmd = $this ->pdo->prepare('INSERT INTO imagens(nome_imagem,fk_id_equipe) values (:n,:fk)');
      $cmd->bindValue(':n', "$nome_foto");
      $cmd->bindValue(':fk', "$id_produto");
      $cmd->execute();
    }
  }

}

public function atualizarProduto($id, $novosDados, $fotos = array()) {
    try {
        // Atualizar os dados principais do produto
        $query = "UPDATE tb_equipe SET
            nome = :nome,
            descricao = :descricao,
            data_aproximada = :data_aproximada,
            numero_patrimonio = :numero_patrimonio,
            localizacao = :localizacao,
            genero_documental = :genero_documental,
            formato = :formato,
            dimensoes = :dimensoes,
            estado_conservacao = :estado_conservacao,
            conteudo_basico = :conteudo_basico
            WHERE id = :id";
        
        $cmd = $this->pdo->prepare($query);
        $cmd->bindValue(':nome', $novosDados['nome']);
        $cmd->bindValue(':descricao', $novosDados['descricao']);
        $cmd->bindValue(':data_aproximada', $novosDados['data_aproximada']);
        $cmd->bindValue(':numero_patrimonio', $novosDados['numero_patrimonio']);
        $cmd->bindValue(':localizacao', $novosDados['localizacao']);
        $cmd->bindValue(':genero_documental', $novosDados['genero_documental']);
        $cmd->bindValue(':formato', $novosDados['formato']);
        $cmd->bindValue(':dimensoes', $novosDados['dimensoes']);
        $cmd->bindValue(':estado_conservacao', $novosDados['estado_conservacao']);
        $cmd->bindValue(':conteudo_basico', $novosDados['conteudo_basico']);
        $cmd->bindValue(':id', $id);

        $cmd->execute();

        // Atualizar imagens do produto
if (count($fotos)) {
    for ($i = 0; $i < count($fotos); $i++) {
        $nome_foto = $fotos[$i];

        $cmd = $this->pdo->prepare('UPDATE imagens SET nome_imagem = :nome_imagem WHERE fk_id_equipe = :id_equipe');
        $cmd->bindValue(':nome_imagem', $nome_foto);
        $cmd->bindValue(':id_equipe', $id);
        $cmd->execute();
    }
}
          

        return true;
    } catch (PDOException $e) {
        // Tratar erros conforme necessário
        return false;
    }
}

// ...





public function buscarProdutos()
    {

    $cmd = $this->pdo->query('SELECT *, (SELECT nome_imagem from imagens where fk_id_equipe = tb_equipe.id LIMIT 1)
     as foto_capa 
     from tb_equipe');

        if ($cmd->rowCount() > 0) {

            $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);

        } else {

            $dados = array();

        }
        return $dados;

    }

public function buscarProdutoporId($id)
    {
        $cmd = $this->pdo->prepare('SELECT * FROM tb_equipe where id = :id');
        $cmd->bindValue(':id', $id);
        $cmd->execute();
        if ($cmd->rowCount() > 0) {
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        } else {
            $dados = array();
        }

        return $dados;


    }

public function buscarImagensPorId($id)
    {
        $cmd = $this->pdo->prepare('SELECT nome_imagem FROM imagens where fk_id_equipe = :id');
        $cmd->bindValue(':id', $id);
        $cmd->execute();

        if ($cmd->rowCount() > 0) {
            $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $dados = array();
        }

        return $dados;
    }

}
