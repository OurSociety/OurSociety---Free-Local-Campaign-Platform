<?php
/**
 * @var \OurSociety\Model\Entity\User $identity The current user.
 */

// Disable during development.
if (\Cake\Core\Configure::read('debug')) {
    return;
}

// Disable for team members.
if ($identity !== null && $identity->isAdmin()) {
    return;
}
?>

<!-- Google Analytics -->
<script>
    window.ga = window.ga || function () {
        (ga.q = ga.q || []).push(arguments)
    };
    ga.l = +new Date;
    ga('create', 'UA-102777595-2', 'auto');
    ga('set', 'transport', 'beacon');
    ga('send', 'pageview');
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script>
<!-- End Google Analytics -->
