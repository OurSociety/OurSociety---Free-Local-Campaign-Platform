<?php
/**
 * @var \OurSociety\View\AppView $this
 */

$this->assign('scope', 's-home');
?>
<section class="jumbotron text-center">
    <?= $this->Html->image('http://via.placeholder.com/780x350?text=Image%20Coming%20Soon') ?>

    <h2>Grassroots - Transparent - Issue Focused</h2>

    <p>Changing the way we campaign and vote one question at a time</p>

    <?= $this->Html->link('Register', ['_name' => 'users:register'], ['class' => 'btn btn-primary']) ?>

    <p class="text-muted small">
        <small>
            <?= __('Already have an account?') ?>
            <?= $this->Html->link('Login', ['_name' => 'users:login']) ?>
        </small>
    </p>
</section>

<hr />

<section class="row">
    <div class="col-xs-4 text-center">
        <?= $this->Html->image('../img/icon/1.png') ?>
        <h4>2 million voters</h4>
    </div>
    <div class="col-xs-4 text-center">
        <?= $this->Html->image('../img/icon/3.png') ?>
        <h4>50 NJ politicians</h4>
    </div>
    <div class="col-xs-4 text-center">
        <?= $this->Html->image('../img/icon/2.png') ?>
        <h4># of something</h4>
    </div>
</section>

<section class="row">
    <div class="col-xs-12">
        <h2 class="text-center">Featured</h2>

        <div class="row">
            <article class="col-lg-4 text-justify">
                <?= $this->Html->image(
                    'http://via.placeholder.com/600x400?text=Image%20Coming%20Soon',
                    ['class' => 'img-responsive']
                ) ?>
                <h3>Post #1</h3>
                <p>
                    Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                    do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                </p>
            </article>

            <article class="col-lg-4 text-justify">
                <?= $this->Html->image(
                    'http://via.placeholder.com/600x400?text=Image%20Coming%20Soon',
                    ['class' => 'img-responsive']
                ) ?>
                <h3>Post #2</h3>
                <p>
                    Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                    do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                </p>
            </article>

            <article class="col-lg-4 text-justify">
                <?= $this->Html->image(
                    'http://via.placeholder.com/600x400?text=Image%20Coming%20Soon',
                    ['class' => 'img-responsive']
                ) ?>
                <h3>Post #3</h3>
                <p>
                    Lorem ipsum dolar sit amet, consecutor adipiscing elit, sed
                    do eiusmod tempr incididunt ut labore et dolore magna aliqua.
                </p>
            </article>
        </div>
    </div>
</section>

<section class="row text-center">
    <div class="col-xs-12">
        <h2>About Us</h2>
        <p>
            OurSociety is a 501(c) non-profit with the purpose to create a more transparent, collaborative,
            and highly engaging democratic process that empowers grassroots leadership through our web platform.
            The platform is based on issues, ideals and plans - not charisma and cash.
        </p>
    </div>
</section>

<section class="row">
    <div class="col-xs-4 text-center">
        <?= $this->Html->image('../img/icon/4.png') ?>
        <h4>Impact Report</h4>
    </div>
    <div class="col-xs-4 text-center">
        <?= $this->Html->image('../img/icon/5.png') ?>
        <h4>Governance</h4>
    </div>
    <div class="col-xs-4 text-center">
        <?= $this->Html->image('../img/icon/6.png') ?>
        <h4>Mission</h4>
    </div>
</section>

<section class="row">
    <div class="col-xs-12">
        <h2 class="text-center">Let's level the playing field</h2>

        <ul class="list-unstyled">
            <li>
                <?= $this->Html->image('../img/icon/tw.png') ?>
                Follow us on Twitter
            </li>
            <li>
                <?= $this->Html->image('../img/icon/fb.png') ?>
                Follow us on Facebook
            </li>
        </ul>
    </div>
</section>
