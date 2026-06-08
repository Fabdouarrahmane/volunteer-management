<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Evenement;
use PHPUnit\Framework\TestCase;

class EvenementTest extends TestCase
{
    public function testSetAndGetTitre(): void
    {
        $evenement = new Evenement();
        $evenement->setTitre('Marché solidaire');
        $this->assertSame('Marché solidaire', $evenement->getTitre());
    }

    public function testSetAndGetStatut(): void
    {
        $evenement = new Evenement();
        $evenement->setStatutEvenement('planifie');
        $this->assertSame('planifie', $evenement->getStatutEvenement());
    }

    public function testSetAndGetNbBenevoles(): void
    {
        $evenement = new Evenement();
        $evenement->setNbBenevoles(10);
        $this->assertSame(10, $evenement->getNbBenevoles());
    }

    public function testAffectationsCollectionIsEmptyOnConstruct(): void
    {
        $evenement = new Evenement();
        $this->assertCount(0, $evenement->getAffectations());
    }
}
