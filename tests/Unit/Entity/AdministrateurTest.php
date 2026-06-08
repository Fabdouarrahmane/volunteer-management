<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Administrateur;
use PHPUnit\Framework\TestCase;

class AdministrateurTest extends TestCase
{
    public function testGetRolesReturnsRoleAdmin(): void
    {
        $admin = new Administrateur();
        $this->assertContains('ROLE_ADMIN', $admin->getRoles());
    }

    public function testGetUserIdentifierReturnsEmail(): void
    {
        $admin = new Administrateur();
        $admin->setEmail('admin@test.fr');
        $this->assertSame('admin@test.fr', $admin->getUserIdentifier());
    }

    public function testSetAndGetNom(): void
    {
        $admin = new Administrateur();
        $admin->setNom('Martin');
        $this->assertSame('Martin', $admin->getNom());
    }

    public function testEvenementsCollectionIsEmptyOnConstruct(): void
    {
        $admin = new Administrateur();
        $this->assertCount(0, $admin->getEvenements());
    }
}
