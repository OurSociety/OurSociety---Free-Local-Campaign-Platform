<?php
declare(strict_types=1);

namespace OurSociety\View\Cell\Dashboard;

use Cake\View\Cell;
use OurSociety\Model\Table\DashboardTotalsTable;

/**
 * NumberWidget cell
 */
class NumberWidgetCell extends Cell
{
    protected $name;

    protected $label;

    protected $style;

    protected $icon;

    protected $_validCellOptions = ['name', 'label', 'style', 'icon', 'period'];

    public function display(): void
    {
        $totals = DashboardTotalsTable::getRows($this->name, $this->request->getQuery('range', 'week'));
        $countCurrent = $totals[0]['count'] ?? 0;
        $countPrevious = $totals[1]['count'] ?? 0;

        $view = $this->createView();
        if ($countCurrent > $countPrevious) {
            // Divide by zero warning suppressed since this is correctly rendering as '∞%' in the view.
            /** @noinspection PhpUsageOfSilenceOperatorInspection,UsageOfSilenceOperatorInspection */
            $percentageChange = @(($countCurrent / $countPrevious) - 1) * 100;
            $percentageChangeStyle = 'green';
            $percentageChangeIcon = 'arrow-up';
        } elseif ($countCurrent < $countPrevious) {
            $percentageChange = (1 - $countCurrent / $countPrevious) * 100;
            $percentageChangeStyle = 'pink';
            $percentageChangeIcon = 'arrow-down';
        } else {
            $percentageChange = 0;
            $percentageChangeStyle = 'blue';
            $percentageChangeIcon = 'arrow-right';
        }
        $percentageChange = $view->Number->toPercentage($percentageChange, 0);
        $currentCount = $view->Number->format($countCurrent);
        $previousCount = $view->Number->format($countPrevious);

        $this->set([
            'currentCount' => $currentCount,
            'icon' => $this->icon,
            'label' => $this->label,
            'percentageChange' => $percentageChange,
            'percentageChangeIcon' => $percentageChangeIcon,
            'percentageChangeStyle' => $percentageChangeStyle,
            'previousCount' => $previousCount,
            'style' => $this->style,
        ]);
    }
}
