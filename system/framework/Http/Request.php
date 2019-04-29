<?php


namespace Xaveere\framework\Http;

use Closure;
use Xaveere\framework\Http\Server\BaseRequest;

class Request extends BaseRequest
{

    protected $routeResolver;


    public function get($key)
    {
        return parent::get($key);
    }

    public static function createFrom(self $from, $to = null)
    {
        $request = $to ?: new static;

        $request->initialize(
              $from->query,
              $from->request,
            $from->server
        );

        $request->setRouteResolve($from->getRouteResolver());

        return $request;

    }


    public function getRouteResolver()
    {
        return $this->routeResolver ?: function () {
            //
        };
    }


    public function setRouteResolve(Closure $closure)
    {
        $this->routeResolver = $closure;

        return $this;
    }

    public function instance()
    {
        return $this;
    }
}