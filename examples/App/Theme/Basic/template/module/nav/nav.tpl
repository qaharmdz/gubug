<ul class="main-nav">
    <?php foreach ($navs as $nav) {
        list($text, $url, $title) = $nav;
        echo '<li><a href="' . $url . '" title="' . $title . '">' . $text . '</a></li>';
    } ?>
</ul>
