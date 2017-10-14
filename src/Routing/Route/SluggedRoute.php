<?php
declare(strict_types=1);

namespace OurSociety\Routing\Route;

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;
use OurSociety\Model\Table\AppTable;
use OurSociety\ORM\TableRegistry;

class SluggedRoute extends DashedRoute
{
    public function match(array $url, array $context = [])
    {
        $action = $this->getActionFromUrl($url);

        if ($this->actionAcceptsPrimaryKey($action) === false) {
            return parent::match($url, $context);
        }

        $primaryKey = $this->getFirstPassedParamFromUrl($url);
        if ($primaryKey === null || !$this->isUuid($primaryKey)) {
            return parent::match($url, $context);
        }

        $slug = $this->getSlugFromUrlAndPrimaryKey($url, $primaryKey);
        if ($slug === null) {
            return parent::match($url, $context);
        }

        $url = $this->setFirstPassedParamToUrl($url, $slug);

        return parent::match($url);
    }

    private function getActionFromUrl(array $url): string
    {
        return $url['action'];
    }

    private function actionAcceptsPrimaryKey(string $action): bool
    {
        return in_array($action, ['edit', 'delete', 'view'], true);
    }

    private function getFirstPassedParamFromUrl(array $url): ?string
    {
        return $url[0] ?? null;
    }

    private function isUuid(string $primaryKey): bool
    {
        return preg_match('/^' . Router::UUID . '$/', $primaryKey) === 1;
    }

    private function getControllerNameFromUrl(array $url): string
    {
        return $url['controller'];
    }

    private function getTableFromControllerName(string $controllerName): AppTable
    {
        $controllerToTableNameMap = [
            'Aspects' => 'Categories',
        ];

        return TableRegistry::get($controllerToTableNameMap[$controllerName] ?? $controllerName);
    }

    private function getSlugFromPrimaryKey(AppTable $table, string $primaryKey): string
    {
        return $table->get($primaryKey)->get($table->getSlugFieldName());
    }

    private function getSlugFromUrlAndPrimaryKey(array $url, string $primaryKey): string
    {
        $controllerName = $this->getControllerNameFromUrl($url);
        $table = $this->getTableFromControllerName($controllerName);

        return $this->getSlugFromPrimaryKey($table, $primaryKey);
    }

    private function setFirstPassedParamToUrl(array $url, string $slug): array
    {
        $url[0] = $slug;

        return $url;
    }
}
