<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 */

$fake = new joshtronic\LoremIpsum();
$iconNames = (new \Cake\Filesystem\Folder(ROOT . DS . 'assets' . DS . 'img' . DS . 'icon' . DS . 'topic'))->find('.*\.svg');
[$officials, $pathway] = array_chunk((new \Cake\Http\Client)->get('https://randomuser.me/api/?results=10')->json['results'], 5);
?>
<h1 class="os-title" id="content">
    <?= $municipality->name ?>
</h1>

<hr>

<div class="media">
    <img class="d-flex mr-3 align-self-center" src="https://upload.wikimedia.org/wikipedia/en/5/51/Mayor_Quimby.png" alt="Generic placeholder image">
    <div class="media-body">
        <h5>Town information</h5>
        <p>
            Trains operated to the area by Pennsylvania Railroad served what was called "Good Luck Point", with visitors building cottages that were the start of the community that became Ocean Gate. AT&T operated a shortwave radio transmitting station after purchasing 175 acres (71 ha) in 1929.
        </p>
        <p>
            The borough of Ocean Gate was incorporated by an act of the New Jersey Legislature on February 28, 1918, from portions of Berkeley Township. An additional portion of Berkeley Township was annexed on February 28, 1953.
        </p>
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
            <?php foreach ((array)$officials as $user): ?>
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
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="col">
        <div class="embed-responsive embed-responsive-16by9 mb-3">
            <iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube-nocookie.com/embed/ZphfS3ILvQs?rel=0" frameborder="0" allowfullscreen></iframe>
        </div>

        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube-nocookie.com/embed/k7Q1RXxdkrk?rel=0" frameborder="0" allowfullscreen></iframe>
        </div>
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
            <img class="card-img" src="<?= $user['picture']['large'] ?>" alt="Card image">
            <div class="card-img-overlay text-center">
                <h5 class="card-title align-bottom">
                    <?= sprintf('%s %s', ucwords($user['name']['first']), ucwords($user['name']['last'])) ?>
                </h5>
            </div>
        </div>
    <?php endforeach ?>
</div>

