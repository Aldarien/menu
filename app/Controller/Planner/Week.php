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
    $days = $this->container->model->find(Day::class)->where(['date' => [$week_start->format('Y-m-d'), '>=']])->many();
    $recipes = $this->container->model->find(Recipe::class)->sort(['title'])->many();
    $random_recipes = [];
    for($i = 0; $i < 7; $i ++) {
      $random_recipes[$i] = $recipes[mt_rand(0, count($recipes) - 1)];
    }
    return $this->container->view->render($response, 'planner.week', compact('days', 'week_start', 'random_recipes'));
  }
}
