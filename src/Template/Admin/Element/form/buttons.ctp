<div class="col pull-right">
    <?php
        echo $this->Form->button($formSubmitButtonText, ['class' => 'btn btn-primary', 'name' => '_save']);

        if (!empty($formSubmitExtraButtons)) {
            foreach ($formSubmitExtraButtons as $button) {
                if ($button['type'] === 'button') {
                    echo $this->Form->button($button['title'], $button['options']);
                } elseif ($button['type'] === 'link') {
                    echo $this->Html->link($button['title'], $button['url'], $button['options']);
                }
            }
        }
    ?>
</div>
