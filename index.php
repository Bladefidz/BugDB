<?php
    require_once("lib/session.php");
    require_once("lib/mysqli.php");

    // Beta
    session_start();
    $_SESSION["uid"] = "1";
    $_SESSION["uname"] = "beta";

    $mysqli = get_mysqli_instance();

    $sql = "
        SELECT p.id as pid, u.id as uid, p.name as pname, u.username as uname 
        FROM project as p 
        LEFT JOIN user as u ON(p.creator_id = u.id)";
    $result = $mysqli->query($sql);
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
                                <button class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-menu mdi-36px" aria-hidden="true"></i>
                                </button>
                                <p class="content-header-title">
                                    BUGDB
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
                        <div class="content-nav">
                            <div class="content-nav-text">
                                
                            </div>
                            <div class="content-nav-btn">
                                <a href="create-project.php" class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-plus mdi-24px" aria-hidden="true"></i>
                                </a>
                                <button class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-sort-ascending mdi-24px" aria-hidden="true"></i>
                                </button>
                                <button class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-sort-descending mdi-24px" aria-hidden="true"></i>
                                </button>
                                <button class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-magnify mdi-24px" aria-hidden="true"></i>
                                </button>
                                <button class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-autorenew mdi-24px" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="content-body">
                            <div class="listview-container">
                    <?php
                        if ($result->num_rows > 0):
                    ?>
                        <?php
                            while($row = $result->fetch_assoc()):
                        ?>
                                <a href="bugs.php?pid=<?php echo $row['pid']; ?>" id="listview-item-<?php echo $row['pid']; ?>" class="listview-item listview-item-active">
                                    <div class="listview-project-name" style="width: 80%">
                                        <p><?php echo $row["pname"] ?></p>
                                        <p class="text-muted">created by <em><?php echo $row["uname"] ?></em></p>
                                    </div>
                                    <div class="listview-project-btn" style="width: 20%">
                                        <button type="button" class="btn btn-outline btn-primary btn-xs">
                                            <i class="mdi mdi-bug mdi-14px" aria-hidden="true"></i>
                                        <?php
                                            $sql_bug_count = "
                                                SELECT COUNT(id) as count
                                                FROM bug
                                                WHERE project_id={$row['pid']}";
                                            $bugs = $mysqli->query($sql_bug_count);
                                            echo $bugs->fetch_assoc()['count'];
                                            $bugs->free();
                                        ?>
                                        </button>
                                        <button type="button" class="btn btn-outline btn-primary btn-xs">
                                            <i class="mdi mdi-account-network mdi-14px" aria-hidden="true"></i>
                                            30
                                        </button>
                                    </div>
                                </a>
                        <?php
                            endwhile;
                        ?>
                    <?php 
                        else:
                    ?>
                        <h2><center>No project found here.</center></h2>
                    <?php 
                        endif;
                    ?>
                    <?php
                        $result->free();
                        $mysqli->close();
                    ?>
                            </div>
                            <button class="btn-flat btn-card-loader">
                                LOAD MORE
                            </button>
                        </div>
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