<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 */

$fake = new joshtronic\LoremIpsum();
$iconNames = (new \Cake\Filesystem\Folder(ROOT . DS . 'assets' . DS . 'img' . DS . 'icon' . DS . 'topic'))->find('.*\.svg');
$pathway = (new \Cake\Http\Client)->get('https://randomuser.me/api/?results=5')->json['results'];
/** @var \OurSociety\Model\Entity\User[] $officials */
$officials = [
    new \OurSociety\Model\Entity\User([
        'name' => 'Susan Welkovits',
        'office' => new \OurSociety\Model\Entity\Office(['name' => 'Council President']),
        'picture' => 'http://www.hpboro.com/images/pages/N394/Susan%20Welkovits.jpg',
        'email' => 'welkovitshp@gmail.com',
    ]),
    new \OurSociety\Model\Entity\User([
        'name' => 'Elsie Foster-Dublin',
        'office' => new \OurSociety\Model\Entity\Office(['name' => 'Councilwoman']),
        'picture' => 'http://www.hpboro.com/images/pages/N390/EFosterDublin.jpg',
        'email' => 'fosterdublinhp@gmail.com'
    ]),
    new \OurSociety\Model\Entity\User([
        'name' => 'Josh Fine',
        'office' => new \OurSociety\Model\Entity\Office(['name' => 'Councilman']),
        'picture' => 'http://www.hpboro.com/images/pages/N440/Josh%20Fine.jpg',
        'email' => 'finejoshhp@gmail.com',
    ]),
    new \OurSociety\Model\Entity\User([
        'name' => 'Matthew Hersh',
        'office' => new \OurSociety\Model\Entity\Office(['name' => 'Councilman']),
        'picture' => 'http://www.hpboro.com/images/pages/N534/IMG_0282.JPG',
        'email' => 'matthewhershhp@gmail.com',
    ]),
    new \OurSociety\Model\Entity\User([
        'name' => 'Philip George',
        'office' => new \OurSociety\Model\Entity\Office(['name' => 'Councilman']),
        'picture' => 'http://www.hpboro.com/images/pages/N389/PGeorgeHeadshot.jpg',
        'email' => 'georgephiliphp@gmail.com',
    ]),
    new \OurSociety\Model\Entity\User([
        'name' => 'Stephany Kim',
        'office' => new \OurSociety\Model\Entity\Office(['name' => 'Councilwoman']),
        'picture' => 'http://www.hpboro.com/images/pages/N562/Stephany%20Kim.jpg',
        'email' => 'kimstephanyhp@gmail.com',
    ]),
];

$pathway = [
    new \OurSociety\Model\Entity\User([
        'name' => 'Gerald Doyle',
        'picture' => 'https://randomuser.me/api/portraits/men/81.jpg',
    ]),
    new \OurSociety\Model\Entity\User([
        'name' => 'Jade Park',
        'picture' => 'https://randomuser.me/api/portraits/women/95.jpg',
    ]),
    new \OurSociety\Model\Entity\User([
        'name' => 'Ricardo Taylor',
        'picture' => 'https://randomuser.me/api/portraits/men/14.jpg',
    ]),
    new \OurSociety\Model\Entity\User([
        'name' => 'Alexander Roy',
        'picture' => 'https://randomuser.me/api/portraits/men/41.jpg',
    ]),
    new \OurSociety\Model\Entity\User([
        'name' => 'Julian Ferrer',
        'picture' => 'https://randomuser.me/api/portraits/men/15.jpg',
    ]),
];

$videos = [
    new \OurSociety\Model\Entity\PoliticianVideo(['youtube_video_id' => 'AOe7s8P2bNQ']),
    new \OurSociety\Model\Entity\PoliticianVideo(['youtube_video_id' => 'p_f3FqT0Q7I']),
    new \OurSociety\Model\Entity\PoliticianVideo(['youtube_video_id' => '-s0-kW-ytaw']),
    new \OurSociety\Model\Entity\PoliticianVideo(['youtube_video_id' => '8Gvb_GbngKk']),
];
?>

