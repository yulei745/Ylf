<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/7
 * Time: 10:49
 */

namespace Ylf\Http\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use Illuminate\Support\Str;

use Dflydev\FigCookies\Cookie;


class StartSession
{

    protected $cookie;

    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable|null $out
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        // TODO: Implement __invoke() method.
        $session = $this->startSession();

        $request = $request->withAttribute('session', $session);
        $response = $this->withCsrfTokenHeader($response, $session);

        return $out ? $out($request, $response) : $response;
    }

    /**
     * @return Session
     */
    private function startSession()
    {
        $session = new Session();
        $session->setName('ylf_session');
        $session->start();

        if (! $session->has('csrf_token')) {
            $session->set('csrf_token', Str::random(40));
        }

        return $session;
    }

    /**
     * @param Response $response
     * @param SessionInterface $session
     * @return Response|static
     */
    private function withCsrfTokenHeader(Response $response, SessionInterface $session)
    {
        if ($session->has('csrf_token')) {
            $response = $response->withHeader('X-CSRF-Token', $session->get('csrf_token'));
        }

        return $response;
    }

}