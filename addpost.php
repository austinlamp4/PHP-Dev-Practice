<?php
    require('config/config.php');
    require('config/db.php');
    $msg = '';
    $msgClass = '';

    function sanitize_input($conn) {
        //Now we need to make sure that every other value is set:
        if((isset($_POST["title"]) && $_POST["title"] != '') && (isset($_POST["author"]) && $_POST["author"] != '') && (isset($_POST["body"]) && $_POST["body"] != '')) {
            $title = htmlentities(filter_var($_POST["title"], FILTER_SANITIZE_SPECIAL_CHARS));
            $author = htmlentities(filter_var($_POST["author"], FILTER_SANITIZE_SPECIAL_CHARS));
            $body = htmlentities(filter_var($_POST["body"], FILTER_SANITIZE_SPECIAL_CHARS));
            $data = array("title" => $title, "author" => $author, "body" => $body);
            mysqli_real_escape_string($conn, $data["title"]); //Input validation for MySQL to prevent SQL injections.
            mysqli_real_escape_string($conn, $data["author"]);
            mysqli_real_escape_string($conn, $data["body"]);
            return $data;
        } else {
            $msg = 'Please fill in all fields';
            $msgClass = "alert-danger";
        }
    }

    //Checking to see if the button was clicked.
    if(isset($_POST["submit"])) {
        $data = sanitize_input($conn);
        $title = $data["title"];
        $author = $data["author"];
        $body = $data["body"];
        $query = "INSERT INTO posts(title, author, body) VALUES ('$title', '$author', '$body')";

        if(mysqli_query($conn, $query)) {
            //If the query is successful, this code runs.
            header('Location:'.ROOT_URL.'');
        } else {
            $msg = 'Error. Unable to insert data due to '. mysql_error($conn);
            $msgClass = "alert-danger";
        }
    }
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
                <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label>Author</label>
                <input type="text" name="author" class="form-control">
            </div>
            <div class="form-group">
                <label>Body</label>
                <textarea type="text" name="body" class="form-control"></textarea>
            </div>
            <input type="submit" name="submit" Value="Submit" class="btn btn-primary">
        </form>
    </div>
<?php include("inc/footer.php"); ?>
