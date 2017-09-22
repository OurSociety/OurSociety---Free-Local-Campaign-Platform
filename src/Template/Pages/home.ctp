<?php
/**
 * @var \OurSociety\View\AppView $this
 */

$this->assign('scope', 's-home');
?>

<main class="os-masthead row" id="content" role="main">
    <div class="container text-white text-center">

        <h1>
            <svg class="mb-3 align-middle" width="128" height="128" xmlns="http://www.w3.org/2000/svg" focusable="false">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/img/brand-sprite.svg#logo-white-transparent"></use>
            </svg>
            <!--OurSociety-->
        </h1>

        <h2>
            <?= __('Grassroots') ?>
            &ndash;
            <?= __('Transparent') ?>
            &ndash;
            <?= __('Issue Focused') ?>
        </h2>

        <p class="lead">
            <?= __('Changing the way we campaign and vote one question at a time') ?>
        </p>

        <p class="lead">
            <?= $this->Html->link('Join OurSociety', ['_name' => 'users:register'], ['class' => ['btn', 'btn-lg', 'btn-os-yellow']]) ?>
        </p>

        <p class="text-muted">
            <?= __('Already have an account?') ?>
            <?= $this->Html->link('Sign In', ['_name' => 'users:login'], ['class' => 'text-white']) ?>
        </p>
    </div>
</main>

<section class="os-featurette">
    <div class="container">
        <h2 class="os-featurette-title">
            <?= __('Politics for everyone, everywhere') ?>
        </h2>

        <p class="lead">
            <?= __('OurSociety aims to make politics more open and accessible.') ?>
            <?= __("It's made for folks of all interests; from the ordinary citizen, to running candidates, to elected officials.") ?>
        </p>

        <div class="row text-center">
            <div class="col-sm-4 mb-3">
                <i class="fa fa-4x fa-users" style="color: #582c83"></i>
                <h4>
                    <?= __('2 million voters') ?>
                </h4>
                <p class="card-text">
                    Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                    do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                </p>
            </div>
            <div class="col-sm-4 mb-3">
                <i class="fa fa-4x fa-calendar" style="color: #582c83"></i>
                <h4>
                    <?= __('50 NJ politicians') ?>
                </h4>
                <p class="card-text">
                    Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                    do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                </p>
            </div>
            <div class="col-sm-4 mb-3">
                <i class="fa fa-4x fa-map" style="color: #582c83"></i>
                <h4>
                    <?= __('231 Municipalities') ?>
                </h4>
                <p class="card-text">
                    Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                    do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                </p>
            </div>
        </div>

        <hr class="half-rule mx-auto">

        <div class="text-center">
            <p>
                <strong>
                    OurSociety is a 501(c) non-profit
                </strong>
                with the purpose to create a more transparent, collaborative,
                and highly engaging democratic process that empowers grassroots leadership through our web platform.
                The platform is based on issues, ideals and plans - not charisma and cash.
            </p>
            <a href="https://www.oursociety.org/purpose.php" class="btn btn-os-purple">Our Purpose</a>
        </div>
    </div>
</section>

<section class="os-featurette">
    <div class="container">
        <div class="row py-5">
            <div class="col">
                <h2 class="os-featurette-title">
                    <?= __('Plans, Policies and Visions') ?>
                </h2>

                <p class="lead">
                    <?= __('We provide a publishing platform for local government to promote their viewpoints.') ?>
                    <?= __('These are some featured articles to give you an idea of the types of content available.') ?>
                </p>

                <div class="card-deck">

                    <article class="card" style="width: 20rem;">
                        <img class="card-img-top" src="https://www.oursociety.org/img/reimagine500x500.png" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">Article #1</h4>
                            <p class="card-text">
                                Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                                do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                            </p>
                            <p>
                                <small class="text-muted"><?= random_int(3, 7) ?> minute read</small>
                            </p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </article>

                    <article class="card" style="width: 20rem;">
                        <img class="card-img-top" src="https://www.oursociety.org/img/expandingpossible500x500.png" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">Article #2</h4>
                            <p class="card-text">
                                Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                                do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                            </p>
                            <p>
                                <small class="text-muted"><?= random_int(3, 7) ?> minute read</small>
                            </p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </article>

                    <article class="card" style="width: 20rem;">
                        <img class="card-img-top" src="https://www.oursociety.org/img/collabdemo500x500.png" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">Article #3</h4>
                            <p class="card-text">
                                Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                                do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                            </p>
                            <p>
                                <small class="text-muted"><?= random_int(3, 7) ?> minute read</small>
                            </p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </article>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="os-featurette">
    <div class="container">
        <h2 class="os-featurette-title">
            <?= __('Another Heading, To Catch Attention') ?>
        </h2>

        <p class="lead">
            <?= __('We need some text here to lead into the features and icons below.') ?>
            <?= __('This should help keep visitors on the site for longer and increase conversion rates.') ?>
        </p>

        <div class="row text-center">
            <div class="col-sm-4 mb-3">
                <i class="fa fa-4x fa-bar-chart" style="color: #582c83"></i>
                <h4>
                    <?= __('Impact Report') ?>
                </h4>
                <p class="card-text">
                    Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                    do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                </p>
            </div>
            <div class="col-sm-4 mb-3">
                <i class="fa fa-4x fa-refresh" style="color: #582c83"></i>
                <h4>
                    <?= __('Governance') ?>
                </h4>
                <p class="card-text">
                    Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                    do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                </p>
            </div>
            <div class="col-sm-4 mb-3">
                <i class="fa fa-4x fa-line-chart" style="color: #582c83"></i>
                <h4>
                    <?= __('Mission') ?>
                </h4>
                <p class="card-text">
                    Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                    do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                </p>
            </div>
        </div>

        <hr class="half-rule mx-auto">

        <div class="text-center">
            <h3>
                    <?= __("Let's level the playing field!") ?>
            </h3>

            <div class="btn-group mt-4">
                <a href="https://www.oursociety.org/purpose.php" class="btn btn-outline-light" style="background-color: #0084b4">
                    <i class="fa fa-fw fa-twitter"></i>
                    <?= __('Follow us on Twitter') ?>
                </a>
                <a href="https://www.oursociety.org/purpose.php" class="btn btn-outline-light" style="background-color: #3b5998">
                    <i class="fa fa-fw fa-facebook-official"></i>
                    <?= __('Like us on Facebook') ?>
                </a>
            </div>
        </div>
    </div>
</section>
