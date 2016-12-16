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
                                    CREATE PROJECT
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
                            <form role="form" action="create-project-process.php" method="post">
                                <div class="form-group">
                                    <label>Project Name</label>
                                    <input class="form-control" required="true" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Project Decription</label>
                                    <textarea class="form-control" rows="3" required="true" name="desc"></textarea>
                                </div>
                                <button class="btn-flat btn-card-loader" type="submit">CREATE !</button>
                            </form>
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