<?php
/**
 * @var string[] $channel
 * @var \OurSociety\View\AppView $this
 */
if ($channel === null):
    $channel = [];
endif;
if (!isset($channel['title'])):
    $channel['title'] = $this->fetch('title');
endif;

echo $this->Rss->document(
    $this->Rss->channel(
        [], $channel, $this->fetch('content')
    )
);
