<?php

use Cake\Filesystem\File;
use function GuzzleHttp\json_decode;

$manifest = json_decode((new File(WWW_ROOT . 'favicon-manifest.json'))->read(), true);
?>

<link rel="manifest" href="/manifest.json?v=YAoa4JeP9g">
<link rel="mask-icon" href="/safari-pinned-tab.svg?v=YAoa4JeP9g" color="#582c83">

<?php foreach ($manifest['html'] as $tag): ?>
    <?= str_replace('img/favicon/', $this->Url->assetUrl('img/favicon/'), $tag) . PHP_EOL ?>
<?php endforeach ?>
