<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiMoneyConversionController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/api/somma', name: 'somma', methods: ['POST'])]
    public function somma(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $addendo_1 = $data['addendo_1'] ?? 0;
        $addendo_2 = $data['addendo_2'] ?? 0;

        try {
            $result = MoneyConversionController::calcolaRisultato($addendo_1, $addendo_2, "somma");
            return $this->json(['result' => $result]);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/sottrazione', name: 'sottrazione', methods: ['POST'])]
    public function sottrazione(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $addendo_1 = $data['minuendo'] ?? 0;
        $addendo_2 = $data['sottraendo'] ?? 0;

        try {
            $result = MoneyConversionController::calcolaRisultato($addendo_1, $addendo_2, "differenza");
            return $this->json(['result' => $result]);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @throws Exception
     */
    #[Route('/api/moltiplicazione', name: 'moltiplicazione', methods: ['POST'])]
    public function moltiplicazione(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $addendo_1 = $data['fattore_1'] ?? 0;
        $addendo_2 = $data['fattore_2'] ?? 0;

        try {
            $result = MoneyConversionController::calcolaRisultato($addendo_1, $addendo_2, "moltiplicazione");
            return $this->json(['result' => $result]);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/divisione', name: 'divisione', methods: ['POST'])]
    public function divisione(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $addendo_1 = $data['dividendo'] ?? 0;
        $addendo_2 = $data['divisore'] ?? 0;

        try {
            $result = MoneyConversionController::calcolaRisultato($addendo_1, $addendo_2, "divisione");
            return $this->json(['result' => $result]);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}