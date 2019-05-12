<?php
namespace App\Controller\API;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Recipe;
use Menu\Day;

class Recipes extends Controller {
  public function random(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $time = $post['time'];
    $recipe = $this->container->random_recipe->random($time);
    $data = [
      'date' => $post['date'],
      'time_id' => $post['time']
    ];
    $day = $this->container->model->find(Day::class)->where($data)->one();
    if ($day->recipe_id != $recipe->id) {
      $day->recipe_id = $recipe->id;
      $day->save();
    }
    $recipe->feeds = $recipe->feeds();
    return $response->withJSON(compact('recipe'));
  }
  public function ingredients(RequestInterface $request, ResponseInterface $response, $arguments) {
    $recipe = $this->container->model->find(Recipe::class)->one($arguments['recipe']);
    $ingredients = $recipe->ingredients();
    if (!$ingredients) {
      return $response;
    }
    array_walk($ingredients, function(&$item, $key, $recipe) {
      $item->amount = $item->amount($recipe);
      $item->unit = $item->unit($recipe)->__toArray();
    }, $recipe);
    return $response->withJSON(compact('ingredients'));
  }
}
