<?php 

session_start();

// verifica se o usuario está logado 

if(!isset($_SESSION['user_id'])){
    header('Location; ../login.php');
}

include_once('../../helpers/database.php');

$connection = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // Obtém os dados do formulário
    $user_id = $_POST['user_id'];
    $name = $_POST["name"];
    $image = $_POST['image'];
    $about = $_POST["about"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];


     // Usar prepared statements para proteger contra SQL injection
     $name = mysqli_real_escape_string($connection, $name);
     $email = mysqli_real_escape_string($connection, $email);
     $password = mysqli_real_escape_string($connection, $password);
     $password_confirm = mysqli_real_escape_string($connection, $password_confirm);
     $about = mysqli_real_escape_string($connection, $about);
     $image = mysqli_real_escape_string($connection, $image);

     $password_hashed = password_hash($password, PASSWORD_DEFAULT);



     //verificar se a imagem nova foi enviada

     if($_FILES['image']['size'] > 0 ){

        //processar o upload da nova imagem 
        $targetDir = "../../src/img/edit_profile"; //substituir pelo diretorio correto
        $randomName = uniqid() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $randomName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

     }

       // Verificar se ocorreu algum erro durante o upload
       if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = 'Erro no upload da imagem.';
        $_SESSION['message_type'] = 'danger';
    } else {
        // Se tudo estiver ok, tentar fazer o upload
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image_path = "src/img/receitas" . basename($_FILES["image"]["name"]);
            // Atualizar os dados do post no banco de dados
            $query = "UPDATE users SET id = '$user_id', email = '$email', password = '$password_hashed', about, '$about',  WHERE id = '$user_id'";
            if (mysqli_query($connection, $query)) {
                $_SESSION['message'] = 'Post editado com sucesso.';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Erro ao editar o post.';
                $_SESSION['message_type'] = 'danger';
            }
        } else {
            $_SESSION['message'] = 'Erro ao fazer upload da imagem.';
            $_SESSION['message_type'] = 'danger';
        }
    }



















}    





?>