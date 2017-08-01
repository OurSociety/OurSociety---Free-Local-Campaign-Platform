<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class PoliticianArticlesFixture extends TestFixture
{
    const BODY_PARAGRAPH = <<<HTML
<p>
    Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit
    nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa
    neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc
    mattis convallis.
</p>

HTML;
    const PUBLISHED_AND_APPROVED_ID = 'approved_and_published';
    const PUBLISHED_AND_APPROVED_SLUG = 'the-long-road-ahead';
    const UNPUBLISHED_ID = 'unpublished';
    const UNAPPROVED_ID = 'unapproved';

    public $import = ['table' => 'politician_articles', 'connection' => 'fixtures'];
}
