<?php
session_start();

include_once ('../../helpers/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];



    // configuração para upload do arquivo

    $targetDir = "../../src/img/receitas/";
    $randonName = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $randonName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // validação da imagem

    if(!getimagesize($_FILES['image']['tmp_name']) || file_exists($targetFile)|| $_FILES['image']['size'] > 500000){
        echo $_SESSION['message'] = "Desculpe, sua imagem de ter no máximo 5MB.";
        $_SESSION['message_type'] = "danger";
        $uploadOk = 0;
        header("Location:../create_post.php");
    }

    if($uploadOk == 1 && move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
        //conecta no banco de dados
        $connection = connectDatabase();

        

    // Usar prepared statements para proteger contra SQL injection
    $title = mysqli_real_escape_string($connection, $title);
    $content = mysqli_real_escape_string($connection, $content);



        //obtem o id do usuario
        $user_id = $_SESSION ['user_id'];


        $image = "src/img/receitas/" . $randonName;

        $query = "INSERT INTO posts (user_id, title, content, image, views) VALUES ('$user_id', '$title', '$content', '$image', 0)";
 
    if(mysqli_query($connection, $query)) {
       echo $_SESSION['message'] ='Post cadastrado';
       $_SESSION['message_type'] = "success";
       header("Location:../posts.php");
    }else{
        echo $_SESSION['message'] = "Ocorreu um erro ao cadastrar sua postagem";
        $_SESSION['message_type'] = "danger";
        header("Location:../create_post.php");
    }   
}
}