<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Traits;

trait FixturesTrait
{
    public $fixtures = [
        'app.answers',
        'app.categories',
        'app.categories_users',
        'app.politician_articles',
        'app.politician_awards',
        'app.politician_positions',
        'app.politician_qualifications',
        'app.politician_videos',
        'app.questions',
        'app.users',
    ];
}
