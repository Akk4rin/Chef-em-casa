<?php 

session_start();

if(!isset($_SESSION['user_id'])){
    header('Location; ../login.php');
}


include_once ('../helpers/database.php');

$connection = connectDatabase();
   
   $post_id = $_POST['post_id'];
   $comment = $_POST['comment'];
   $user_id = $_SESSION['user_id'];

   $query = "INSERT INTO comments (content, user_id, post_id) VALUES ('$comment','$user_id','$post_id')";

   if(mysqli_query($connection, $query)){
       $_SESSION['message'] = "Seu comentario foi publicado com sucesso";
       $_SESSION['message_type'] = "success";
       header("Location: ../post.php?post_id=$post_id");
   }else{
       $_SESSION['message'] = "Ocorreu um erro ao cadastrar seu comentario";
       $_SESSION['message_type'] = "danger";
       header("Location: ./post.php?post_id=$post_id");
   }

?>