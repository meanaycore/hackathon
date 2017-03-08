<!doctype html>

<html lang="en">
<head>

    <title>{$pageTitle}</title>

    <meta http-equiv="content-type" content="text/html; charset=utf-8"></meta>

    {* Bootstrap CSS *}
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap-theme.min.css">

    {* App CSS *}
    <link rel="stylesheet" href="/app.css">

    {* jQuery + UI *}
    <script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/bower_components/jquery-ui/jquery-ui.min.js"></script>

    {* jQuery Validation *}
    <script type="text/javascript" src="/bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/bower_components/jquery-validation/dist/additional-methods.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>



</head>
<body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">TV Guide Mashup</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/">Home</a></li>
                    <li><a href="/movie">Top Rated Movies</a></li>
                    <li><a href="/series">Top Rated Series</a></li>
                    <li><a href="/channels">Channels</a></li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        {$content}
    </div>
</body>
</html>
