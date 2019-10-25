<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\DatabaseTrait;
use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;


class ContactTest extends ApiTestCase
{

    use DatabaseTrait;

    public function testPostWithInvalidEmail()
    {
        $response = static::createClient()->request('POST', '/api/contact', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            'json'    => $this->getData(['email' => 'fake'])
        ]);
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains(['errors' => []]);
        $this->assertArrayHasKey('email', $response->toArray(false)['errors']);
    }

    private function getData($array = []): array
    {
        return array_merge([
            'name'    => 'John Doe',
            'email'   => 'hello@demo.fr',
            'phone'   => '0000000000',
            'message' => 'Je fais un exemple de message'
        ], $array);
    }

    public function testPostWithValidData()
    {
        $client = static::createClient();
        $client->enableProfiler();
        $client->request('POST', '/api/contact', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            'json'    => $this->getData()
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($this->getData());
        /** @var MessageDataCollector $collector */
        $collector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertCount(1, $collector->getMessages());
    }

}
