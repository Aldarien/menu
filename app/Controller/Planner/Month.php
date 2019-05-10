<?php
namespace App\Controller\Planner;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Carbon\Carbon;
use App\Definition\Controller;
use Menu\Day;

class Month extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $date = Carbon::today($this->container->cfg->get('app.timezone'))->startOfMonth();
    if (isset($arguments['month'])) {
      $date = Carbon::parse($arguments['month'], $this->container->cfg->get('app.timezone'))->startOfMonth();
    }
    $end = $date->copy()->endOfMonth();
    return $this->container->view->render($response, 'planner.month', compact('date', 'end'));
  }
}
