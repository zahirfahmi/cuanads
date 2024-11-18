<?php
function reading_time($ID)
{
    $content = get_post_field('post_content', $ID);
    $word_count = str_word_count(strip_tags($content));
    $readingtime = ceil($word_count / 200);

    if ($readingtime == 1) {
        $timer = " min";
    } else {
        $timer = " mins";
    }
    $totalreadingtime = $readingtime . $timer;

    return $totalreadingtime;
}
