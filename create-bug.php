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
                                <a href="bugs.php?pid=<?php echo $_GET['pid'] ?>" class="btn-flat btn-bg-black">
                                    <i class="mdi mdi-arrow-left mdi-36px" aria-hidden="true"></i>
                                </a>
                                <p class="content-header-title">
                                    CREATE BUG
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
                            <form role="form" action="create-bug-process.php?pid=<?php echo $_GET['pid']; ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Bug Name</label>
                                    <input class="form-control" required="true" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Bug Decription</label>
                                    <textarea class="form-control" rows="10" required="true" name="desc"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Link</label>
                                    <textarea class="form-control" rows="3" name="link"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Screenshot - <span style="font-weight: 500;">Max size 4 MB and should be PNG or JPG or GIF</span></label>
                                    <input type="file" name="photo" class="input-file uniform_on">
                                </div>
                                <button type="submit" class="btn-flat btn-card-success">
                                    CREATE
                                </button>
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