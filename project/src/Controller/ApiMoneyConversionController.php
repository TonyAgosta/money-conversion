<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiMoneyConversionController extends AbstractController
{
    public static function isValidFormat($input): false|int
    {
        return preg_match('/^\d+p \d+s \d+d$/', $input);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/somma', name: 'somma', methods: ['POST'])]
    public function somma(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $addendo_1 = $data['addendo_1'];
        $addendo_2 = $data['addendo_2'];

        if (!isset($addendo_1) || !isset($addendo_2)) {
            return $this->json(['error' => "I campi addendo_1 e addendo_2 non possono essere lasciati vuoti"]
                , Response::HTTP_BAD_REQUEST);
        }


        if (!self::isValidFormat($addendo_1)) {
            return $this->json(['error' => "Il formato del primo addendo è errato. Deve essere scritto in questo modo: Xp Ys Zd"]
                , Response::HTTP_BAD_REQUEST);
        }
        if (!self::isValidFormat($addendo_2)) {
            return $this->json(['error' => "Il formato del secondo addendo è errato. Deve essere scritto in questo modo: Xp Ys Zd"]
                , Response::HTTP_BAD_REQUEST);
        }

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

        $minuendo = $data['minuendo'];
        $sottraendo = $data['sottraendo'];


        if (!isset($minuendo) || !isset($sottraendo)) {
            return $this->json(['error' => "I campi minuendo e sottraendo non possono essere lasciati vuoti"]
                , Response::HTTP_BAD_REQUEST);
        }

        if (!self::isValidFormat($minuendo)) {
            return $this->json(['error' => "Il formato del minuendo è errato. Deve essere scritto in questo modo: Xp Ys Zd"]
                , Response::HTTP_BAD_REQUEST);
        }
        if (!self::isValidFormat($sottraendo)) {
            return $this->json(['error' => "Il formato del sottraendo è errato. Deve essere scritto in questo modo: Xp Ys Zd"]
                , Response::HTTP_BAD_REQUEST);
        }

        try {
            $result = MoneyConversionController::calcolaRisultato($minuendo, $sottraendo, "differenza");
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

        $fattore_1 = $data['fattore_1'];
        $fattore_2 = $data['fattore_2'];

        if (!isset($fattore_1) || !isset($fattore_2)) {
            return $this->json(['error' => "I campi fattore_1 e fattore_2 non possono essere lasciati vuoti"]
                , Response::HTTP_BAD_REQUEST);
        }


        if (!self::isValidFormat($fattore_1)) {
            return $this->json(['error' => "Il formato del primo fattore è errato. Deve essere scritto in questo modo: Xp Ys Zd"]
                , Response::HTTP_BAD_REQUEST);
        }

        if (!is_numeric($fattore_2)) {
            return $this->json(['error' => "Il secondo fattore deve essere un intero"]
                , Response::HTTP_BAD_REQUEST);
        }

        try {
            $result = MoneyConversionController::calcolaRisultato($fattore_1, $fattore_2, "moltiplicazione");
            return $this->json(['result' => $result]);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/divisione', name: 'divisione', methods: ['POST'])]
    public function divisione(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $dividendo = $data['dividendo'];
        $divisore = $data['divisore'];

        if (!self::isValidFormat($dividendo)) {
            return $this->json(['error' => "Il formato del dividendo è errato. Deve essere scritto in questo modo: Xp Ys Zd"]
                , Response::HTTP_BAD_REQUEST);
        }

        if ($divisore == 0) {
            return $this->json(['error' => "Il divisore deve essere maggiore di zero"]
                , Response::HTTP_BAD_REQUEST);
        }

        try {
            $result = MoneyConversionController::calcolaRisultato($dividendo, $divisore, "divisione");
            return $this->json(['result' => $result]);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}