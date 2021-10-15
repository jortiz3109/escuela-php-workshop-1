<?php

namespace Tests\Feature\API\Developers;

use App\Models\Developer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testItUpdatesADeveloper(): void
    {
        $data = $this->developerData();
        $developer = Developer::factory()->create();
        $response = $this->putJson('/api/developers/' . $developer->getKey(), $data);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('developers', $data);
    }

    public function testItCanPartiallyUpdate(): void
    {
        $developer = Developer::factory()->create();
        $data = ['email' => 'john.ortiz@evertecinc.com'];
        $response = $this->putJson('/api/developers/' . $developer->getKey(), $data);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('developers', $data);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testItValidatesRequestData(string $field, string $value): void
    {
        $data = $this->developerData();
        $developer = Developer::factory()->create($data);

        $response = $this->putJson('/api/developers/' . $developer->getKey(), [$field => $value]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($field);
    }

    public function testItCannotUpdateWithAnEmailNotUnique(): void
    {
        $developers = Developer::factory()->count(2)->create();
        $response = $this->putJson('/api/developers/' . $developers->first()->getKey(), ['email' => $developers->last()->email]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('email');
    }

    public function invalidDataProvider(): array
    {
        return [
            'email filled' => ['email', ' '],
            'email min' => ['email', 'joh@'],
            'email max' => ['email', Str::random(121)],
            'email rfc' => ['email', 'john.ortiz-google'],
            'email dns' => ['email', 'john.ortiz@localhost'],
            'name filled' => ['name', ' '],
            'name min' => ['name', 'john'],
            'name max' => ['name', Str::random(121)],
        ];
    }

    public function developerData(): array
    {
        return [
            'name' => 'John Edisson Ortiz',
            'email' => 'john.ortiz@evertecinc.com',
        ];
    }
}
