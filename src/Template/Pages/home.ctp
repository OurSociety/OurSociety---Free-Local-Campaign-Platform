<section class="jumbotron text-center">
    <?= $this->Html->image('http://via.placeholder.com/780x350?text=Image%20Coming%20Soon') ?>

    <h2>Grassroots - Transparent - Issue Focused</h2>

    <p>Changing the way we campaign and vote one question at a time</p>

    <button class="btn btn-primary">Register</button>

    <p class="text-muted small"><small>Already have an account? <a href="#">Login</a></small></p>
</section>

<hr />

<div class="row">
    <div class="col-xs-4 text-center">
        <?= $this->Html->image('icon/1.png') ?>
        <p>2 million voters</p>
    </div>
    <div class="col-xs-4 text-center">
        <?= $this->Html->image('icon/3.png') ?>
        <p>50 NJ politicians</p>
    </div>
    <div class="col-xs-4 text-center">
        <?= $this->Html->image('icon/2.png') ?>
        <p># of something</p>
    </div>
</div>

<section>
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
</section>

<section class="text-center">
    <h2>About Us</h2>

    <p>
        OurSociety is a 501(c) non-profit with the purpose to create a more transparent, collaborative,
        and highly engaging democratic process that empowers grassroots leadership through our web platform.
        The platform is based on issues, ideals and plans - not charisma and cash.
    </p>

    <div class="row">
        <div class="col-xs-4 text-center">
            <?= $this->Html->image('icon/4.png') ?>
            <p>Impact Report</p>
        </div>
        <div class="col-xs-4 text-center">
            <?= $this->Html->image('icon/5.png') ?>
            <p>Governance</p>
        </div>
        <div class="col-xs-4 text-center">
            <?= $this->Html->image('icon/6.png') ?>
            <p>Mission</p>
        </div>
    </div>
</section>

<section>
    <h2 class="text-center">Let's level the playing field</h2>

    <ul class="list-unstyled">
        <li>
            <?= $this->Html->image('icon/tw.png') ?>
            Follow us on Twitter
        </li>
        <li>
            <?= $this->Html->image('icon/fb.png') ?>
            Follow us on Facebook
        </li>
    </ul>
</section>

<hr>

<footer>
    <p><?= $this->Html->image('banner.png', ['style' => 'height: 50px']) ?></p>
    <ul class="list-unstyled">
        <li><a href="#">info@oursociety.org</a></li>
        <li><a href="#">Menu Item #1</a></li>
        <li><a href="#">Menu Item #2</a></li>
        <li><a href="#">Menu Item #3</a></li>
    </ul>

    <p class="text-center text-muted small">Disclaimer, copyright</p>
</footer>
