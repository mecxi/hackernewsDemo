<?php

/* comment tree-view rendering */
function format_tree_view($collection) {
//    echo '<pre>'. print_r($collection, true).'</pre>';
//    die();
    $title_desc = '';
    if (isset($collection['id'])){
        /* check for child replies to render caret icon */
        $child_title_desc = '';
        $has_childReplies = has_childReplies($collection['replies']);
        if ($has_childReplies){
            /* get child replies */
            foreach($collection['replies'] as $collet){
                $child_title_desc = format_tree_view($collet);
            }
            $title_desc = "<li><span class='caret'>by ${collection['by']} posted ${collection['date']}</span>"
            . "<span class='caret-desc'>${collection['msg']}</span><ul class='nested'>${child_title_desc}</ul></li>";

        } else {
            $title_desc = "<li>by ${collection['by']} posted ${collection['date']}<span class='no-caret-desc'>${collection['msg']}</span></li>";
        }
    }
    return $title_desc;
}

/* check current collection has child replies */
function has_childReplies($replies) {
    return isset($replies[0]['id']) ? true : false;
}