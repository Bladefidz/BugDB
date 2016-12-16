<?php
require_once("lib/session.php");
require_once("lib/mysqli.php");

$mysqli = get_mysqli_instance();

if (isset($_GET['updatestatus']) && isset($_GET['bid']) && isset($_GET['pid'])) {
    $timestamp = date('Y-m-d H:i:s');
    $sql = "UPDATE bug 
    SET status={$_GET['updatestatus']},
        resolved_at='{$timestamp}' 
    WHERE id={$_GET['bid']}";

    if ($mysqli->query($sql) === FALSE) {
        die("Error updating record: " . $mysqli->error);
    }
}


$sql = <<<SQL
    SELECT p.name as pname, b.id as bid, b.title as btitle, b.description as bdesc, b.status as bstatus, b.link as blink, b.photo as bphoto, b.reported_at as breported_at, b.resolved_at as bresolved_at, u.id as uid, u.username as uname 
    FROM bug as b 
    LEFT JOIN user as u ON(b.user_id = u.id)
    LEFT JOIN project as p ON(b.project_id = p.id)
SQL;

if (isset($_GET['bid'])) {
    $sql .= <<<SQL
    WHERE b.id = "{$_GET['bid']}"
SQL;
} else {
    die("You forgot bid parameter");
}

$result = $mysqli->query($sql);
$result_set = collect_query_result($result, "assoc", 1);

$sql_clue = <<<SQL
    SELECT bc.clue as clue, u.username as username, u.id as uid 
    FROM bug_clue as bc 
    LEFT JOIN user as u ON(bc.user_id = u.id) 
    WHERE bc.bug_id = "{$_GET['bid']}"
SQL;
$clues = $mysqli->query($sql_clue);
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
                                <a href="bugs.php?pid=<?php echo $_GET['pid']; ?>" class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-arrow-left mdi-36px" aria-hidden="true"></i>
                                </a>
                                <p class="content-header-title">
                                    BUG
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
                            <div class="content-nav-text" style="width: 80%">
                                <?php echo $result_set[0]['btitle'] ?>
                            </div>
                            <div class="content-nav-btn" style="width: 20%">
                                <button id="give-clue" class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-tooltip-outline-plus mdi-24px" aria-hidden="true"></i>
                                </button>
                                <a href="edit-bug.php?pid=<?php echo $_GET['pid']; ?>&bid=<?php echo $_GET['bid']; ?>" class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-wrench mdi-24px" aria-hidden="true"></i>
                                </a>
                                <button id="contribute" class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-star-outline mdi-24px" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="content-body">
                            <div id="card" class="card-oulined card-new">
                                <div class="card-clip">
                                    <?php echo date("d M Y", strtotime($result_set[0]['breported_at'])); ?>
                                    <?php echo date("G:i", strtotime($result_set[0]['breported_at'])); ?>
                                </div>
                                <div class="card-text" style="width: 100%">
                                    <div class="card-text-section">
                                        <p class="card-text-title" style="font-size: 12px">
                                            Description
                                        </p>
                                        <p>
                                    <?php
                                        echo $result_set[0]['bdesc'];
                                    ?>
                                        </p>
                                    </div>
                                    <div class="card-text-section">
                                        <p class="card-text-title" style="font-size: 12px">
                                            Code Links
                                        </p>
                                        <p>
                                    <?php
                                        echo $result_set[0]['blink'];
                                    ?>
                                        </p>
                                    </div>
                                    <div class="card-text-section">
                                        <p class="card-text-title" style="font-size: 12px">
                                            Photo
                                        </p>
                                    <?php
                                        if (!empty($result_set[0]['bphoto'])):
                                    ?>
                                        <img class="card-thumb" src="<?php echo "images/{$result_set[0]['bphoto']}"; ?>">
                                        </img>
                                    <?php
                                        else:
                                    ?>
                                        <p>No photo provided.</p>
                                    <?php endif; ?>
                                    </div>
                                    <div class="card-text-section" style="padding-bottom: 0px">
                                        <p class="card-text-title" style="font-size: 12px">
                                            Clue
                                        </p>
                                <?php
                                    if ($clues->num_rows > 0):
                                ?>
                                    <?php
                                        while ($clue = $clues->fetch_assoc()):
                                    ?>
                                        <p>
                                        <?php
                                            if ($_SESSION['uid'] == $clue['uid']):
                                        ?>
                                            <label>
                                                Me:
                                            </label>
                                        <?php
                                            else:
                                        ?>
                                            <label>
                                                <?php echo $clue['username'] ?>:
                                            </label>
                                        <?php
                                            endif;
                                        ?>
                                            <span>
                                                <?php echo $clue['clue'] ?>
                                            </span>
                                        </p>
                                    <?php
                                        endwhile;
                                    ?>
                                <?php
                                    else:
                                ?>
                                        <p>No clues here.</p>
                                <?php
                                    endif;
                                ?>
                                    </div>
                                </div>
                            </div>
                    <?php
                        if ($result_set[0]['uid'] == $_SESSION["uid"]):
                    ?>
                        <?php
                            if ($result_set[0]['bstatus'] == 11) :
                        ?>
                            <a class="btn btn-flat btn-card-success" href="bug.php?bid=<?php echo $_GET['bid'] ?>&pid=<?php echo $_GET['pid'] ?>&updatestatus=22" style="padding: 10px; font-size: 22px">
                                SOLVED !
                            </a>
                        <?php
                            else:
                        ?>
                            <button class="btn-flat btn-card-loader">
                                <?php echo "Solved @ {$result_set[0]['bresolved_at']}" ?>
                            </button>
                        <?php
                            endif;
                        ?>
                    <?php
                        else:
                    ?>
                            <button class="btn-flat btn-card-outlined">
                                Help
                            </button>
                    <?php
                        endif;
                    ?>
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