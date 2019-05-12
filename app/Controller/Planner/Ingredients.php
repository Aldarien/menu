<?php
namespace App\Controller\Planner;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Carbon\Carbon;
use App\Definition\Controller;
use Menu\Day;

class Ingredients extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $period = 'week';
    $valid_periods = ['month', 'week', 'day'];
    if (isset($arguments['period'])) {
      $period = $arguments['period'];
      if (array_search($period, $valid_periods) === false) {
        return $response->withRedirect($this->container->base_url);
      }
    }
    $date = Carbon::today($this->container->cfg->get('app.timezone'));
    if (isset($arguments['date'])) {
      $date = Carbon::parse($arguments['date'], $this->container->cfg->get('app.timezone'));
    }
    $where = [
      'date' => $date->format('Y-m-d')
    ];
    switch ($period) {
      case 'week';
        $date->startOfWeek();
        $end = $date->copy()->endOfWeek();
        $where = [
          'date' => [$date->format('Y-m-d'), '>='],
          'date' => [$end->format('Y-m-d'), '<=']
        ];
        break;
      case 'month':
        $date->startOfMonth();
        $end = $date->copy()->endOfMonth();
        $where = [
          'date' => [$date->format('Y-m-d'), '>='],
          'date' => [$end->format('Y-m-d'), '<=']
        ];
        break;
    }
    $date->setLocale('es_ES');
    $days = $this->container->model->find(Day::class)->where($where)->many();
    $ingredients = [];
    foreach ($days as $day) {
      if (!$day->recipe()->ingredients()) {
        continue;
      }
      foreach ($day->recipe()->ingredients() as $ingredient) {
        if (($i = array_search(['id' => $ingredient->id, 'unit' => $ingredient->unit_id], array_map(function($item) {
          return ['id' => $item->id, 'unit' => $item->unit_id];
        }, $ingredients))) === false) {
          $ingredient->amount = $ingredient->amount($day->recipe());
          $ingredient->unit = $ingredient->unit($day->recipe());
          $ingredients []= $ingredient;
        } else {
          $ingredients[$i]->amount += $ingredient->amount($day->recipe());
        }
      }
    }
    return $this->container->view->render($response, 'planner.ingredients', compact('ingredients', 'date', 'period'));
  }
}
