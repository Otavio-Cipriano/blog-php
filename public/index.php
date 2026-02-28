<?php

require __DIR__ . '/../vendor/autoload.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Testing</title>
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/styles.css" rel="stylesheet">
</head>
<body>
<div class="container-sm"  style="max-width: 1240px; margin:  auto;">
    <?php include __DIR__ . '/../src/router.php'; ?>
</div>
<script src="/assets/bootstrap/js/bootstrap.min.js" ></script>
</body>
</html>
