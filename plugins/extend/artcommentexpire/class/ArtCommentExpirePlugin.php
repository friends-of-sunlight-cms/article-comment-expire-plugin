<?php

namespace SunlightExtend\Artcommentexpire;

use Sunlight\Database\Database as DB;
use Sunlight\Message;
use Sunlight\Plugin\ExtendPlugin;
use Sunlight\Post\Post;

class ArtCommentExpirePlugin extends ExtendPlugin
{
    /**
     * Callback to deactivate a comment
     */
    public function onDisable(array $args): void
    {
        // do nothing if the comments are already deactivated or locked
        if ($args['article']['comments'] == 0 || $args['article']['commentslocked'] == 1) return;

        // find out if comments need to be locked
        if ($args['article']['time'] + $this->getConfig()->offsetGet('expire') < time()) {
            // to lock
            $args['article']['commentslocked'] = 1;
            $args['article']['_acommentexpire_used'] = true; // indikator pro hlasku
        }
    }

    /**
     * Callback to display message
     */
    public function onMessage(array $args): void
    {
        // conditional message
        if (isset($args['article']['_acommentexpire_used'])) {
            $args['output'] .= '<br><br>' . Message::ok(_lang('artcommentexpire.message', ['%days%' => intval($this->getConfig()->offsetGet('expire') / 86400)]));
        }
    }

    /**
     * Callback to avoid saving the post
     */
    public function onSubmit(array $args): void
    {
        if ($args['posttype'] == Post::ARTICLE_COMMENT) {

            // get article time
            $data = DB::queryRow("SELECT `time` FROM " . DB::table('article') . " WHERE id=" . (int)$args['posttarget']);

            if ($data !== false) {
                // prohibit?
                if (($data['time'] + $this->getConfig()->offsetGet('expire')) < time()) {
                    $args['allow'] = false;
                }
            }
        }
    }
}
