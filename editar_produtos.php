<?php

require './App/Classes/Produtos.php';

if(isset($_GET['id_user'])){

    $id = $_GET['id_user'];
    $objUser = new Produtos();
    $user_edit = $objUser->buscar_por_id($id);
}


if(isset($_POST['editar'])){

  $nome = $_POST['nome'];
  $descricao = $_POST['desc'];
  $preco = $_POST['preco'];
  $quantidade_em_estoque = $_POST['quant'];

  print_r($_POST);
  
    #########################MANIPULANDO ARQUIVOS COM PHP -- FOTOS --- PDFS ETC########
  
    //print_r($_FILES);
    $arquivo = $_FILES['foto'];
  
    if ($arquivo['error']) die ("Falha ao enviar a foto");
  
    $pasta = './uploads/fotos/';
    $nome_foto = $arquivo['name'];
    $novo_nome = uniqid();
    $extensao = strtolower(pathinfo($nome_foto, PATHINFO_EXTENSION));
  
    if($extensao != 'png' && $extensao != 'jpg' && $extensao != 'jfif' && $extensao != 'jpeg' && $extensao != 'gif' && $extensao != 'webp' && $extensao != 'svg' ) die ("Arquivo inválido!!!");
  
    $path = $pasta . $novo_nome . '.' . $extensao;
    $foto = move_uploaded_file($arquivo['tmp_name'], $path);
  
    ########################MANIPULANDO ARQUIVOS COM PHP -- FOTOS --- PDFS ETC########
    //echo "MOVED: " . $foto;

    $objProd = new Produtos();
    $objProd->nome = $nome;
    $objProd->descricao  = $descricao;
    $objProd->preco  = $preco;
    $objProd->quantidade_em_estoque = $quantidade_em_estoque;
    $objProd->foto = $path;
  
    //print_r($objUser);
    $res = $objProd->atualizar();
    if($res){
        header('location:./listar.php');
    }else{
      echo '<script> alert("Erro ao cadastrar!!") </script> ';
    }
  }
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Sys CAD</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar- bg-primary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="index.php" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Sobre</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Cadastro</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Contato</a>
              </li>
          
            </ul>
          </div>
        </div>
      </nav>
    <div class="p-5 bg-dark text-white">
        <h1>Sistema do Eliandro</h1>
    
      </div>
    <div class="container">
        <h1 class="mt-4 text-center">Editar Produto</h1>
    </div>
    <div class="container">
                    
    <form method="POST" enctype="multipart/form-data" >
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do produto</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $objProd->nome; ?>" >
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto" value="<?php echo $objProd->foto; ?>" >
                </div>

                <div class="mb-3">
                    <label for="desc" class="form-label">Descrição do Produto</label>
                    <textarea class="form-control" name="desc" id="desc" rows="3" value="<?php echo $objProd->descricao; ?>" ></textarea>
                </div>
                <div class="mb-3">
                    <label for="quant" class="form-label">Quantidade do Produto</label>
                    <input class="form-control" name="quant" id="quant" type="text" placeholder="" aria-label="" value="<?php echo $objProd->quantidade_em_estoque; ?>" >
                </div>   
                
                <div class="mb-3">
                    <label for="preco" class="form-label">Preço do Produto</label>
                    <input class="form-control" name="preco" id="preco" type="text" placeholder="" aria-label="" value="<?php echo $objProd->preco; ?>" >
                </div>
                
                <button type="reset" class="btn btn-danger">Cancelar</button>
                <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                <a href="listar_produtos.php">
                <button type="button" class="btn btn-success">Listar</button>
                </a>
                
            </form>
    </div>
</body>
</html>