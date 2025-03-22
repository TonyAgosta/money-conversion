<?php

namespace App\Controller;

use App\Form\Somma;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MoneyConversionController extends AbstractController
{
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

            $result = $this->calcolaRisultato($addendo_1, $addendo_2);

        }

        return $this->render('somma.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }

    private function calcolaRisultato($addendo1, $addendo2)
    {
        $parts_addendo_1 = explode(' ', $addendo1);
        $parts_addendo_2 = explode(' ', $addendo2);

        $pence_1 = $parts_addendo_1[2];
        $shilling_1 = $parts_addendo_1[1];
        $pound_1 = $parts_addendo_1[0];

        $pence_2 = $parts_addendo_2[2];
        $shilling_2 = $parts_addendo_2[1];
        $pound_2 = $parts_addendo_2[0];


        $total_pence = ((int)$pence_1 + (int)$pence_2) % 12;
        $riporto_shilling = floor(((int)$pence_1 + (int)$pence_2) / 12);
        $total_shilling = ((int)$shilling_1 + (int)$shilling_2 + $riporto_shilling) % 20;
        $riporto_pound = floor(((int)$shilling_1 + (int)$shilling_2 + $riporto_shilling) / 20);
        $total_pound = (int)$pound_1 + (int)$pound_2 + $riporto_pound;
        return $total_pound . "p " . $total_shilling . "s " . $total_pence . "d";
    }

    #[Route('/sottrazione')]
    public function sottrazione(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

    #[Route('/moltiplicazione')]
    public function moltiplicazione(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

    #[Route('/divisione')]
    public function divisione(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }
}