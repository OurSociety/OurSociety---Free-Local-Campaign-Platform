<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var string $viewVar
 * @var array[] $actions
 */
if (!$this->exists('actions')) {
    $this->start('actions');
        echo $this->element('actions', [
            'actions' => $actions['table'],
            'singularVar' => false,
            'type' => 'link',
        ]);
        // to make sure ${$viewVar} is a single entity, not a collection
        if (${$viewVar} instanceof \Cake\Datasource\EntityInterface && !${$viewVar}->isNew()) {
            echo $this->element('actions', [
                'actions' => $actions['entity'],
                'singularVar' => ${$viewVar},
                'type' => 'link',
            ]);
        }
    $this->end();
}
