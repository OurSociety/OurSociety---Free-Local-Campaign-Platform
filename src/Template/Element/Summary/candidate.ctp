<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\Candidate $candidate The candidate.
 */

$candidate->politician->office_type = new \OurSociety\Model\Entity\OfficeType([
    'name' => $candidate->contest->office->name,
]);
?>

<?= $this->element('Summary/user', ['user' => $candidate->politician]) ?>
