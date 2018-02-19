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
    background: #f8f8f8;
    font-family: Arial;
    font-size: 15px;
    line-height: 1.5;
}
html, body {
    margin: 0;
    padding: 0;
}
.wrapper {
    padding: 0 30px;
}
.content {
    background: #fff;
    margin: 40px auto;
    max-width: 900px;
    padding: 20px 30px;
    box-shadow: 0 1px 3px rgba(0,0,0,.4);
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
code {
    font-size: 13px;
}
ul {
    margin: 30px 0 40px;
}
</style>
</head>
<?php echo $var; ?>

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

            <?php echo $param['arguments']['unescape'] ?? htmlspecialchars($param['arguments']['unescape']); ?>

            <p>Arguments passed to method:</p>
            <pre><code><?php print_r($param['arguments']); ?></code></pre>

            <p>All request attribute:</p>
            <pre><code><?php print_r($param['attributes']); ?></code></pre>

            <p>Extra service "Faker":</p>
            <pre><code><?php print_r($extraservice); ?></code></pre>
        </div>
    </div>
</body>
</html>