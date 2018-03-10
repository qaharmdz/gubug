<ul style="
    margin: 0;
    padding-left: 0;
    list-style: none;">
    <?php foreach ($navs as $nav) {
        echo '<li><a href="' . $nav[1] . '" title="' . $nav[2] . '">' . $nav[0] . '</a></li>';
    } ?>
</ul>
