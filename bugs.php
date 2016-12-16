<?php
    require_once("lib/session.php");
    require_once("lib/mysqli.php");

    $mysqli = get_mysqli_instance(); 
    

    $sql = <<<SQL
        SELECT p.name as pname, b.id as bid, b.title as btitle, b.description as bdesc, b.reported_at as breported_at, b.resolved_at as bresolved_at, b.status as bstatus , u.username as uname 
        FROM bug as b 
        LEFT JOIN user as u ON(b.user_id = u.id)
        LEFT JOIN project as p ON(b.project_id = p.id)
SQL;
    
    if (isset($_GET['pid'])) {
        $sql .= <<<SQL
        WHERE p.id = "{$_GET['pid']}"
SQL;
    }

    $result = $mysqli->query($sql);
    $result_set = collect_query_result($result, "assoc", 10);
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
                                <a href="index.php" class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-arrow-left mdi-36px" aria-hidden="true"></i>
                                </a>
                                <p class="content-header-title">
                                    BUGS
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
                            <?php
                                if ($result->num_rows > 0) {
                                    echo $result_set[0]['pname'];
                                } else {
                                    if (isset($_GET['pid'])) {
                                        $sql = <<<SQL
                                        SELECT name FROM project WHERE id="{$_GET['pid']}"
SQL;
                                        echo $mysqli->query($sql)->fetch_assoc()['name'];
                                    } else {
                                        echo "ALL PROJECT's BUG";
                                    }
                                }
                            ?>
                            </div>
                            <div class="content-nav-btn">
                                <a href="create-bug.php?pid=<?php echo $_GET['pid'] ?>" class="btn-flat btn-bg-black">
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
                            for ($i=0; $i < 10; $i++):
                        ?>
                            <?php
                                if ($result_set[$i] == NULL) {
                                    break;
                                }
                            ?>
                                <a href="<?php echo "bug.php?pid={$_GET['pid']}&bid={$result_set[$i]['bid']}" ?>" id="listview-item-<?php echo $result_set[$i]['bid'] ?>" class="listview-item listview-item-active">
                                    <div class="listview-project-name" style="width: 80%">
                                        <p><?php echo $result_set[$i]['btitle'] ?></p>
                                        <p class="text-muted">
                                        <?php
                                            if ($result_set[$i]['bstatus'] == '11'):
                                        ?>
                                            <u>reported</u> by <em><?php echo $result_set[$i]['uname'] ?></em> at <?php echo date("F, j Y H:i", strtotime($result_set[$i]['breported_at'])) ?>
                                        <?php 
                                            else:
                                        ?>
                                            <u>resolved</u> by <em><?php echo $result_set[$i]['uname'] ?></em> at <?php echo date("F, j Y H:i", strtotime($result_set[$i]['bresolved_at'])) ?>
                                        <?php
                                            endif;
                                        ?>
                                        </p>
                                    </div>
                                    <div class="listview-project-btn" style="width: 20%">
                                    <?php
                                        if ($result_set[$i]['bstatus'] == '11'):
                                    ?>
                                        <button type="button" class="btn btn-success btn-outline btn-xs">
                                            <i class="mdi mdi-check mdi-14px" aria-hidden="true"></i>
                                        </button>
                                    <?php
                                        else:
                                    ?>
                                        <button type="button" class="btn btn-success btn-xs">
                                            <i class="mdi mdi-check mdi-14px" aria-hidden="true"></i>
                                        </button>
                                    <?php
                                        endif;
                                    ?>
                                        <button type="button" class="btn btn-default btn-outline btn-xs">
                                            <i class="mdi mdi-message mdi-14px" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-outline btn-xs">
                                            <i class="mdi mdi-alert-circle-outline mdi-14px" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </a>
                        <?php
                            endfor;
                        ?>
                    <?php 
                        else:
                    ?>
                        <h2><center>No bug found here.</center></h2>
                    <?php 
                        endif;
                    ?>
                    <?php
                        $result->free();
                        $mysqli->close();
                        unset($result_set);
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