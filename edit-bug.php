<?php
require_once("lib/session.php");
require_once("lib/mysqli.php");
require_once("lib/image.php");

if ($_SERVER['REQUEST_METHOD'] == "GET"
    && isset($_GET['pid']) 
    && isset($_GET['bid'])
) {
    $mysqli = get_mysqli_instance();
    $sql = <<<SQL
    SELECT p.name as pname, b.id as bid, b.title as btitle, b.description as bdesc, b.status as bstatus, b.link as blink, b.photo as bphoto, b.reported_at as breported_at, b.resolved_at as bresolved_at, u.id as uid, u.username as uname 
    FROM bug as b 
    LEFT JOIN user as u ON(b.user_id = u.id)
    LEFT JOIN project as p ON(b.project_id = p.id)
    WHERE b.id = "{$_GET['bid']}"
SQL;
    $bug = $mysqli->query($sql);

    if ($bug->num_rows <= 0) {
        die("Error updating record: " . $mysqli->error);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == "POST"
    && isset($_GET['pid']) 
    && isset($_GET['bid'])
) {
    $mysqli = get_mysqli_instance();

    if (upload_image($_FILES['photo'], "images")) {
        $sql = <<<SQL
            UPDATE bug 
            SET title="{$_POST['title']}", 
                description="{$_POST['desc']}", 
                link="{$_POST['link']}", 
                photo="{$_FILES['photo']['name']}"
            WHERE id={$_GET['bid']}
SQL;
    } else {
        $sql = <<<SQL
            UPDATE bug 
            SET title="{$_POST['title']}", 
                description="{$_POST['desc']}", 
                link="{$_POST['link']}"
            WHERE id={$_GET['bid']}
SQL;
    }

    if ($mysqli->query($sql) === TRUE) {
        $mysqli->close();
        header("Location: bugs.php?pid={$_GET['pid']}&bid={$_GET['bid']}");
    } else {
        die("Error updating record: " . $mysqli->error);
    }

} else {
    die("Wrong request.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bug Database</title>

    <!-- css -->
    <link rel="stylesheet" type="text/css" href="assets/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="assets/main/css/main.css" rel="stylesheet">
</head>
<body class="fixed-header-on">
    <div class="page-wrapper">
        <section class="light-gray-bg padding-bottom-clear clearfix">
            <div class="title-bar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="content-header">
                                <a href="bug.php?pid=<?php echo $_GET['pid'] ?>&bid=<?php echo $_GET['bid']; ?>" class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-arrow-left mdi-36px" aria-hidden="true"></i>
                                </a>
                                <p class="content-header-title">
                                    UPDATE BUG
                                </p>
                                <div class="content-header-nav-left">
                                    <button class="btn-flat btn-bg-black">
                                        <i class="mdi mdi-account mdi-36px" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="content-body">
                        <?php
                            $bug_data = $bug->fetch_assoc();
                        ?>
                            <form role="form" action="edit-bug.php?pid=<?php echo $_GET['pid']; ?>&bid=<?php echo $_GET['bid']; ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Bug Name</label>
                                    <input class="form-control" required="true" name="title" value="<?php echo $bug_data['btitle'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Bug Decription</label>
                                    <textarea class="form-control" rows="10" required="true" name="desc"><?php echo $bug_data['bdesc'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Link</label>
                                    <textarea class="form-control" rows="3" required="true" name="link"><?php echo $bug_data['blink'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Change Screenshot - <span style="font-weight: 500;">Max size 4 MB and should be PNG or JPG or GIF</span></label>
                                    <img class="card-thumb" src="<?php echo "images/{$bug_data['bphoto']}" ?>" style="padding-bottom: 10px"></img>
                                    <input type="file" name="photo" class="input-file uniform_on">
                                </div>
                                <button type="submit" class="btn-flat btn-card-success">
                                    UPDATE
                                </button>
                            </form>
                        </div>
                        <?php
                            $bug->free();
                            $mysqli->close();
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Javascript -->
    <script type="text/javascript" src="assets/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/main/js/main.js"></script>
</body>
</html>