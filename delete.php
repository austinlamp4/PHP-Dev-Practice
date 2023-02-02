<?php
    require('config/config.php');
    require('config/db.php');
    $msg = '';
    $msgClass = '';

    //Checking to see if the button was clicked.
    if(isset($_POST["delete"]) && (isset($_POST["delete_id"]) && $_POST["delete_id"] != '')) {
        $delete_id = mysqli_real_escape_string($conn, htmlentities(filter_var($_POST["update_id"], FILTER_SANITIZE_SPECIAL_CHARS)));
        $query = "DELETE FROM posts WHERE id='$delete_id'"; //Since we're updating, we should use UPDATE not INSERT.

        if(mysqli_query($conn, $query)) {
            //If the query is successful, this code runs.
            header('Location:'.ROOT_URL.'');
        } else {
            $msg = 'Error. Unable to insert data due to '. mysql_error($conn);
            $msgClass = "alert-danger";
        }
    } else {
        $msg = 'Please fill in all fields';
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
        <?php if($msg != ''): ?>
            <div class="alert <?php echo $msgClass; ?>"> <!-- This uses bootstrap to display a color - but it also keeps it dynamic based on whether input is there or not -->
                <?php echo $msg ?>
            </div>
        <?php endif; ?>
        <h1>Add Post</h1>
        <form method="POST" action="<?php $_SERVER['PHP_SELF'];?>">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $post["title"] ?>">
            </div>
            <div class="form-group">
                <label>Author</label>
                <input type="text" name="author" class="form-control" value="<?php echo $post["author"] ?>">
            </div>
            <div class="form-group">
                <label>Body</label>
                <textarea type="text" name="body" class="form-control" value="<?php echo $post["body"] ?>"></textarea>
            </div>
            <input type="hidden" name="update_id" value="<?php echo $post["id"] ?>">
            <input type="submit" name="submit" Value="Submit" class="btn btn-primary">
        </form>
    </div>
<?php include("inc/footer.php"); ?>
