<ul style="
    margin: 0;
    padding-left: 0;
    list-style: none;">
    <?php foreach ($navs as $nav) {
        list($text, $url, $title) = $nav;
        echo '<li><a href="' . $url . '" title="' . $title . '">' . $text . '</a></li>';
    } ?>
</ul>
