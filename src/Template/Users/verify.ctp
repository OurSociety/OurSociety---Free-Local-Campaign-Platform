<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 */
?>
<div class="container">
    <div class="row">
        <div class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8 col-md-6 col-md-offset-3">
            <div class="users form well well-lg">
                <?= $this->Form->create() ?>
                <fieldset>
                    <?php if (!empty($secretDataUri)): ?>
                        <p class='text-center'><img src="<?php echo $secretDataUri; ?>"/></p>
                    <?php endif; ?>
                    <?= $this->Form->control('code', ['required' => true, 'label' => __('Verification Code')]) ?>
                </fieldset>
                <?= /** @noinspection PhpUndefinedMethodInspection */
                $this->Form->button(
                    $this->Html->icon('log-in') .
                    '<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>' .
                    __('Verify'),
                    ['class' => 'btn btn-primary']
                ); ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
