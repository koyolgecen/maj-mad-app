<?php

namespace App\Tests;

use App\Services\DevisService;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * Permet de tester si le prix est bien calculé de Hors taxes vers Toutes Taxes Comprises
     */
    public function testHTToTTC()
    {
        $devisService = new DevisService();
        $result =  $devisService->HTToTTC(100.0);

        $this->assertEquals(120.0, $result);
    }
}
