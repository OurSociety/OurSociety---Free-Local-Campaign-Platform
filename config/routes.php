<?php
declare(strict_types=1);

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use OurSociety\Routing\Route\NamedRedirectRoute;
use OurSociety\Routing\Route\SluggedRoute;

/**
 * Default route class used by scopes.
 *
 * Set to DashedRoute for `/urls/with-dashes/in-them`.
 */
Router::defaultRouteClass(DashedRoute::class);

/**
 * Default scope.
 */
Router::scope('/', function (RouteBuilder $routes): void {
    $routes->connect('/billing', ['controller' => 'Billing', 'action' => 'portal'], ['_name' => 'billing']);
    $routes->connect('/billing/checkout/:plan', ['controller' => 'Billing', 'action' => 'checkout'], ['_name' => 'billing:checkout', 'pass' => ['plan']]);
    $routes->connect('/billing/update', ['controller' => 'Billing', 'action' => 'update'], ['_name' => 'billing:update']);
    $routes->connect('/community-contributor/:citizen', ['controller' => 'CommunityContributors', 'action' => 'view'], ['_name' => 'community-contributor', 'pass' => ['citizen']]);
    $routes->connect('/election/:election', ['controller' => 'Elections', 'action' => 'view'], ['_name' => 'election', 'pass' => ['election']]);
    $routes->connect('/election/:election/contest/:contest', ['controller' => 'Contests', 'action' => 'view'], ['_name' => 'election:contest', 'pass' => ['contest']]);
    $routes->connect('/elections', ['controller' => 'Elections'], ['_name' => 'elections']);
    $routes->connect('/embed/:politician', ['controller' => 'Politicians', 'action' => 'embed'], ['_name' => 'politician:embed', 'pass' => ['politician']]);
    $routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgot'], ['_name' => 'users:forgot']);
    $routes->connect('/join-oursociety', ['controller' => 'Users', 'action' => 'register'], ['_name' => 'users:register']);
    $routes->connect('/sign-out', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'users:logout']);
    $routes->connect('/municipality', ['controller' => 'Municipalities', 'action' => 'view', env('EXAMPLE_MUNICIPALITY_SLUG')], ['_name' => 'municipality:default']);
    $routes->connect('/municipality/:municipality', ['controller' => 'Municipalities', 'action' => 'view'], ['_name' => 'municipality', 'pass' => ['municipality']]);
    $routes->connect('/municipality/:municipality/article/new', ['controller' => 'Articles', 'action' => 'add'], ['_name' => 'municipality:article:new', 'pass' => ['municipality']]);
    $routes->connect('/municipality/:municipality/article/:article', ['controller' => 'Articles', 'action' => 'viewFromMunicipalityProfile'], ['_name' => 'municipality:article', 'pass' => ['municipality', 'article']]);
    $routes->connect('/municipality/:municipality/articles', ['controller' => 'Municipalities', 'action' => 'articles'], ['_name' => 'municipality:articles', 'pass' => ['municipality']]);
    $routes->connect('/municipality/:municipality/edit', ['controller' => 'Municipalities', 'action' => 'edit'], ['_name' => 'municipality:edit', 'pass' => ['municipality']]);
    $routes->connect('/municipality/:municipality/event/:event', ['controller' => 'Events', 'action' => 'view'], ['_name' => 'municipality:event', 'pass' => ['event', 'municipality']]);
    $routes->connect('/municipality/:municipality/event/:event/edit', ['controller' => 'Events', 'action' => 'edit'], ['_name' => 'municipality:events:edit', 'pass' => ['event', 'municipality']]);
    $routes->connect('/municipality/:municipality/events', ['controller' => 'Events', 'action' => 'index'], ['_name' => 'municipality:events', 'pass' => ['municipality']]);
    $routes->connect('/municipality/:municipality/events/add', ['controller' => 'Events', 'action' => 'add'], ['_name' => 'municipality:events:add', 'pass' => ['municipality']]);
    $routes->connect('/tutorial', ['controller' => 'Users', 'action' => 'tutorial'], ['_name' => 'users:onboarding']);
    $routes->connect('/person/:person', ['controller' => 'People', 'action' => 'redirect'], ['_name' => 'people', 'pass' => ['person']]);
    $routes->connect('/place/lookup', ['controller' => 'ElectoralDistricts', 'action' => 'lookup'], ['_name' => 'district:lookup']);
    $routes->connect('/place/:district', ['controller' => 'ElectoralDistricts', 'action' => 'view'], ['_name' => 'district', 'pass' => ['district']]);

    $routes->connect('/place/select', ['controller' => 'Places', 'action' => 'select'], ['_name' => 'place:select']);
    $routes->connect('/plans', ['controller' => 'Plans', 'action' => 'index'], ['_name' => 'plans']);
    $routes->connect('/representative/:politician', ['controller' => 'Politicians', 'action' => 'view'], ['_name' => 'politician', 'pass' => ['politician']]);
    $routes->connect('/representative/:politician/article/:article', ['controller' => 'Articles', 'action' => 'view'], ['_name' => 'politician:article', 'pass' => ['politician', 'article']]);
    $routes->connect('/representative/:politician/articles', ['controller' => 'Articles', 'action' => 'index'], ['_name' => 'politician:articles', 'pass' => ['politician']]);
    $routes->connect('/representative/:politician/claim', ['controller' => 'Politicians', 'action' => 'claim'], ['_name' => 'politician:claim', 'pass' => ['politician']]);
    $routes->connect('/representatives', ['controller' => 'Politicians', 'action' => 'index'], ['_name' => 'politicians']);
    $routes->connect('/representatives/:action', ['controller' => 'Politicians']); // TODO: Implement LookupAction or remove.
    $routes->connect('/my-account', ['controller' => 'Users', 'action' => 'profile'], ['_name' => 'users:profile']);
    $routes->connect('/my-account/edit', ['controller' => 'Users', 'action' => 'edit'], ['_name' => 'users:edit']);
    $routes->connect('/reset-password', ['controller' => 'Users', 'action' => 'reset'], ['_name' => 'users:reset']);
    $routes->connect('/search', ['controller' => 'Search', 'action' => 'search'], ['_name' => 'search']);
    $routes->connect('/search/:action/*', ['controller' => 'Search']);
    $routes->connect('/sign-in', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'users:login']);
    $routes->connect('/verify', ['controller' => 'Users', 'action' => 'verify'], ['_name' => 'users:verify']);

    $routes->redirect('/contact', 'https://www.oursociety.org/contact/', ['_name' => 'contact', 'routeClass' => NamedRedirectRoute::class]);
    $routes->redirect('/docs/onboarding', 'https://www.oursociety.org/knowledge-base/contentbasics');
    $routes->redirect('/guide/matching', 'https://www.oursociety.org/knowledge-base/societal-value-matching-how-does-it-work/', ['_name' => 'guide:matching', 'routeClass' => NamedRedirectRoute::class]);
    $routes->redirect('/home', 'https://www.oursociety.org/', ['_name' => 'home', 'routeClass' => NamedRedirectRoute::class]);
    $routes->redirect('/participation-guidelines', 'https://www.oursociety.org/knowledge-base/content-creation-question-submission-guidelines/');
    $routes->redirect('/purpose', 'https://www.oursociety.org/faq/purpose/');
    $routes->redirect('/team', 'https://www.oursociety.org/faq/team/');

    // Renamed routes (TODO: these can be deleted after some time)
    $routes->redirect('/login', '/sign-in'); // 2017-11
    $routes->redirect('/logout', '/sign-out'); // 2017-11
    $routes->redirect('/onboarding', '/tutorial'); // 2017-11
    $routes->redirect('/register', '/join-oursociety'); // 2017-11

    $routes->connect('/', ['controller' => 'Municipalities', 'action' => 'view', env('EXAMPLE_MUNICIPALITY_SLUG')], ['_name' => 'root']);
    $routes->connect('/*', ['controller' => 'Pages', 'action' => 'display']);
});

