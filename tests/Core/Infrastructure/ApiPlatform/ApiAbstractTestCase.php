<?php

namespace Tests\Core\Infrastructure\ApiPlatform;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use ApiPlatform\Symfony\Bundle\Test\Response;
use Core\Infrastructure\Doctrine\DoctrineIdGenerator;
use Core\Infrastructure\InMemory\IntIdGenerator;
use Core\Service\IdGenerator;

abstract class ApiAbstractTestCase extends ApiTestCase
{
    // protected IdGenerator $idGenerator;
    /**
     * Neme of the Entity class
     */
    protected static string $entityName = "";
    /**
     * api path string
     * /api/{apiPath}/
     * @example parties
     */
    protected static string $apiPath = "";
    /**
     * name of the repository class
     * 
     * @example PartRepository::class
     */
    protected static string $repositoryClass = "";
    /**
     * name of the apiplatform ressouce class
     * 
     * @example ApiResource::class
     */
    protected static string $ressourceClass = "";

    protected $client;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel([
            'environment' => 'test',
            'debug' => false,
        ]);
    }

    protected function setUp(): void
    {
        // // ensure a fresh cache when debug mode is disabled
        // (new \Symfony\Component\Filesystem\Filesystem())->remove(__DIR__ . '/../var/cache/test');

        // (1) boot the Symfony kernel
        // self::bootKernel([
        //     'environment' => 'test',
        //     'debug' => false,
        // ]);

        //warning static::createClient(); MUST BE called at the begining, else non-unique repository are created by container
        $this->client = $this->getLoginClient();

        //$this->idGenerator = $this->getContainer()->get(DoctrineIdGenerator::class);
        // $this->idGenerator = $this->getContainer()->get(IntIdGenerator::class);
    }


    public function getLoginClient(string $email = 'test@mail.com', string $password = 'user'): Client
    {
        //keep same client on all test function, to keep connection open
        $client = static::createClient();
        //login
        // $client->request('POST', '/api/login', [
        //     'headers' => ['Content-Type' => 'application/json'],
        //     'json' => [
        //         'email' => $email,
        //         'password' => $password
        //     ],
        // ]);
        return $client;
    }


    public function request(string $method, string $urloptions = "", array $json = [], $contentType = 'application/ld+json'): Response
    {
        $options = [
            'headers' => ['Content-Type' => $contentType],
            'json' => $json
        ];
        $url = '/api/' . static::$apiPath;
        return $this->client->request($method, $url . $urloptions, $options);
    }

    public function requestGet($id = null, string $urloptions = ""): Response
    {
        if (is_null($id)) {
            return $this->request('GET', $urloptions);
        } else {
            return $this->request('GET', "/$id$urloptions");
        }
    }

    public function requestPost($id = null, array $json = [], string $urloptions = ""): Response
    {
        if ($id) {
            return $this->request('POST', "/$id$urloptions", $json);
        } else {
            return $this->request('POST', "$urloptions", $json);
        }
    }

    public function requestPut($id = null, array $json = []): Response
    {
        return $this->request('PUT', "/$id", $json);
    }

    public function requestPatch($id = null, array $json = []): Response
    {
        return $this->request('PATCH', "/$id", $json, 'application/merge-patch+json');
    }

    public function requestDelete($id = null): Response
    {
        return $this->request('DELETE', "/$id");
    }

    /**
     * Asserts
     * 
     */


    // public static function checkResponseIsRessource(string $id, string $message = ''): void
    // {
    //     self::assertJsonContains([
    //         '@context' => "/api/contexts/" . static::$entityName,
    //         '@id' => "/api/" . static::$apiPath . "/$id",
    //         '@type' => static::$entityName,
    //     ]);

    // }

    public static function AssertResponseIsCollection(Response $response, string $message = ''): void
    {
        self::assertJsonContains([
            '@context' => "/api/contexts/" . static::$entityName,
            '@id' => "/api/" . static::$apiPath,
            '@type' => 'hydra:Collection',
        ]);

        $res = $response->toArray();
        self::assertArrayHasKey("hydra:totalItems", $res);
        self::assertArrayHasKey("hydra:member", $res);
    }
    public static function AssertResponseTotalItemsEqual(Response $response, int $total, string $message = ''): void
    {
        self::assertJsonContains([
            "hydra:totalItems" => $total,
        ]);
    }

    public static function assertMembersAreIri(Response $response, string $message = ''): void
    {
        $id = $response->toArray()['@id'];
        $member = $response->toArray()['hydra:member'][0];

        self::assertStringStartsWith($id, $member, $member . ' is not a valid Iri : ' . $id);
    }

    public static function getResponseId(Response $response): string
    {
        $response->getContent();
        $uuid = $response->getContent();

        return trim($uuid, '"');
    }

    // public static function assertMembersAreList(Response $response, string $message = ''): void
    // {
    //     $member = $response->toArray()['hydra:member'][0];

    //     static::assertArrayHasKey('@type', $member);
    //     static::assertArrayHasKey('@id', $member);
    //     static::assertArrayHasKey('toString', $member);
    // }
}