<?php

namespace Tests\Feature\API\Developers;

use App\Mail\Welcome;
use App\Models\Developer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider developerProvider
     */
    public function testItStoresADeveloper(string $name, string $email): void
    {
        $response = $this->postJson('/api/developers', compact('name', 'email'));

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('developers', compact('name', 'email'));
    }

    /**
     * @dataProvider developerProvider
     */
    public function testItSendWelcomeEmailWhenDeveloperIsCreated(string $name, string $email): void
    {
        Mail::fake();
        $this->postJson('/api/developers', compact('name', 'email'));
        Mail::assertSent(Welcome::class);
    }

    /**
     * @dataProvider developerProvider
     */
    public function testItLogsDeveloperCreation(string $name, string $email): void
    {
        Log::swap(new LogFake());
        $this->postJson('/api/developers', compact('name', 'email'));
        Log::assertLogged('info', function (string $message) {
            return 'New developer created' === $message;
        });
    }

    /**
     * @dataProvider developerProvider
     */
    public function testItResponseDeveloperData(string $name, string $email): void
    {
        $response = $this->postJson('/api/developers', compact('name', 'email'));

        $response->assertJson(
            fn (AssertableJson $json) => $json->where('name', $name)
                ->where('email', $email)
                ->has('id')
                ->etc()
        );
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testItValidatesRequestData(string $name, string $email, string $field): void
    {
        $response = $this->postJson('/api/developers', compact('name', 'email'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($field);
    }

    /**
     * @dataProvider developerProvider
     */
    public function testEmailIsUnique(string $name, string $email): void
    {
        Developer::factory()->create(compact('name', 'email'));

        $this->testItValidatesRequestData($name, $email, 'email');
    }

    public function invalidDataProvider(): array
    {
        $data = $this->developerProvider()['developer'];

        return [
            'email required' => array_merge($data, ['email' => '', 'field' => 'email']),
            'email min' => array_merge($data, ['email' => 'joh@', 'field' => 'email']),
            'email max' => array_merge($data, ['email' => Str::random(121), 'field' => 'email']),
            'email rfc' => array_merge($data, ['email' => 'john.ortiz-google', 'field' => 'email']),
            'email dns' => array_merge($data, ['email' => 'john.ortiz@localhost', 'field' => 'email']),
            'name required' => array_merge($data, ['name' => '', 'field' => 'name']),
            'name min' => array_merge($data, ['name' => 'john', 'field' => 'name']),
            'name max' => array_merge($data, ['name' => Str::random(121), 'field' => 'name']),
        ];
    }

    public function developerProvider(): array
    {
        return [
            'developer' => [
                'name' => 'John Edisson Ortiz',
                'email' => 'john.ortiz@evertecinc.com',
            ],
        ];
    }
}
