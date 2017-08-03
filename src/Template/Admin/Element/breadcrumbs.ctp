<?php
/**
 * Admin breadcrumbs element.
 *
 * @var \OurSociety\View\AppView $this The view.
 * @var \CrudView\Breadcrumb\Breadcrumb[] $breadcrumbs CrudView breadcrumb objects from 'scaffold.breadcrumbs' config.
 */

// Make sure Admin dashboard is the first link:
$adminUrl = $this->request->getUri()->getPath() !== '/admin' ? '/admin' : null;
empty($this->Breadcrumbs->getCrumbs())
    ? $this->Breadcrumbs->add('Admin', $adminUrl)
    : $this->Breadcrumbs->insertAt(0, 'Admin', $adminUrl);

// Add each CrudView breadcrumb object:
if (isset($breadcrumbs)):
    foreach ($breadcrumbs as $breadcrumb):
        $this->Breadcrumbs->add($breadcrumb->getTitle(), $breadcrumb->getUrl(), $breadcrumb->getOptions());
    endforeach;
endif;
?>

<?= $this->Breadcrumbs->render() ?>
