<?php

use OurSociety\View\Component\Button\ViewButton;
use OurSociety\View\Component\Field\{
    BooleanDateField, ReferenceField, TextField
};
use OurSociety\View\Component\Listing\Listing;

/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \Cake\ORM\ResultSet $records The result set.
 */

$this->Breadcrumbs->add('Tables');
$this->Breadcrumbs->add('Articles');
?>

<?= $this->Component->render(new Listing([
    (new ReferenceField('electoral_district'))->setTitle('Municipality'),
    new ReferenceField('article_type'),
    (new TextField('name'))->setTitle('Article Title'),
    new BooleanDateField('approved'),
    new BooleanDateField('published'),
    new ViewButton,
], $records)) ?>
