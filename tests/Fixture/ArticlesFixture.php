<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ArticlesFixture extends TestFixture
{
    const BODY_PARAGRAPH = <<<HTML
<p>
    Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit
    nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa
    neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc
    mattis convallis.
</p>

HTML;
    const PUBLISHED_AND_APPROVED_ID = '2c872874-7966-11e7-a115-6c4008a68a60';
    const PUBLISHED_AND_APPROVED_SLUG = 'the-long-road-ahead';
    const UNPUBLISHED_ID = '38913376-7966-11e7-8a5f-6c4008a68a60';
    const UNAPPROVED_ID = '41e53d64-7966-11e7-83b9-6c4008a68a60';

    public $import = ['table' => 'articles', 'connection' => 'fixtures'];
}
