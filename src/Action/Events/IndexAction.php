<?php
declare(strict_types=1);

namespace OurSociety\Action\Events;

use Cake\Http\Response;
use OurSociety\Model\Entity\ElectoralDistrict;
use OurSociety\ORM\TableRegistry;

class IndexAction extends \OurSociety\Action\IndexAction
{
    private $municipality;

    public function __invoke(...$params): ?Response
    {
        $this->municipality = $params[0];
        $this->setViewVariable('municipality', $this->getMunicipality());

        return parent::__invoke($params);
    }

    public function getRecordsViewVariable(): string
    {
        return 'events';
    }

    protected function getDefaultFinderOptions(): array
    {
        return ['municipality' => $this->municipality] + parent::getDefaultFinderOptions();
    }

    private function getMunicipality(): ElectoralDistrict
    {
        return TableRegistry::get('ElectoralDistricts')
            ->find('slugged', ['slug' => $this->municipality])
            ->firstOrFail();
    }
}
