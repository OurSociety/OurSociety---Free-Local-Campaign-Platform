<?php
declare(strict_types=1);

namespace OurSociety\Controller\Action\Traits;

use Crud\Event\Subject;
use OurSociety\Model\Table\AppTable;

trait FindMethodTrait
{
    use \Crud\Traits\FindMethodTrait;

    /**
     * {@inheritdoc}. Copied from `FindMethodTrait`, with added slug support.
     */
    protected function _findRecord($id, Subject $subject)
    {
        /** @var AppTable $repository */
        $repository = $this->_table();

        $query = $repository->find($this->findMethod());

        $notFoundBySlug = false;
        if ($repository->hasSlugField()) {
            $query->find('slugged', ['slug' => $id]);
            if(!$query->count()){
                $notFoundBySlug = true;
            }
        }

        if ($notFoundBySlug) {
            $query = $repository->find($this->findMethod());
            $query->where([
                $repository->aliasField($repository->getPrimaryKey()) => $id
            ]);
        }

        $subject->set([
            'repository' => $repository,
            'query' => $query
        ]);

        $this->_trigger('beforeFind', $subject);
        $entity = $subject->query->first();

        if (!$entity) {
            $this->_notFound($id, $subject);
        }

        $subject->set(['entity' => $entity, 'success' => true]);
        $this->_trigger('afterFind', $subject);

        return $entity;
    }
}
