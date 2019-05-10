<?php
namespace App\Controller\Planner;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Carbon\Carbon;
use App\Definition\Controller;
use Menu\Day;
use Menu\Recipe;

class Week extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $week_start = Carbon::today($this->container->cfg->get('app.timezone'))->startOfWeek();
    $week_start->setLocale('es_ES');
    if (isset($arguments['week'])) {
      $week_start = Carbon::parse($arguments['week'], $this->container->cfg->get('app.timezone'))->startOfWeek();
    }
    $end = $week_start->copy()->endOfWeek();
    $days = $this->container->model->find(Day::class)
      ->where([
        'date' => [$week_start->format('Y-m-d'), '>='],
        'date' => [$end->format('Y-m-d'), '<=']
      ])
      ->many();
    $recipes = $this->container->model->find(Recipe::class)->sort(['title'])->many();
    $random_recipes = [];
    for($i = 0; $i < 7; $i ++) {
      $random_recipes[$i] = $recipes[mt_rand(0, count($recipes) - 1)];
    }
    $days = $this->saveWeek($week_start, $days, $random_recipes);
    return $this->container->view->render($response, 'planner.week', compact('days', 'week_start', 'random_recipes'));
  }
  protected function saveWeek(\DateTime $week_start, array $days, array $recipes) {
    for ($i = 0; $i < 7; $i ++) {
      $exists = false;
      if ($days) {
        foreach ($days as $day) {
          if ($day->date() == $week_start->copy()->addDays($i)) {
            $exists = true;
          }
        }
      } else {
        $days = [];
      }
    }
    if (!$exists) {
      $data = [
        'date' => $week_start->copy()->addDays($i)->format('Y-m-d'),
        'recipe_id' => $random_recipes[$i]->id
      ];
      $day = $this->container->model->create(Day::class, $data);
      $day->save();
      $days []= $day;
    }
    return $days;
  }
}
