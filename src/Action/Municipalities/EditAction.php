<?php
declare(strict_types=1);

namespace OurSociety\Action\Municipalities;

use Cake\Datasource\EntityInterface;
use Cake\Http\Response;
use OurSociety\Model\ElectoralDistricts;

class EditAction extends \OurSociety\Action\EditAction
{
    private $municipality;

    /**
     * @route GET /
     * @routeName root
     */
    public function __invoke(...$params): ?Response
    {
        $this->municipality = $this->getRecordIdentifier($params);
        $this->disableVueJS(); // TODO: Breaks WYSIWYG editor.

        return parent::__invoke(...$params);
    }

    protected function getDefaultModelName(): string
    {
        return ElectoralDistricts::class;
    }

    protected function getRedirectUrl(): array
    {
        return ['_name' => 'municipality', 'municipality' => $this->municipality];
    }

    protected function getSuccessMessage(): string
    {
        return __('The town information has been updated.');
    }

    protected function getErrorMessage(EntityInterface $entity): string
    {
        return __('The town information could not be updated.');
    }
}
