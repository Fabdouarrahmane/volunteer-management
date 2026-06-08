<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Benevole;
use PHPUnit\Framework\TestCase;

class BenevoleTest extends TestCase
{
    public function testGetRolesReturnsRoleBenevole(): void
    {
        $benevole = new Benevole();
        $this->assertContains('ROLE_BENEVOLE', $benevole->getRoles());
    }

    public function testGetUserIdentifierReturnsEmail(): void
    {
        $benevole = new Benevole();
        $benevole->setEmail('test@test.fr');
        $this->assertSame('test@test.fr', $benevole->getUserIdentifier());
    }

    public function testSetAndGetNom(): void
    {
        $benevole = new Benevole();
        $benevole->setNom('Dupont');
        $this->assertSame('Dupont', $benevole->getNom());
    }

    public function testSetAndGetEmail(): void
    {
        $benevole = new Benevole();
        $benevole->setEmail('dupont@test.fr');
        $this->assertSame('dupont@test.fr', $benevole->getEmail());
    }

    public function testDisponibilitesCollectionIsEmptyOnConstruct(): void
    {
        $benevole = new Benevole();
        $this->assertCount(0, $benevole->getDisponibilites());
    }

    public function testAffectationsCollectionIsEmptyOnConstruct(): void
    {
        $benevole = new Benevole();
        $this->assertCount(0, $benevole->getAffectations());
    }
}
