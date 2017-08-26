<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var \OurSociety\Model\Entity\Election $upcomingElection The upcoming election.
 */

if ($upcomingElection === null):
    return;
endif;
?>

<div class="alert alert-secondary" role="alert">
    <strong>Upcoming election:</strong>
    The <a href="#"><?= $upcomingElection->name ?></a> is
    <?= $this->Time->dateCountdown($upcomingElection->date) ?>!
</div>
