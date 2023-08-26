<?php

use Sunlight\Message;

return function (array $args) {
    // conditional message
    if (isset($args['article']['_acommentexpire_used'])) {
        $args['output'] .= '<br><br>' . Message::ok(_lang('artcommentexpire.message', ['%days%' => intval($this->getConfig()['expire'] / 86400)]));
    }
};
