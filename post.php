<?php
    /*
    Author: Austin Lamp
    Date: 02/01/2023
    Purpose: Fetch a SINGLE Post after a user clicks on the "Read More" link in index.php
    */
    require('config/config.php');
    require('config/db.php');

    $msg = '';
    $msgClass = '';

    /*
    The below if statement is a delete button functionality that takes the id of the post that you are currently on and uses it
    to delete the post.
    If an error occurs, or someone does something weird, it will throw an error.
    */
    if(isset($_POST["delete"]) && (isset($_POST["delete_id"]) && $_POST["delete_id"] != '')) {
        $delete_id = mysqli_real_escape_string($conn, htmlentities(filter_var($_POST["delete_id"], FILTER_SANITIZE_SPECIAL_CHARS)));
        $query = "DELETE FROM posts WHERE id='$delete_id'";

        if(mysqli_query($conn, $query)) {
            header('Location:'.ROOT_URL.'');
        } else {
            $msg = 'Error. Unable to insert data due to '. mysql_error($conn);
            $msgClass = "alert-danger";
        }
    } else {
        $msg = 'Please don\'t submit empty id\'s';
        $msgClass = "alert-danger";
    }

    $id = mysqli_real_escape_string($conn, $_GET['id']); //The mysqli_real_escape_string will prevent SQL injections.

    $query = 'SELECT * FROM posts WHERE id=' . $id;

    //Get results from the query:
    $result = mysqli_query($conn, $query);

    //Fetch data: just one piece.
    $post = mysqli_fetch_assoc($result); 

    //Free result:
    mysqli_free_result($result);

    //Close connection:
    mysqli_close($conn);
?>

<?php include("inc/header.php"); ?>
    <div class="container">
        <a href="<?php echo ROOT_URL; ?>" class="btn btn-default">Back</a>
        <h1>Post</h1>
            <div class="card text-white bg-primary mb-3" style="max-width: 20rem;">
                <div class="card-header">Created on <?php echo $post['created_at']; ?> by <?php echo $post['author']; ?></div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $post['title']; ?></h4>
                    <p class="card-text"><?php echo $post['body'] ?></p>
                    <hr>
                    <a href="<?php echo ROOT_URL; ?>editpost.php?id=<?php echo $post['id'];?>" class="btn btn-default">Edit Post</a>
                    <form class="pull-right" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <input type="hidden" name="delete_id" value="<?php echo $post['id']; ?>">
                        <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                    </form>
                </div>
            </div>
    </div>
<?php include("inc/footer.php"); ?>