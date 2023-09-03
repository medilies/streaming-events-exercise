<?php

namespace Feature\App\Http\Controllers\Auth\OauthControllerTest;

use Laravel\Socialite\Facades\Socialite;

it('returns 404 when unknown identity provider', function () {
    $response = $this->get(route('auth.redirect', ['idp' => 'x']));

    $response->assertNotFound();
});

it('creates user from data provided by socialite', function () {
    $userData = [
        'name' => fake()->name(),
        'email' => fake()->email(),
    ];

    mockSocialiteUser('github', (object) $userData);

    $response = $this->get(route('auth.callback', ['idp' => 'github']));

    $response->assertOk();
    $this->assertDatabaseHas('users', $userData);
});

function mockSocialiteUser(string $driver, object $mockedUser): void
{
    Socialite::shouldReceive('driver')
        ->once()
        ->with($driver)
        ->andReturnSelf();

    Socialite::shouldReceive('stateless')
        ->once()
        ->andReturnSelf();

    Socialite::shouldReceive('user')
        ->once()
        ->andReturn($mockedUser);
}