<h1 class="os-title" id="content">
    <?= $municipality->name ?>
    <small class="text-muted">Middlesex County, New Jersey</small>
</h1>

<hr>

<div class="row">
    <div class="col-md-3">
        <img class="img-fluid" alt="Generic placeholder image"
             src="http://www.hpboro.com/images/pages/N391/MayorHeadshot.jpg">
        <p class="h5 mt-2 mb-0">Gayle Brill Mittler <small class="text-muted">Mayor</small></p>
        <i class="fa fa-fw fa-envelope"></i> <?= \Kminek\EmailObfuscator::obfuscate('brillmittlerhp@gmail.com') ?>
    </div>
    <div class="col-md-9">
        <h5>Town information</h5>
        <p>
            Highland Park is a borough in Middlesex County, New Jersey, United States. As of the 2010 United States
            Census, the borough's population was 13,982.
        </p>
        <p>
            Highland Park was formed as a borough by an act of the New Jersey Legislature on March 15, 1905, when it
            broke away from what was then known as Raritan Township (present-day Edison).
        </p>
        <p>
            The borough received its name for its "park-like" setting, on the "high land" of the banks of the Raritan
            River, overlooking New Brunswick.
        </p>
        <div class="alert alert-secondary" role="alert">
            <strong>Upcoming election:</strong>
            The <a href="#">New Jersey gubernatorial election, 2017</a> is
            <?= $this->Time->dateCountdown(\Cake\I18n\Time::parse('2017-11-07')) ?>!
        </div>
    </div>
</div>

<hr>

<div class="float-right">
    <div class="btn-group">
        <div class="btn btn-outline-dark"><i class="fa fa-fw fa-fire"></i> Hot</div>
        <div class="btn btn-outline-dark"><i class="fa fa-fw fa-asterisk"></i> New</div>
        <div class="btn btn-outline-dark"><i class="fa fa-fw fa-line-chart"></i> Top</div>
    </div>
</div>

<h2>Trending Policies, Plans & Values</h2>

<div class="card-deck pt-2">
    <?php for ($i = 0; $i < 5; $i++): ?>
        <div class="card">
            <?= $this->Html->icon(
                str_replace('.svg', '', $iconNames[array_rand($iconNames)]),
                ['iconSet' => 'topic', 'style' => 'opacity: .05', 'height' => '275']
            ) ?>
            <div class="card-img-overlay text-center">
                <h5 class="card-title"><?= ucwords($fake->words(2)) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= ['Policy', 'Plan', 'Vision'][random_int(0, 2)] ?></h6>
                <p>
                    <?= \Cake\Utility\Text::truncateByWidth($fake->sentence()) ?>
                </p>
                <p class="card-text"><small class="text-muted"><?= random_int(3, 8) ?> min read</small></p>
            </div>
        </div>
    <?php endfor ?>
</div>

<hr>

