<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gubug</title>

<style>
*, :after, :before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
html {
    background: #f4f4f4;
    font-family: Arial;
    font-size: 15px;
    line-height: 1.5;
}
html, body {
    margin: 0;
    padding: 0;
    min-width: 600px;
}
.wrapper {
    padding: 0 15px;
    position: relative;
}
.content {
    background: #fff;
    margin: 50px auto;
    max-width: 900px;
    padding: 30px 40px 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,.5);
}
h1 {
    font-size: 28px;
    margin: 0 0 30px;
}
pre {
    background: #fbfbfb;
    padding:8px 16px;
    margin-left: 25px;
    margin-bottom:40px;
    box-shadow: inset 0 0 5px rgba(0,0,0,.2);
}
pre code {
    background: transparent;
    padding: 0;
}
code {
    font-size: 13px;
    background: #eee;
    padding: 2px 5px;
}
ul {
    margin: 30px 0 40px;
}
</style>
</head>

<body>
    <div class="wrapper">
        <div class="content">
            <h1><?php echo $title; ?></h1>

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

        </div>
    </div>
</body>
</html>
