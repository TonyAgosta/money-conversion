<?php

namespace App\Tests\Controller;

use App\Controller\MoneyConversionController;
use Exception;
use PHPUnit\Framework\TestCase;

class MoneyConversionControllerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testSomma()
    {
        $result = MoneyConversionController::calcolaRisultato("5p 10s 8d", "2p 15s 6d", "somma");
        $this->assertEquals("8p 6s 2d", $result);
    }

    /**
     * @throws Exception
     */
    public function testDifferenza()
    {
        $result = MoneyConversionController::calcolaRisultato("5p 10s 8d", "2p 5s 4d", "differenza");
        $this->assertEquals("3p 5s 4d", $result);
    }

    public function testDifferenzaNegativa()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Il sottraendo non può essere piu grande del minuendo");
        MoneyConversionController::calcolaRisultato("2p 5s 4d", "5p 10s 8d", "differenza");
    }

    /**
     * @throws \Exception
     */
    public function testMoltiplicazione()
    {
        $result = MoneyConversionController::calcolaRisultato("2p 10s 6d", 3, "moltiplicazione");
        $this->assertEquals("7p 11s 6d", $result);
    }

    /**
     * @throws Exception
     */
    public function testDivisione()
    {
        $result = MoneyConversionController::calcolaRisultato("5p 10s 8d", 2, "divisione");
        $this->assertEquals("2p 15s 4d", $result);
    }

    public function testDivisionePerZero()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Non è possibile dividere per 0");
        MoneyConversionController::calcolaRisultato("5p 10s 8d", 0, "divisione");
    }


}
