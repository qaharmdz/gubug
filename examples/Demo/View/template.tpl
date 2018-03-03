<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gubug</title>
</head>

<body>
    <h2><?php echo $title; ?></h2>

    <ul>
        <li><a href="<?php echo $baseUri; ?>render"><?php echo $baseUri; ?>render</a></li>
        <li><a href="<?php echo $baseUri; ?>id/render"><?php echo $baseUri; ?>id/render</a></li>
        <li><a href="<?php echo $baseUri; ?>app/home/render"><?php echo $baseUri; ?>app/home/render</a></li>
        <li><a href="<?php echo $baseUri; ?>app/home/render/args/pair/key/val"><?php echo $baseUri; ?>app/home/render/args/pair/key/val</a></li>
        <li><a href="<?php echo $baseUri; ?>app/home/render/product/11/category/21_31"><?php echo $baseUri; ?>app/home/render/product/11/category/21_31</a></li>
        <li><a href='<?php echo $baseUri; ?>app/home/render/args/pair/unescape/v<b style="font-size:21px;color:red">alue'>Warning: Variables not escaped automatically</a></li>
    </ul>

    <?php
    if (!empty($param['arguments']['unescape'])) {
        echo 'Escaped: <code>' . htmlspecialchars($param['arguments']['unescape']) . '</code>';
    }
    ?>

    <p>Arguments passed to method:</p>
    <pre><code><?php print_r($param['arguments']); ?></code></pre>

    <p>All request attribute:</p>
    <pre><code><?php print_r($param['attributes']); ?></code></pre>
</body>
</html>
