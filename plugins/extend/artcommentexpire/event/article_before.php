<?php

return function (array $args) {
    // do nothing if the comments are already deactivated or locked
    if ($args['article']['comments'] == 0 || $args['article']['commentslocked'] == 1) {
        return;
    }

    // find out if comments need to be locked
    if ($args['article']['time'] + $this->getConfig()['expire'] < time()) {
        // to lock
        $args['article']['commentslocked'] = 1;
        $args['article']['_acommentexpire_used'] = true; // indicator for the message
    }
};
