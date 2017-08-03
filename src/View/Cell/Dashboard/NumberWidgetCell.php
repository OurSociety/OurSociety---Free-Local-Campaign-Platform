<?php
declare(strict_types=1);

namespace OurSociety\View\Cell\Dashboard;

use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
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

    public function __construct(
        ServerRequest $request = null,
        Response $response = null,
        EventManager $eventManager = null,
        array $cellOptions = []
    ) {
        $this->_validCellOptions = ['name', 'label', 'style', 'icon', 'period'];

        parent::__construct($request, $response, $eventManager, $cellOptions);
    }

    public function display(): void
    {
        $total = DashboardTotalsTable::getTotal($this->name, $this->request->getQuery('range', 'week'));

        $view = $this->createView();
        $percentageChangeStyle = isset($total->percentage_change) && $total->percentage_change > 0 ? 'green' : 'pink';
        $percentageChangeDirection = isset($total->percentage_change) && $total->percentage_change > 0 ? 'up' : 'down';
        $percentageChange = isset($total->percentage_change) ? $view->Number->toPercentage($total->percentage_change, 0) : 'Unknown';
        $currentCount = isset($total->count_current) ? $view->Number->format($total->count_current) : 'Unknown';
        $previousCount = isset($total->count_previous) ? $view->Number->format($total->count_previous) : 'Unknown';

        $this->set([
            'currentCount' => $currentCount,
            'icon' => $this->icon,
            'label' => $this->label,
            'percentageChange' => $percentageChange,
            'percentageChangeDirection' => $percentageChangeDirection,
            'percentageChangeStyle' => $percentageChangeStyle,
            'previousCount' => $previousCount,
            'style' => $this->style,
        ]);
    }
}
