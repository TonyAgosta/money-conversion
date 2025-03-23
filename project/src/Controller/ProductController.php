<?php

namespace App\Controller;

use App\Entity\Prodotto;
use App\Form\ProdottoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/prodotto', name: 'prodotto')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/aggiungi-prodotto', name: 'crea_prodotto')]
    public function creaProdotto(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Prodotto();

        $form = $this->createForm(ProdottoType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Il prodotto ' . $product->getIdAndName() .' è stato aggiunto con successo');
            return $this->redirectToRoute('catalogo');
        }

        return $this->render('product/crea.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/prodotto/edit/{id}', name: 'modifica_prodotto')]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Prodotto::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'Nessun prodotto con id ' . $id . ' trovato!'
            );
        }

        $form = $this->createForm(ProdottoType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Il prodotto ' . $product->getIdAndName() .' è stato modificato con successo');
            return $this->redirectToRoute('catalogo');
        }

        return $this->render('product/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/delete/{id}', name: 'elimina_prodotto')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Prodotto::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'Nesun prodotto con id '. $product->getId() . 'trovato!'
            );
        }
        $this->addFlash('success', 'Il prodotto ' . $product->getIdAndName() .' è stato eliminato con successo') ;
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('catalogo');
    }

    #[Route('/prodotto/{id}', name: 'mostra_prodotto')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Prodotto::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'Nessun prodotto con il codice ' . $id . ' trovato'
            );
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }



    #[Route('/catalogo', name: 'catalogo')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $prodotti = $entityManager->getRepository(Prodotto::class)->findAll();

        return $this->render('product/catalogo.html.twig', [
            'prodotti' => $prodotti
        ]);
    }

}
