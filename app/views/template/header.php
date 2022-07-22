<?php
// echo '<script type="text/javascript">document.cookie = "noScriptAlert=yes";</script>';

// if ($_COOKIE['noScriptAlert'] === 'yes') {
//     echo '<small style="position: fixed; left: 0px; top: 0px; z-index: 1;">Please disable Javascript. This web application is designed to work with JavaScript disabled for added security. Once JavaScript is disabled, you need to reload your browser twice (2x) to remove this notice.</small>';
//     setcookie('noScriptAlert', '');
// }
?>
<script>
    alert('Please disable Javascript. This web application is designed to work with JavaScript disabled for added security.');
</script>
<noscript>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=1">
        <meta name="description" content="BasicPHP Starter Application">
        <meta name="author" content="">
        <title>BasicPHP | <?= $page_title ?></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <!--     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script> -->
        <style>
            .drop-down {
                display: inline-block;
            }

            .drop-down-entry {
                display: none;
            }

            .drop-down:hover .drop-down-entry {
                display: block;
            }
        </style>
    </head>