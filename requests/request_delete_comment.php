<?php 

session_start();

if(!isset($_SESSION['user_id'])){
    header('Location; ../login.php');
}


include_once ('../helpers/database.php');

$connection = connectDatabase();

$comment_id = $_GET['comment_id'];
$post_id = $_GET['post_id'];

$query = "DELETE FROM comments WHERE id = '$comment_id'";


if(mysqli_query($connection, $query)){
    $_SESSION['message'] = "Seu comentario foi deletado com sucesso";
    $_SESSION['message_type'] = "success";
    header("Location: ../post.php?post_id=$post_id");
}else{
    $_SESSION['message'] = "Ocorreu um erro ao deletar seu comentario";
    $_SESSION['message_type'] = "danger";
    header("Location: ./post.php?post_id=$post_id");
}





?>