<div class="row">
    <div class="col">
        <h2 class="mb-3">Elected Officials</h2>
        <ul class="list-unstyled">
            <?php foreach ($officials as $user): ?>
                <li class="media pb-3">
                    <div class="d-flex mr-3 align-self-center">
                        <div class="img-thumbnail rounded-circle" style="height: 100px; width: 100px;">
                            <div class="circle-avatar" style="background-image: url(<?= $user->picture ?>)"></div>
                        </div>
                    </div>
                    <div class="media-body">
                        <h5><?= $user->name ?></h5>
                        <h6><?= $user->office->name ?></h6>
                        <ul class="list-unstyled">
                            <?php /*
                            <li><i class="fa fa-fw fa-home"></i> <?= sprintf('%s, %s %s', ucwords($user['location']['street']), ucwords($user['location']['city']), ucwords($user['location']['postcode'])) ?></li>
                            <li><i class="fa fa-fw fa-phone"></i> <?= $user->phone ?></li>
                            <li><i class="fa fa-fw fa-mobile-phone"></i> <?= $user['cell'] ?></li>
                            <li><i class="fa fa-fw fa-info"></i> <?= $user->areas ?></li>
                            */ ?>
                            <li><i class="fa fa-fw fa-envelope"></i> <?= \Kminek\EmailObfuscator::obfuscate($user->email) ?></li>
                        </ul>
                    </div>
                </li>
                <?php /*
                <li class="media pb-3">
                    <img class="d-flex mr-3 align-self-center img-thumbnail rounded-circle" src="<?= $user['picture']['large'] ?>" alt="Generic placeholder image">
                    <div class="media-body">
                        <h5><?= sprintf('%s %s %s', 'Councillor', ucwords($user['name']['first']), ucwords($user['name']['last'])) ?></h5>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-fw fa-home"></i> <?= sprintf('%s, %s %s', ucwords($user['location']['street']), ucwords($user['location']['city']), ucwords($user['location']['postcode'])) ?></li>
                            <li><i class="fa fa-fw fa-phone"></i> <?= $user['phone'] ?></li>
                            <li><i class="fa fa-fw fa-mobile-phone"></i> <?= $user['cell'] ?></li>
                            <li><i class="fa fa-fw fa-envelope"></i> <?= \Kminek\EmailObfuscator::obfuscate($user['email']) ?></li>
                        </ul>
                    </div>
                </li>
                */ ?>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="col">
        <div class="card text-center">
            <div class="card-body p-0">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube-nocookie.com/embed/71_ulUBbUNE?rel=0" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="card-footer carousel carousel-video">
                <ul class="nav nav-pills card-header-pills  mb-0">
                    <?php foreach ($videos as $video): ?>
                        <li class="nav-item pr-2">
                            <a class="" href="#">
                                <img class="img-thumbnail" src="<?= $video->youtube_video_thumbnail ?>" style="height: 70px">
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
                <a class="carousel-control-next" role="button">
                    <span class="carousel-control-next-icon" href="#" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <hr>

        <a class="btn btn-outline-dark float-right" href="#">View All</a>
        <h2>Events</h2>

        <ul class="list-unstyled">
            <li class="text-truncate"><small class="text-muted">Monday, August 28 @ 7.30pm &ndash;</small> Library Board of Trustee Meeting @ Public Library</li>
            <li class="text-truncate"><small class="text-muted">Tuesday, September 5 @ 7pm &ndash;</small> Borough Council Meeting @ Borough Hall</li>
            <li class="text-truncate"><small class="text-muted">Wednesday, September 6 @ 5pm &ndash;</small> Public Safety Committee @ Police Department</li>
            <li class="text-truncate"><small class="text-muted">Wednesday, September 6 @ 8pm &ndash;</small> Environmental Commission Meeting @ Environmental Education Center</li>
            <li class="text-truncate"><small class="text-muted">Thursday, September 7 @ 7.30pm &ndash;</small> Commission for Universal Access Meeting @ Borough Hall</li>
            <li class="text-truncate"><small class="text-muted">Thursday, September 7 @ 7.30pm &ndash;</small> Redevelopment Agency Meeting @ Borough Hall</li>
            <li class="text-truncate"><small class="text-muted">Tuesday, September 8 @ 5pm &ndash;</small> Finance Standing Committee Meeting @ Borough Hall</li>
            <li class="text-truncate"><small class="text-muted">Wednesday, September 13 @ 6.30pm &ndash;</small> Housing Authority Meeting @ Samuel J. Kronman Building</li>
            <li class="text-truncate"><small class="text-muted">Tuesday, September 19 @ 7pm &mdash;</small> Borough Council Meeting @ Borough Hall</li>
        </ul>
    </div>
</div>

<hr>

<h2>Pathway Politicians</h2>

<p>
    What is a pathway politician anyway?
    <?= $fake->sentence() ?>
    <?= $this->Html->link('Share your story!', '#') ?>
</p>

<div class="card-deck pt-2">
    <?php foreach ((array)$pathway as $user): ?>
        <div class="card bg-dark text-white">
            <img class="card-img" src="<?= $user->picture ?>" alt="Card image">
            <div class="card-img-overlay text-center">
                <h5 class="card-title align-bottom">
                    <?= $user->name ?>
                </h5>
            </div>
        </div>
    <?php endforeach ?>
</div>

