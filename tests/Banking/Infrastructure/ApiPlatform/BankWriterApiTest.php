<?php

namespace Tests\Banking\Infrastructure\ApiPlatform;

use Banking\Domain\Repository\Bank\BankEntityRepository;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\Attributes\Group;
use Tests\Core\Infrastructure\ApiPlatform\ApiAbstractTestCase;

#[Group("infrastructure")]
#[Group("bank")]
#[Group("api")]
class BankWriterApiTest extends ApiAbstractTestCase
{
    protected static string $entityName = "Bank";
    protected static string $apiPath = "banking-bank";
    protected static string $repositoryClass = BankEntityRepository::class;

    protected function setUp(): void
    {
        parent::setUp();

        $connection = static::getContainer()->get(Connection::class);
        $connection->executeStatement('TRUNCATE banking_bank CASCADE');
    }

    public function test_post_a_new_bank(): void
    {
        //GIVEN

        //WHEN
        $response = $this->requestPost(
            json: [
                'name' => "test_post_a_new_bank",
                'country' => "FR",
                'url' => "https://maBanque.fr",
                'bic' => "BANKES20ABC",
            ],
            urloptions: '/register'
        );

        //THEN
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame('201');
        $id = $this->getResponseId($response);
        // Asserts action was done
        $response = $this->requestGet($id);
        $this->assertJsonContains([
            'name' => "test_post_a_new_bank",
            'countrycode' => "FR",
            'url' => "https://maBanque.fr",
            'bic' => "BANKES20ABC",
        ]);
    }


    // public function test_remove_an_existing_bank(): void
    // {
    //     //GIVEN
    //     $response = $this->requestPost(
    //         json: [
    //             'name' => "test_remove_an_existing_bank",
    //             'country' => "FR",
    //             'url' => "https://maBanque.fr",
    //             'bic' => "BANKES20ABC",
    //         ]
    //     );
    //     $id = $this->getResponseId($response);

    //     //WHEN
    //     $response = $this->requestDelete($id);

    //     //THEN
    //     $this->assertResponseIsSuccessful();
    //     // Asserts action was done
    //     $response = $this->requestGet($id);
    //     $this->assertResponseStatusCodeSame('404');
    // }

    // public function test_remove_an_non_existing_bank(): void
    // {
    //     //GIVEN
    //     $wrongId = $this->idGenerator->next();

    //     //WHEN
    //     $response = $this->requestDelete($wrongId);

    //     //THEN
    //     $this->assertResponseStatusCodeSame('404');
    // }


    // public function test_enable_an_existing_bank(): void
    // {
    //     //GIVEN
    //     $response = $this->requestPost(
    //         json: [
    //             'name' => "test_enable_an_existing_bank",
    //             'country' => "FR",
    //             'state' => "disabled",
    //             'url' => "https://maBanque.fr",
    //             'bic' => "BANKES20ABC",
    //         ]
    //     );
    //     $id = $this->getResponseId($response);

    //     //WHEN     
    //     $response = $this->requestPost(
    //         id: $id,
    //         urloptions: "/enable"
    //     );
    //     //THEN
    //     $this->assertResponseIsSuccessful();
    //     // Asserts action was done
    //     $response = $this->requestGet($id);
    //     $this->assertJsonContains([
    //         'name' => "test_enable_an_existing_bank",
    //         'country' => "FR",
    //         'state' => "enabled",
    //         'url' => "https://maBanque.fr",
    //         'bic' => "BANKES20ABC",
    //     ]);
    // }

    // public function test_disable_an_existing_bank(): void
    // {
    //     //GIVEN
    //     $response = $this->requestPost(
    //         json: [
    //             'name' => "test_disable_an_existing_bank",
    //             'country' => "FR",
    //             'state' => "enabled",
    //             'url' => "https://maBanque.fr",
    //             'bic' => "BANKES20ABC",
    //         ]
    //     );
    //     $id = $this->getResponseId($response);

    //     //WHEN     
    //     $response = $this->requestPost(
    //         id: $id,
    //         urloptions: "/disable"
    //     );
    //     //THEN
    //     $this->assertResponseIsSuccessful();
    //     // Asserts action was done
    //     $response = $this->requestGet($id);
    //     $this->assertJsonContains([
    //         'name' => "test_disable_an_existing_bank",
    //         'country' => "FR",
    //         'state' => "disabled",
    //         'url' => "https://maBanque.fr",
    //         'bic' => "BANKES20ABC",
    //     ]);
    // }


}