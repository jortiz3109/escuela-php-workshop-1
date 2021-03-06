<?php

namespace Tests\Unit;

use App\Models\Developer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeveloperFiltersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider filtersProvider
     */
    public function testItCanFilterBy(string $field, string $value): void
    {
        Developer::factory()->count(5)->create();
        Developer::factory()->create([$field => $value]);

        $developers = Developer::filter([$field => $value])->get();

        $this->assertEquals(1, $developers->count());
        $this->assertEquals($value, $developers->first()->{$field});
    }

    public function testItCanFilterByStatus(): void
    {
        $enabledAtDate = now()->subDay()->toDateString();
        Developer::factory()->count(5)->create();
        Developer::factory()->create(['enabled_at' => $enabledAtDate]);

        $developers = Developer::filter(['enabled' => true])->get();

        $this->assertEquals(1, $developers->count());
        $this->assertTrue($developers->first()->isEnabled());
        $this->assertEquals($enabledAtDate, $developers->first()->enabled_at->toDateString());
    }

    public function filtersProvider(): array
    {
        return [
            'filter by email' => ['email', 'john.ortiz@evertecinc.com'],
            'filter by name' => ['name', 'John Edisson Ortiz'],
        ];
    }
}
