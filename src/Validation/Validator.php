<?php
declare(strict_types=1);

namespace OurSociety\Validation;

use Cake\Validation as Cake;

class Validator extends Cake\Validator
{
    public function __construct()
    {
        parent::__construct();

        $this->setProvider('default', new Validation);
    }

    /**
     * Add a year month validation rule to a field.
     *
     * @param string $field The field you want to apply the rule to.
     * @param array $options An array of options.
     * @param string|null $message The error message when the rule fails.
     * @param string|callable|null $when Either 'create' or 'update' or a callable that returns
     *   true when the validation rule should be applied.
     * @see \Cake\Validation\Validation::date()
     * @return $this
     */
    public function yearMonth($field, array $options = [], $message = null, $when = null)
    {
        return $this->add($field, 'yearMonth', array_filter([
            'on' => $when,
            'message' => $message,
            'rule' => ['yearMonth', $options]
        ]));
    }
}
