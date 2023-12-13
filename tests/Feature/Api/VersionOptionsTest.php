<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Option;
use App\Models\Version;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VersionOptionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_version_options(): void
    {
        $version = Version::factory()->create();
        $option = Option::factory()->create();

        $version->options()->attach($option);

        $response = $this->getJson(
            route('api.versions.options.index', $version)
        );

        $response->assertOk()->assertSee($option->name);
    }

    /**
     * @test
     */
    public function it_can_attach_options_to_version(): void
    {
        $version = Version::factory()->create();
        $option = Option::factory()->create();

        $response = $this->postJson(
            route('api.versions.options.store', [$version, $option])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $version
                ->options()
                ->where('options.id', $option->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_options_from_version(): void
    {
        $version = Version::factory()->create();
        $option = Option::factory()->create();

        $response = $this->deleteJson(
            route('api.versions.options.store', [$version, $option])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $version
                ->options()
                ->where('options.id', $option->id)
                ->exists()
        );
    }
}
