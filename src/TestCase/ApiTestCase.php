<?php

namespace VolodymyrKlymniuk\TestsBundle\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use VolodymyrKlymniuk\TestsBundle\FixturesTrait;
use VolodymyrKlymniuk\TestsBundle\ResponseAsserter;

abstract class ApiTestCase extends WebTestCase
{
    use FixturesTrait;

    /**
     * @var ResponseAsserter
     */
    private $responseAsserter;

    /**
     * @return ResponseAsserter
     */
    protected function asserter()
    {
        if ($this->responseAsserter === null) {
            $this->responseAsserter = new ResponseAsserter();
        }

        return $this->responseAsserter;
    }

    /**
     * @return null|\Symfony\Component\DependencyInjection\ContainerInterface
     */
    public static function getContainer(): ContainerInterface
    {
        return self::createClient()->getContainer();
    }

    /**
     * @param string $path
     * @param array  $data
     * @param int    $status
     *
     * @return Response
     */
    protected function sendPOST(string $path, array $data = [], int $status = Response::HTTP_OK)
    {
        return $this->sendRequest($path, 'POST', $data, $status);
    }

    /**
     * @param string $path
     * @param array  $data
     * @param int    $status
     *
     * @return Response
     */
    protected function sendGET(string $path, array $data = [], int $status = Response::HTTP_OK)
    {
        return $this->sendRequest($path, 'GET', $data, $status);
    }

    /**
     * @param string $path
     * @param array  $data
     * @param int    $status
     *
     * @return Response
     */
    protected function sendPUT(string $path, array $data = [], int $status = Response::HTTP_OK)
    {
        return $this->sendRequest($path, 'PUT', $data, $status);
    }

    /**
     * @param string $path
     * @param int    $status
     *
     * @return Response
     */
    protected function sendDELETE(string $path, int $status = Response::HTTP_OK)
    {
        return $this->sendRequest($path, 'DELETE', [], $status);
    }

    /**
     * @param string $path
     * @param array  $data
     * @param int    $status
     *
     * @return Response
     */
    protected function sendPATCH(string $path, array $data = [], int $status = Response::HTTP_OK)
    {
        return $this->sendRequest($path, 'PATCH', $data, $status);
    }

    /**
     * @param string $path
     * @param string $method
     * @param array  $data
     * @param int    $status
     *
     * @return Response
     */
    protected function sendRequest(string $path, string $method, array $data = [], int $status = Response::HTTP_OK)
    {
        $client = self::createClient();
        $headers = ['CONTENT_TYPE' => 'application/json'];
        if (in_array('App\Bundle\BaseBundle\Tests\Extension\AuthorizationTrait', class_uses($this)) && null !== $this->getToken()) {
            $headers['HTTP_AUTHORIZATION'] = 'Bearer '.$this->getToken();
        }

        $client->request($method, $path, [], [], $headers, json_encode($data));

        $response = $client->getResponse();

        //check status code
        static::assertEquals($status, $response->getStatusCode(), $response->getContent());

        return $response;
    }

    /**
     * @param string $name
     * @param array  $parameters
     *
     * @return string
     */
    protected function generateUrl(string $name, array $parameters = [])
    {
        return $this->getContainer()->get('router')->generate($name, $parameters);
    }
}