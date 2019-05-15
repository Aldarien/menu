<?php
namespace App\Controller\Planner;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Carbon\Carbon;
use App\Definition\Controller;
use Menu\Day as DModel;
use Menu\Recipe;
use Menu\Time;

class Day extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $date = Carbon::today($this->container->cfg->get('app.timezone'));
    if (isset($arguments['day'])) {
      $date = Carbon::parse($arguments['day'], $this->container->cfg->get('app.timezone'));
    }
    $days = $this->container->model->find(DModel::class)->where(['date' => $date->format('Y-m-d')])->sort('time_id')->many();
    $times = $this->container->model->find(Time::class)->sort('id')->many();
    if (!$days) {
      $recipes = [];
      foreach ($times as $time) {
        $recipes[$time->id] = $this->container->random_recipe->random($time->id);
      }

      $days = [];
      foreach ($recipes as $time => $recipe) {
        if (!$recipe) {
          continue;
        }
        $data = [
          'date' => $date->format('Y-m-d'),
          'recipe_id' => $recipe->id,
          'time_id' => $time
        ];
        $day = $this->container->model->create(DModel::class, $data);
        $day->save();
        $days []= $day;
      }
    } else {
      $recipes = [];
      foreach ($times as $time) {
        if (($i = array_search($time->id, array_map(function($item) {
          return $item->time_id;
        }, $days))) !== false) {
          $recipes[$time->id] = $days[$i]->recipe();
        } else {
          $recipe = $this->container->random_recipe->random($time->id);
          if (!$recipe) {
            continue;
          }
          $recipes[$time->id] = $recipe;
        }
      }
    }
    return $this->container->view->render($response, 'planner.day', compact('date', 'recipes', 'times'));
  }
}
