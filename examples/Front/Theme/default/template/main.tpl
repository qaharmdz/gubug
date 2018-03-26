<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageInfo['title']; ?></title>
    <base href="<?php echo $baseURL; ?>">

    <link rel="stylesheet" href="front/theme/default/css/normalize.css">
    <link rel="stylesheet" href="front/theme/default/css/style.css">
</head>

<body class="<?php echo $pageInfo['body_class']; ?>">
    <div class="container">
        <div class="wrapper">
            <div class="header">
                <div class="site-name">
                    <a href="<?php echo $url_home; ?>">
                        Gubug
                    </a>
                </div>
                <div class="tagline">An experimental <br>PHP micro framework</div>

                <?php echo $nav; ?>
            </div>

            <div class="content">
                <div class="main">
                    <?php echo $component; ?>
                </div>
                <div class="sidebar">
                    <?php foreach ($modules as $module) { ?>
                    <?php if ($module) { ?>
                        <div class="module">
                            <?php echo $module; ?>
                        </div>
                    <?php } ?>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
