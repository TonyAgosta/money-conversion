<?php

namespace App\Controller;

use App\Entity\Prodotto;
use App\Form\Differenza;
use App\Form\Divisione;
use App\Form\Moltiplicazione;
use App\Form\Somma;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiProductController extends AbstractController
{
    /**
     * @throws Exception
     */


    #[Route('/api/list', methods: ['GET'])]
    public function catalogo(EntityManagerInterface $entityManager): Response
    {
        $prodotti = $entityManager->getRepository(Prodotto::class)->findAll();
        return $this->json(['result' => $prodotti]);
    }

    #[Route('/api/prodotto/{id}', name: 'prodotto', methods: ['GET'])]
    public function getProdotto(EntityManagerInterface $entityManager, int $id): Response
    {
        $prodotto = $entityManager->getRepository(Prodotto::class)->find($id);

        if (!$prodotto) {
            return $this->json(['error' => 'Prodotto non trovato'], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['result' => $prodotto]);
    }


    /**
     * @throws Exception
     */
    #[Route('/api/edit/{id}', name: 'edit', methods: ['POST'])]
    public function editProdotto(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $prodotto = $entityManager->getRepository(Prodotto::class)->find($id);
        $data = json_decode($request->getContent(), true);

        if (!$prodotto) {
            return $this->json(['error' => 'Prodotto non trovato'], Response::HTTP_NOT_FOUND);
        }

        $nome = $data['nome'];
        $prezzo = $data['prezzo'] ?? 0;
        $descrizione = $data['descrizione'];

        if(isset($nome)) {
            $prodotto->setNome($nome);
        }
        if(isset($prezzo)) {
            $prodotto->setPrezzo($prezzo);
        }
        if(isset($descrizione)){
            $prodotto->setDescrizione($descrizione);
        }

        return $this->json(['result' => $prodotto]);

    }

    #[Route('/api/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $prodotto = $entityManager->getRepository(Prodotto::class)->find($id);
        if (!$prodotto) {
            return $this->json(['error' => 'Prodotto non trovato'], Response::HTTP_NOT_FOUND);
        }
        $idAndName = $prodotto->getIdAndName();
        $entityManager->remove($prodotto);
        $entityManager->flush();

        return $this->json(['error' => "Prodotto $idAndName elminato!"], Response::HTTP_OK);

    }
}