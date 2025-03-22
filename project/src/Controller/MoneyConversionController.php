<?php

namespace App\Controller;

use App\Form\Differenza;
use App\Form\Divisione;
use App\Form\Moltiplicazione;
use App\Form\Somma;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MoneyConversionController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/somma')]
    public function somma(Request $request): Response
    {
        $form = $this->createForm(Somma::class);
        $form->handleRequest($request);

        $result = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $addendo_1 = $data['addendo_1'];
            $addendo_2 = $data['addendo_2'];

            $result = $this->calcolaRisultato($addendo_1, $addendo_2, "somma");

        }

        return $this->render('somma.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }

    #[Route('/sottrazione')]
    public function sottrazione(Request $request): Response
    {
        $form = $this->createForm(Differenza::class);
        $form->handleRequest($request);

        $result = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $minuendo = $data['minuendo'];
            $sottraendo = $data['sottraendo'];

            try {
                $result = $this->calcolaRisultato($minuendo, $sottraendo, "differenza");
            } catch (Exception $e) {
                $form->get('sottraendo')->addError(new FormError("Il numero di pound del sottraendo non può essere più grande di quello del sottraendo"));
            }

        }

        return $this->render('differenza.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/moltiplicazione')]
    public function moltiplicazione(Request $request): Response
    {
        $form = $this->createForm(Moltiplicazione::class);
        $form->handleRequest($request);

        $result = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $fattore_1 = $data['fattore_1'];
            $fattore_2 = $data['fattore_2'];
            $result = $this->calcolaRisultato($fattore_1, $fattore_2, "moltiplicazione");

        }

        return $this->render('moltiplicazione.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }

    #[Route('/divisione')]
    public function divisione(Request $request): Response
    {
        $form = $this->createForm(Divisione::class);
        $form->handleRequest($request);

        $result = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $fattore_1 = $data['dividendo'];
            $fattore_2 = $data['divisore'];
            try {
                $result = $this->calcolaRisultato($fattore_1, $fattore_2, "divisione");
            } catch (Exception $e) {
                $form->get('divisore')->addError(new FormError("Non è possibile dividere per 0"));
            }

        }

        return $this->render('divisione.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }

    /**
     * @throws Exception
     */
    private function calcolaRisultato($input1, $input2, $operazione): string
    {
        $total_pound = 0;
        $total_shilling = 0;
        $total_pence = 0;
        $resto = '';

        $parts_1 = explode(' ', $input1);
        $parts_2 = null;

        //ne caso della moltiplicazione il secondo input
        //è solo un int
        if (is_string($input2)) {
            $parts_2 = explode(' ', $input2);
        }

        $pence_1 = $parts_1[2];
        $shilling_1 = $parts_1[1];
        $pound_1 = $parts_1[0];

        if (isset($parts_2)) {
            $pence_2 = $parts_2[2];
            $shilling_2 = $parts_2[1];
            $pound_2 = $parts_2[0];
        }

        switch ($operazione) {
            case "somma":
                $total_pence = ((int)$pence_1 + (int)$pence_2) % 12;
                $riporto_shilling = floor(((int)$pence_1 + (int)$pence_2) / 12);
                $total_shilling = ((int)$shilling_1 + (int)$shilling_2 + $riporto_shilling) % 20;
                $riporto_pound = floor(((int)$shilling_1 + (int)$shilling_2 + $riporto_shilling) / 20);
                $total_pound = (int)$pound_1 + (int)$pound_2 + $riporto_pound;
                break;
            case "differenza":

                if ((int)$pence_1 < (int)$pence_2) {
                    $shilling_1 = (int)$shilling_1 - 1;
                    $pence_1 = (int)$pence_1 + 12;
                }
                $total_pence = (int)$pence_1 - (int)$pence_2;

                if ((int)$shilling_1 < (int)$shilling_2) {
                    $pound_1 = (int)$pound_1 - 1;
                    $shilling_1 = (int)$shilling_1 + 20;
                }
                $total_shilling = (int)$shilling_1 - (int)$shilling_2;

                if ((int)$pound_1 < (int)$pound_2) {
                    throw new Exception("Il sottraendo non può essere piu grande del minuendo");
                }
                $total_pound = (int)$pound_1 - (int)$pound_2;
                break;
            case "moltiplicazione":
                if ($input2 != 0) {
                    $total_pence = ((int)$pence_1 * $input2) % 12;
                    $riporto_shilling = floor(((int)$pence_1 * $input2) / 12);

                    $total_shilling = ((int)$shilling_1 * $input2 + $riporto_shilling) % 20;
                    $riporto_pound = floor(((int)$shilling_1 * $input2 + $riporto_shilling) / 20);

                    $total_pound = ((int)$pound_1 * $input2 + $riporto_pound);
                }
                break;
            case "divisione":
                if ($input2 != 0) {
                    $total_pound = floor((int)$pound_1 / $input2);
                    $riporto_shilling = ((int)$pound_1 % $input2) * 20;

                    $total_shilling = floor(((int)$shilling_1 + (int)$riporto_shilling) / $input2);
                    $riporto_pence = (((int)$shilling_1 + (int)$riporto_shilling) % $input2) * 12;

                    $total_pence = floor(((int)$pence_1 + (int)$riporto_pence) / $input2);
                    $resto_pence = ((int)$pence_1 + (int)$riporto_pence) % $input2;

                    $resto_shilling = floor($resto_pence / 12);
                    $resto_pence = $resto_pence % 12;

                    if ($resto_shilling > 0 || $resto_pence > 0) {
                        $resto = " ($resto_shilling" . "s " . $resto_pence . "d)";
                    }

                } else {
                    throw new Exception("Non è possibile dividere per 0");
                }
        }


        return $total_pound . "p " . $total_shilling . "s " . $total_pence . "d" . $resto;
    }
}