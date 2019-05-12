<?php
namespace App\Controller\Planner;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Carbon\Carbon;
use App\Definition\Controller;
use Menu\Day;
use Menu\Recipe;
use Menu\Time;

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
      ->sort('date')
      ->many();
    if (!$days) {
      $days = [];
    }
    $times = $this->container->model->find(Time::class)->many();
    $random_recipes = $this->generateRandomRecipes($times);
    $days = $this->saveWeek($week_start, $times, $days, $random_recipes);
    return $this->container->view->render($response, 'planner.week', compact('days', 'week_start', 'times'));
  }
  protected function generateRandomRecipes(array $times) {
    $recipes = [];
    for ($i = 0; $i < 7; $i ++) {
      foreach ($times as $time) {
        $recipes[$i][$time->id] = $this->container->random_recipe->random($time->id);
      }
    }
    return $recipes;
  }
  protected function saveWeek(\DateTime $week_start, array $times, array $days, array $recipes) {
    $new_days = [];
    for ($i = 0; $i < 7; $i ++) {
      foreach ($times as $time) {
        $d = null;
        $exists = false;
        if (count($days) > 0) {
          foreach ($days as $day) {
            $map = array_map(function($item) {
              return ['date' => $item->date(), 'time' => $item->time_id];
            }, $days);
            if (($k = array_search(['date' => $week_start->copy()->addDays($i), 'time' => $time->id], $map)) !== false) {
              $exists = true;
              $d = $days[$k];
              break;
            }
          }
        }
        if (!$exists and isset($recipes[$i][$time->id]) and $recipes[$i][$time->id]) {
          $data = [
            'date' => $week_start->copy()->addDays($i)->format('Y-m-d'),
            'recipe_id' => $recipes[$i][$time->id]->id,
            'time_id' => $time->id
          ];
          $day = $this->container->model->create(Day::class, $data);
          $day->save();
          $d = $day;
        }
        if (isset($d) and $d != null) {
          $new_days[$i][$time->id] = $d;
        }
      }
    }
    return $new_days;
  }
}
