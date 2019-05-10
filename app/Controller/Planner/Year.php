<?php
namespace App\Controller\Planner;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Carbon\Carbon;
use App\Definition\Controller;
use Menu\Day;

class Year extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $date = Carbon::today($this->container->cfg->get('app.timezone'))->startOfYear();
    $date->setLocale('es_ES');
    if (isset($arguments['year'])) {
      $date = Carbon::parse($arguments['year'], $this->container->cfg->get('app.timezone'))->startOfYear();
    }
    $end = $date->copy()->endOfYear();
    return $this->container->view->render($response, 'planner.year', compact('date', 'end'));
  }
}
