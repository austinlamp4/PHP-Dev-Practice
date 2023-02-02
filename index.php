<?php
    require('config/config.php');
    require('config/db.php');

    $query = 'SELECT * FROM posts ORDER BY created_at DESC'; //Display posts in order which they were created.

    //Get results from the query:
    $result = mysqli_query($conn, $query);

    //var_dump($result);
    //echo "<br><br>";

    //Fetch data:
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC); //Second parameter determines what is returned. In this case, associative array.

    //var_dump($posts);


    //Free result:
    mysqli_free_result($result);

    //Close connection:
    mysqli_close($conn);
?>

<?php include("inc/header.php"); ?>
    <div class="container">
        <h1>Posts</h1>
        <?php foreach($posts as $post) : ?>
            <div class="card text-white bg-primary mb-3" style="max-width: 20rem;">
                <div class="card-header">Created on <?php echo $post['created_at']; ?> by <?php echo $post['author']; ?></div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $post['title']; ?></h4>
                    <p class="card-text"><?php echo $post['body'] ?></p>
                    <a class="btn btn-default" href="<?php echo ROOT_URL;?>post.php?id=<?php echo $post['id']; ?>">Read more</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php include("inc/footer.php"); ?>
