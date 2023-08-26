<?php

use Sunlight\Database\Database as DB;
use Sunlight\Post\Post;

return function (array $args) {
    if ($args['posttype'] == Post::ARTICLE_COMMENT) {

        // get article time
        $data = DB::queryRow("SELECT `time` FROM " . DB::table('article') . " WHERE id=" . (int)$args['posttarget']);

        if ($data !== false) {
            // prohibit?
            if (($data['time'] + $this->getConfig()['expire']) < time()) {
                $args['allow'] = false;
            }
        }
    }
};
