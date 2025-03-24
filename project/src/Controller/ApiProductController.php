<?php

namespace App\Controller;

use App\Entity\Prodotto;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            return $this->json(['error' => 'Prodotto con id '. $id .' non trovato'], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['result' => $prodotto]);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/aggiungi-prodotto', name: 'aggiungi_prodotto', methods: ['POST'])]
    public function aggiungiProdotto(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $nome = $data['nome'] ?? null;
        $prezzo = $data['prezzo'] ?? null;
        $descrizione = $data['descrizione'];

        if (!isset($nome)) {
            return $this->json(['error' => "Il campo nome puo essere vuoto"]
                , Response::HTTP_BAD_REQUEST);
        }
        if (!isset($prezzo)) {
            return $this->json(['error' => "Il campo prezzo puo essere vuoto"]
                , Response::HTTP_BAD_REQUEST);
        }

        if(!ApiMoneyConversionController::isValidFormat($prezzo)) {
            return $this->json(['error' => "Il formato del prezzo è errato. Deve essere scritto in questo modo: Xp Ys Zd"]
                , Response::HTTP_BAD_REQUEST);
        }

        $prodotto = new Prodotto();
        $prodotto->setNome($nome);
        $prodotto->setPrezzo($prezzo);

        if (isset($descrizione)) {
            $prodotto->setDescrizione($descrizione);
        }
        $entityManager->persist($prodotto);
        $entityManager->flush();

        return $this->json(['result' => $prodotto]);

    }

    /**
     * @throws Exception
     */
    #[Route('/api/edit/{id}', name: 'api-edit', methods: ['POST'])]
    public function editProdotto(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $prodotto = $entityManager->getRepository(Prodotto::class)->find($id);
        $data = json_decode($request->getContent(), true);

        if (!$prodotto) {
            return $this->json(['error' => 'Prodotto con id ' . $id . ' non trovato'], Response::HTTP_NOT_FOUND);
        }

        $nome = $data['nome'] ?? null;
        $prezzo = $data['prezzo'] ?? null;
        $descrizione = $data['descrizione'] ?? null;

        if (isset($nome)) {
            $prodotto->setNome($nome);
        }
        if(isset($prezzo) && !ApiMoneyConversionController::isValidFormat($prezzo)) {
            return $this->json(['error' => "Il formato del prezzo è errato. Deve essere scritto in questo modo: Xp Ys Zd"]
                , Response::HTTP_BAD_REQUEST);
        }
        if (isset($prezzo)) {
            $prodotto->setPrezzo($prezzo);
        }
        if (isset($descrizione)) {
            $prodotto->setDescrizione($descrizione);
        }

        return $this->json(['result' => $prodotto]);

    }

    #[Route('/api/delete/{id}', name: 'api-delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $prodotto = $entityManager->getRepository(Prodotto::class)->find($id);
        if (!$prodotto) {
            return $this->json(['error' => 'Prodotto con id ' . $id .' non trovato'], Response::HTTP_NOT_FOUND);
        }
        $idAndName = $prodotto->getIdAndName();
        $entityManager->remove($prodotto);
        $entityManager->flush();

        return $this->json(['result' => "Prodotto $idAndName elminato!"], Response::HTTP_OK);

    }
}