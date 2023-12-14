<?php
$pageInfo = array(
    'title' => 'Meu Perfil',
    'description' => 'Visualize e gerencie suas informações de perfil.',
    'pageName' => 'profile',
);

include_once('../components/admin/header.php');

// incluir a conexão do banco de dados 

$connection = connectDatabase();

// verificar se o usuario em questão está logado 

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];


$query = "SELECT
 name as user_name,
 email as user_email,
 about as user_about,
 image as user_image
FROM users
WHERE id = '$user_id'";

$result = mysqli_query($connection, $query);

if($result && mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $name = $row ['user_name'];
    $email = $row ['user_email'];
    $about = $row ['user_about'];
    $image = $row ['user_image'];   
}else{
    header('Location: ../404.php');
    exit();
} 

}else{
    header('Location: ../login.php');
    exit();
}




?>

<!-- Conteúdo da página de perfil -->
<main class="container py-5">
    <div class="row">
        <!-- Informações do perfil -->
        <section class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <img src="<?php echo $image?>"
                        alt="Foto de Perfil" class="img-fluid mb-3">
                    <h5>
                        <?php echo $name?>
                    </h5>
                    <p>
                    <?php echo $about?>
                    </p>
                    <p>Email: <?php echo $email?></p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <form action="">
                    <div class="form-group">
                            <label for="image">Foto de Perfil</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" value="<?php echo $name ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Endereço de Email</label>
                            <input type="email" class="form-control" id="email"
                                value="<?php echo $email ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password"
                                value="password">
                        </div>
                        <div class="form-group">
                            <label for="password">Nova Senha</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Publicações e Comentários -->
        <section class="col-md-8">
    <div class="card">
        <div class="card-body">
            <!-- Tabs para Comentários e Curtidas -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="comentarios-tab" data-toggle="tab" data-target="#comentarios" type="button"
                        role="tab" aria-controls="comentarios" aria-selected="true">
                        Meus Comentários
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="curtidas-tab" data-toggle="tab" data-target="#curtidas" type="button"
                        role="tab" aria-controls="curtidas" aria-selected="false">
                        Minhas Curtidas
                    </button>
                </li>
            </ul>

            <!-- Conteúdo das Tabs -->
            <div class="tab-content" id="myTabContent">
                <!-- Tab de Comentários -->
                <div class="tab-pane fade show active" id="comentarios" role="tabpanel" aria-labelledby="comentarios-tab">
                    <!-- Exemplo de Comentários -->
                    <div class="media mb-3">
                        <img src="path/to/fake-profile-image.jpg" class="mr-3 rounded-circle" alt="Foto de Perfil">
                        <div class="media-body">
                            <h5 class="mt-0">Usuário Exemplo</h5>
                            <p>Comentário exemplo 1. <i class="far fa-thumbs-up"></i> 5 curtidas</p>
                        </div>
                    </div>

                    <div class="media">
                        <img src="path/to/fake-profile-image.jpg" class="mr-3 rounded-circle" alt="Foto de Perfil">
                        <div class="media-body">
                            <h5 class="mt-0">Outro Usuário</h5>
                            <p>Comentário exemplo 2. <i class="far fa-thumbs-up"></i> 10 curtidas</p>
                        </div>
                    </div>
                </div>

                <!-- Tab de Curtidas -->
                <div class="tab-pane fade" id="curtidas" role="tabpanel" aria-labelledby="curtidas-tab">
                    <!-- Exemplo de Curtidas -->
                    <div class="media mb-3">
                        <img src="path/to/fake-profile-image.jpg" class="mr-3 rounded-circle" alt="Foto de Perfil">
                        <div class="media-body">
                            <h5 class="mt-0">Usuário Exemplo</h5>
                            <p>Curtiu a publicação: Título da Publicação 1</p>
                        </div>
                    </div>

                    <div class="media">
                        <img src="path/to/fake-profile-image.jpg" class="mr-3 rounded-circle" alt="Foto de Perfil">
                        <div class="media-body">
                            <h5 class="mt-0">Outro Usuário</h5>
                            <p>Curtiu a publicação: Título da Publicação 2</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    </div>
</main>

<?php
$currentPage = 'index';
include_once('../components/admin/footer.php');
?>