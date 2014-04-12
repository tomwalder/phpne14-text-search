<?php
/**
 * Demo UI for PHPNE Full Text Demo
 *
 * @author Tom Walder <tom@docnet.nu>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Search object
    require_once('../src/Search.php');
    $obj_search = new Search();

    // Execute Query
    if(isset($_POST['search'])) {
        $obj_search_results = $obj_search->query($_POST['search']);
    }

    // Create Document
    if(isset($_POST['title'])) {
        $obj_create_result = $obj_search->createDoc($_POST['title'], $_POST['content']);
    }

}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="PHPNE GAE Full Text Search Demo">
        <meta name="author" content="Tom Walder">
        <title>PHPNE14 Full Text Demo</title>
        <link href="/bootstrap.min.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1>PHPNE14: Google App Engine Full Text Search</h1>
                    <p>PHP with a dash of Python can get you access to Google Full Text Search API.</p>

                </div>
            </div>

            <div class="row">

                <div class="col-xs-12 col-md-9">
                    <h3>Search</h3>
                    <form role="form" method="POST" action="/" id="form-search">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary" type="button">Go</button>
                            </span>
                        </div>
                    </form>
                    <br />
                    <div id="search-results">
                        <?php
                            if(isset($obj_search_results)) {
                                echo '<pre>' . print_r($obj_search_results, TRUE) . '</pre>';
                            }
                        ?>
                    </div>
                    <blockquote>Please excuse the crudity of this model. I didn't have time to build it to (web)scale or paint it.</blockquote>
                </div>

                <div class="col-xs-12 col-md-3">
                    <h3>Create Document</h3>
                    <form role="form" method="POST" action="/" id="form-create">
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="content" name="content" rows="3" placeholder="Content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Create</button>
                    </form>
                    <br />
                    <div id="create-result">
                        <?php
                            if(isset($obj_create_result)) {
                                echo '<pre>' . print_r($obj_create_result, TRUE) . '</pre>';
                            }
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <script>
            (function(l,o,a,d,r){
                d=l.getElementsByTagName(o)[0],r=l.createElement(o);
                r.async=1;r.src=a;d.parentNode.insertBefore(r,d);
            })(document,'script','/search.js');
        </script>
    </body>
</html>