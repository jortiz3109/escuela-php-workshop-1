<?php

namespace Tests\Feature\API\Developers;

use App\Models\Developer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanList(): void
    {
        $response = $this->getJson('/api/developers');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testResponseIsJSON(): void
    {
        $response = $this->getJson('/api/developers');

        $response->assertHeader('content-type', 'application/json');
    }

    public function testItReturnsAnArrayOfData(): void
    {
        Developer::factory()->count(15)->create();
        $response = $this->getJson('/api/developers');

        $response->assertJson(fn (AssertableJson $json) => $json->has('data')->etc());
    }

    /**
     * @dataProvider developerProvider
     */
    public function testItReturnDevelopersData(string $name, string $email): void
    {
        Developer::factory()->create(compact('email', 'name'));
        Developer::factory()->count(3)->create();

        $response = $this->getJson('api/developers');

        $response->assertJson(
            fn (AssertableJson $json) => $json->has(
                'data.0',
                fn ($json) => $json->where('name', $name)
                    ->where('email', $email)
                    ->where('created_at', now()->toDateString())
                    ->where('updated_at', now()->toDateString())
                    ->etc()
            )->etc()
        );
    }

    /**
     * @dataProvider developerProvider
     */
    public function testItCanPaginate(string $name, string $email): void
    {
        Developer::factory()->count(20)->create();
        Developer::factory()->create(compact('name', 'email'));

        $response = $this->getJson('/api/developers?page=2');

        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data', 6)
                ->has(
                    'meta',
                    fn ($json) => $json->where('total', 21)
                        ->where('per_page', 15)
                        ->where('current_page', 2)
                        ->etc()
                )
                ->has(
                    'data.5',
                    fn ($json) => $json->where('name', $name)
                        ->where('email', $email)
                        ->etc()
                )
                ->etc()
        );
    }

    /**
     * @dataProvider filtersProvider
     */
    public function testItCanFilter(array $filters): void
    {
        $name = 'John Edisson Ortiz';
        $email = 'john.ortiz@evertecinc.com';

        Developer::factory()->count(10)->create();
        Developer::factory()->create([
            'name' => $name,
            'email' => $email,
            'enabled_at' => now()->subMonth(),
        ]);

        $response = $this->getJson('/api/developers?' . http_build_query(['filters' => $filters]));

        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data', 1)
                ->has(
                    'data.0',
                    fn ($json) => $json->where('name', $name)
                    ->where('email', $email)
                    ->etc()
                )
            ->etc()
        );
    }

    /**
     * @param string|null $enabledAt
     * @dataProvider enabledAtProvider
     */
    public function testItCanFilterByStatus(?string $enabledAt): void
    {
        is_null($enabledAt)
            ? Developer::factory()->disabled()->create()
            : Developer::factory()->enabled($enabledAt)->create();

        $response = $this->getJson('/api/developers?' . http_build_query(['filters' => ['enabled' => $enabledAt ? '1' : '0']]));

        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data', 1)
                ->has(
                    'data.0',
                    fn ($json) => $json->where('enabled_at', $enabledAt)
                        ->etc()
                )
                ->etc()
        );
    }

    public function developerProvider(): array
    {
        return [
            ['name' => 'John Edisson Ortiz', 'email' => 'john.ortiz@evertecinc.com'],
        ];
    }

    public function filtersProvider(): array
    {
        return [
            'find by email' => ['filters' => ['email' => 'john.ortiz@evertecinc.com']],
            'find by name' => ['filters' => ['name' => 'John Edisson Ortiz']],
            'find by enabled_at' => ['filters' => ['enabled_at' => now()->subMonth()->toDateString()]],
        ];
    }

    public function enabledAtProvider(): array
    {
        return [
            'developer is enabled' => ['enabled_at' => now()->subMonth()->toDateString()],
            'developer is not enabled' => ['enabled_at' => null],
        ];
    }
}
