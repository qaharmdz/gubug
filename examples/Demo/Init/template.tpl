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
    padding: 30px 40px;
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

            <div style="text-align:center; padding: 50px; margin:-30px -40px 40px -40px; background:#ddd; ">
                <h1 style="margin:0">Site Header</h1>
            </div>

            <div><?php echo $component; ?></div>

        </div>
    </div>
</body>
</html>
