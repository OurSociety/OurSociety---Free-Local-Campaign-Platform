<?php

use Cake\Core\Configure;

/**
 * @var \OurSociety\View\AppView $this The view.
 * @var string $actionClassName
 */

$shortAction = basename(str_replace('\\', '/', $actionClassName));
$namespace = trim(str_replace($shortAction, '', $actionClassName), '\\');
$class = str_replace(sprintf('\\%s\\', Configure::read('App.namespace')), '', $actionClassName);
$action = str_replace(sprintf('%s\\', 'Action'), '', $class);
$path = str_replace('\\', '/', sprintf('%s/%s.php', APP_DIR, $class));

$this->layout = 'dev_error';

$this->assign('title', sprintf('Missing %s', h($action)));
$this->assign(
    'subheading',
    sprintf('The action class <em>%s</em> could not be found.', h($action))
);
$this->assign('templateName', 'missing_action.ctp');

$this->start('file');
?>
<p class="error">
    <strong>Error: </strong>
    <?= sprintf('Create the <em>%s</em> class in file: <code>%s</code>', h($action), $path); ?>
</p>

<?php
$code = <<<PHP
<?php
declare(strict_types=1);

namespace {$namespace};

use Cake\Http\Response;
use OurSociety\Action\Action;

class {$shortAction} extends Action
{
    public function __invoke(...\$params): ?Response
    {
        return null;
    }
}
PHP;
?>

<div class="code-dump"><?php highlight_string($code) ?></div>
<?php $this->end() ?>
