<?php
namespace App\Controller\Planner;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Carbon\Carbon;
use App\Definition\Controller;
use Menu\Day as DModel;
use Menu\Recipe;

class Day extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $date = Carbon::today($this->container->cfg->get('app.timezone'));
    $day = $this->container->model->find(DModel::class)->where(['date' => $date->format('Y-m-d')])->one();
    $recipe = $day->recipe();
    if (!$day) {
      $recipes = $this->container->model->find(Recipe::class)->sort(['title'])->many();
      $recipe = $recipes[mt_rand(0, count($recipes) - 1)];
    }
    return $this->container->view->render($response, 'planner.day', compact('date', 'recipe'));
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $date = Carbon::parse($arguments['day'], $this->container->cfg->get('app.timezone'));
    $day = $this->container->model->find(DModel::class)->where(['date' => $date->format('Y-m-d')])->one();
    if (!$day) {
      $recipes = $this->container->model->find(Recipe::class)->sort(['title'])->many();
      $recipe = $recipes[mt_rand(0, count($recipes) - 1)];
    } else {
      $recipe = $day->recipe();
    }
    return $this->container->view->render($response, 'planner.day', compact('date', 'recipe'));
  }
}