/**
 * Citizen prefixed routes.
 *
 * All routes here will have URLs prefixed with `/citizen` and names prefixed with `citizen:`.
 */
Router::prefix('citizen', ['_namePrefix' => 'citizen:'], function (RouteBuilder $routes): void {
    $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'dashboard'], ['_name' => 'dashboard']);
    $routes->connect('/ballots', ['controller' => 'Ballot', 'action' => 'index'], ['_name' => 'ballots']);
    $routes->connect('/ballot/:election', ['controller' => 'Ballot', 'action' => 'view'], ['_name' => 'ballot', 'pass' => ['election']]);
    $routes->connect('/notifications', ['controller' => 'Notifications', 'action' => 'list'], ['_name' => 'notifications']);
    $routes->connect('/notification/:notification', ['controller' => 'Notifications', 'action' => 'show'], ['_name' => 'notification', 'pass' => ['notification']]);
    $routes->connect('/profile', ['controller' => 'CommunityContributors', 'action' => 'view'], ['_name' => 'profile']);
    $routes->connect('/profile/edit', ['controller' => 'CommunityContributors', 'action' => 'edit'], ['_name' => 'profile:edit']);
    $routes->connect('/values', ['controller' => 'Questions', 'action' => 'index'], ['_name' => 'questions']);
    $routes->connect('/values/review', ['controller' => 'Answers', 'action' => 'list'], ['_name' => 'answers']);
    $routes->connect('/values/revise/:answer', ['controller' => 'Answers', 'action' => 'edit'], ['_name' => 'answers:edit', 'pass' => ['answer']]);
    $routes->connect('/values/:politician', ['controller' => 'Topics', 'action' => 'compare'], ['_name' => 'topics:compare', 'pass' => ['politician']]);

    $routes->fallbacks(DashedRoute::class);
});

