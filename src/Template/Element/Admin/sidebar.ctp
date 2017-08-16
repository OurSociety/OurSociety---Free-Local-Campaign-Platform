<?php
/**
 * Admin sidebar element.
 *
 * @var \OurSociety\View\AppView $this The view.
 * @var array $actionConfig The Crud action config.
 * @var array|false|null $sidebarNavigation The CrudView `scaffold.sidebar_navigation` config.
 */
?>

<div class="col-12 col-md-3 col-xl-2 bd-sidebar">

    <!--
    <form class="bd-search d-flex align-items-center">
        <input type="search" class="form-control ds-input" id="search-input" placeholder="Search..."
               aria-label="Search for..." autocomplete="off" spellcheck="false" role="combobox"
               aria-autocomplete="list" aria-expanded="false" aria-labelledby="search-input"
               dir="auto" style="position: relative; vertical-align: top;">
        <button class="btn-link bd-search-docs-toggle d-md-none p-0 ml-3" type="button" data-toggle="collapse" data-target="#bd-docs-nav" aria-controls="bd-docs-nav" aria-expanded="false" aria-label="Toggle docs avigation">
            <svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false">
                <title>Menu</title>
                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path>
            </svg>
        </button>
    </form>
    -->

    <nav class="bd-links collapse" id="bd-docs-nav">
        <div class="bd-toc-item active">
            <a class="bd-toc-link" href="/admin">Dashboards</a>
            <?php if ($this->request->getParam('action') === 'dashboard'): ?>
            <ul class="nav bd-sidenav">
                <li><a href="/admin/analytics/dashboard">Analytics</a></li>
                <li><a href="/admin/aspects/dashboard">Aspects</a></li>
                <!--<li><a href="/admin/citizens/dashboard">Citizens</a></li>-->
                <!--<li><a href="/admin/politicians/dashboard">Politicians</a></li>-->
                <li><a href="/admin/questions/dashboard">Questions</a></li>
                <li><a href="/admin/users/dashboard">Users</a></li>
                <li><a href="/admin/value-matches/dashboard">Values</a></li>
            </ul>
            <?php endif ?>
        </div>

        <div class="bd-toc-item active">
            <a class="bd-toc-link" href="/admin/users">Database</a>
            <?php if ($this->request->getParam('action') !== 'dashboard'): ?>
                <ul class="nav bd-sidenav">
                    <li><a href="/admin/answers">Answers</a></li>
                    <li><a href="/admin/aspects">Aspects</a></li>
                    <li><a href="/admin/aspects/users">Aspects by User</a></li>
                    <li><a href="/admin/politician-articles">Politician Articles</a></li>
                    <li><a href="/admin/politician-awards">Politician Awards</a></li>
                    <li><a href="/admin/politician-positions">Politician Positions</a></li>
                    <li><a href="/admin/politician-qualifications">Politician Qualifications</a></li>
                    <li><a href="/admin/politician-videos">Politician Videos</a></li>
                    <li><a href="/admin/questions">Questions</a></li>
                    <li><a href="/admin/users">Users</a></li>
                    <li><a href="/admin/value-matches">Value Matches</a></li>
                </ul>
            <?php endif ?>
        </div>

    </nav>
</div>
