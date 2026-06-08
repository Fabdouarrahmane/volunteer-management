<?php

namespace App\Tests\Functional\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLoginPageIsAccessible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $client->submitForm('Se connecter', [
            'email' => 'wrong@test.fr',
            'password' => 'wrongpassword',
        ]);

        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert-danger');
    }

    public function testProtectedRouteRedirectsToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');
        $this->assertResponseRedirects('/login');
    }

    public function testBenevoleRouteRedirectsToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/benevole/evenements');
        $this->assertResponseRedirects('/login');
    }
}
