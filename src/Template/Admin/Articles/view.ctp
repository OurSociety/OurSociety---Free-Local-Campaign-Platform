<?php

use OurSociety\View\Component\Button\ToggleButton;
use OurSociety\View\Component\Detail\Show;
use OurSociety\View\Component\Field\{
    BooleanDateField, DateField, EditorField, ReferenceField, TextField
};

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\RecordInterface $record
 */

$this->Breadcrumbs->add('Tables');
$this->Breadcrumbs->add('Articles', ['action' => 'index']);
$this->Breadcrumbs->add($record->getDisplayValue());
?>

<?= $this->Component->render(new Show($record, [
    (new ReferenceField('electoral_district'))
        ->setTitle('Municipality'),
    new ReferenceField('article_type'),
    (new TextField('name'))
        ->setTitle('Article Title'),
    (new EditorField('body'))
        ->setTitle('Article Body'),
    new ReferenceField('aspect'),
    new ReferenceField('politician'),
    new BooleanDateField('approved'),
    new BooleanDateField('published'),
    new DateField('created'),
    new DateField('modified'),
    (new TextField('version'))
        ->setTitle('Revision Number'),

    new ToggleButton($record, ['title' => ['Publish', 'Unpublish'], 'action' => 'toggle_published', 'field' => 'published']),
    new ToggleButton($record, ['title' => ['Approve', 'Disapprove'], 'action' => 'toggle_approved', 'field' => 'approved']),
])) ?>