/**
 * Politician prefixed routes.
 *
 * All routes here will have URLs prefixed with `/representative` and names prefixed with `politician:`.
 */
Router::prefix('politician', ['path' => '/representative', '_namePrefix' => 'politician:'], function (RouteBuilder $routes): void {
    $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'dashboard'], ['_name' => 'dashboard']);
    $routes->connect('/notifications', ['controller' => 'Notifications', 'action' => 'list'], ['_name' => 'notifications']);
    $routes->connect('/notification/:notification', ['controller' => 'Notifications', 'action' => 'show'], ['_name' => 'notification', 'pass' => ['notification']]);
    $routes->connect('/profile', ['controller' => 'Politicians', 'action' => 'view'], ['_name' => 'profile']);
    $routes->connect('/profile/edit', ['controller' => 'Politicians', 'action' => 'edit'], ['_name' => 'profile:edit']);
    $routes->connect('/profile/embed', ['controller' => 'Politicians', 'action' => 'embed'], ['_name' => 'profile:embed']);
    $routes->connect('/profile/picture', ['controller' => 'Politicians', 'action' => 'picture'], ['_name' => 'profile:picture']);
    $routes->connect('/questions', ['controller' => 'Questions', 'action' => 'index'], ['_name' => 'questions']);
    $routes->connect('/register', ['controller' => 'Users', 'action' => 'register'], ['_name' => 'register']);

    $routes->prefix('profile', ['_namePrefix' => 'profile:'], function (RouteBuilder $routes): void {
        $routes->connect('/awards', ['controller' => 'Awards', 'action' => 'list'], ['_name' => 'awards']);
        $routes->connect('/award/:award', ['controller' => 'Awards', 'action' => 'edit'], ['_name' => 'award', 'pass' => ['award']]);
        $routes->connect('/positions', ['controller' => 'Positions', 'action' => 'list'], ['_name' => 'positions']);
        $routes->connect('/position/:position', ['controller' => 'Positions', 'action' => 'edit'], ['_name' => 'position', 'pass' => ['position']]);
        $routes->connect('/qualifications', ['controller' => 'Qualifications', 'action' => 'list'], ['_name' => 'qualifications']);
        $routes->connect('/qualification/:qualification', ['controller' => 'Qualifications', 'action' => 'edit'], ['_name' => 'qualification', 'pass' => ['qualification']]);
        $routes->connect('/videos', ['controller' => 'Videos', 'action' => 'index'], ['_name' => 'videos']);
        $routes->connect('/video/:video', ['controller' => 'Videos', 'action' => 'edit'], ['_name' => 'video', 'pass' => ['video']]);
        $routes->connect('/articles', ['controller' => 'Articles', 'action' => 'index'], ['_name' => 'articles']);
        $routes->connect('/article/:article', ['controller' => 'Articles', 'action' => 'edit'], ['_name' => 'article', 'pass' => ['article']]);



        $routes->fallbacks(DashedRoute::class);
    });
});

/**
 * Admin prefixed routes.
 *
 * All routes here will have URLs prefixed with `/admin` and names prefixed with `admin:`.
 */
Router::prefix('admin', ['_namePrefix' => 'admin:'], function (RouteBuilder $routes): void {
    $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'dashboard'], ['_name' => 'dashboard']);
    $routes->connect('/questions', ['controller' => 'Questions', 'action' => 'index'], ['_name' => 'questions']);
    $routes->connect('/users/switch', ['controller' => 'Users', 'action' => 'switch'], ['_name' => 'users:switch']);
    $routes->connect('/users/dashboard', ['controller' => 'Users', 'action' => 'dashboard'], ['_name' => 'users:dashboard']);
    $routes->connect('/representatives/dashboard', ['controller' => 'Politicians', 'action' => 'dashboard'], ['_name' => 'politicians:dashboard']);
    $routes->connect('/aspects/users', ['controller' => 'AspectsUsers', 'action' => 'index']);

    $routes->redirect('/representatives/:action/*', ['controller' => 'Users', 'action' => false], ['persist' => true, 'pass' => ['action']]);

    $routes->fallbacks(DashedRoute::class);
    $routes->fallbacks(SluggedRoute::class);
});

/**
 * Plugin routes.
 *
 * Uncomment if you use `Plugin::load(..., ['routes' => true])` in `bootstrap.php`,
 * otherwise leave commented out for performance and security.
 */
//\Cake\Core\Plugin::routes();
