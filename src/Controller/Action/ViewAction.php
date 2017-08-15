<?php
declare(strict_types=1);

namespace OurSociety\Controller\Action;

use Crud\Action as Crud;
use Crud\Event\Subject;

class ViewAction extends Crud\ViewAction
{
    /**
     * {@inheritdoc}. Copied from `FindMethodTrait`, with added slug support.
     */
    protected function _findRecord($id, Subject $subject)
    {
        $repository = $this->_table();

        $query = $repository->find($this->findMethod());
        $primaryKey = $repository->getSchema()->column('slug') !== null
            ? 'slug'
            : $repository->getPrimaryKey();
        $aliasedPrimaryKeys = $query->aliasField($primaryKey);
        $query->where([current($aliasedPrimaryKeys) => $id]);

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
