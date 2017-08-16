<?php
/**
 * @var string $singularVar
 * @var array[] $actions
 * @var array[] $actionGroups
 */
$links = [];
foreach ($actions as $name => $config) {
    $config += ['method' => 'GET'];

    if ((empty($config['url']['controller']) || $this->request->controller === $config['url']['controller']) &&
        (!empty($config['url']['action']) && $this->request->action === $config['url']['action'])
    ) {
        continue;
    }

    $linkOptions = [];
    if (isset($config['options'])) {
        $linkOptions = $config['options'];
    }

    if ($config['method'] === 'DELETE') {
        $linkOptions += [
            'block' => 'action_link_forms',
            'confirm' => __d('crud', 'Are you sure you want to delete record #{0}?', [$singularVar->{$primaryKey}])
        ];
    }

    if ($config['method'] !== 'GET') {
        $linkOptions += [
            'method' => $config['method']
        ];
    }

    if (!empty($config['callback'])) {
        $callback = $config['callback'];
        unset($config['callback']);
        $config['options'] = $linkOptions;
        $links[$name] = $callback($config, !empty($singularVar) ? $singularVar : null, $this);
        continue;
    }

    $url = $config['url'];
    if (!empty($singularVar)) {
        $setPrimaryKey = false;
        $modifiedUrl = [];
        foreach ($url as $key => $value) {
            if (is_array($value)) {
                continue;
            }

            [$k, $v] = str_replace(':primaryKey:', $singularVar->{$primaryKey}, [$key, $value]);
            if ($key !== $k) {
                $setPrimaryKey = true;
            }
            if ($value !== $v) {
                $setPrimaryKey = true;
            }
            $modifiedUrl[$k] = $v;
        }
        $url = $modifiedUrl;
        if (!$setPrimaryKey) {
            $url[] = $singularVar->{$primaryKey};
        }
    }

    $links[$name] = [
        'title' => $config['title'],
        'url' => $url,
        'options' => $linkOptions,
        'method' => $config['method']
    ];
}
?>


    <div class="btn-group" role="group" aria-label="Basic example">
        <?php
        // render primary actions at first
        foreach ($actionGroups['primary'] as $action) {
            if (!isset($links[$action])) {
                continue;
            }

            $config = $links[$action];
            if (is_string($config)) {
                echo $config;
                continue;
            }

            //$config['options']['class'] = ['btn btn-default'];
            //if ($config['method'] !== 'GET') {
            //    echo $this->Form->postLink(
            //        $config['title'] === 'Delete' ? '<i class="fa fa-trash"></i>' : $config['title'],
            //        $config['url'],
            //        $config['title'] === 'Delete' ? $config['options'] + ['escape' => false] : $config['options']
            //    );
            //    continue;
            //}

            echo $this->element(sprintf('action-%s', $type ?? 'button'), ['config' => $config]);
        }
        ?>
    </div>
<?php
unset($actionGroups['primary']);

// render grouped actions
echo $this->element('action-groups', ['groups' => $actionGroups, 'links' => $links]);
