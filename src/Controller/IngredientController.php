<?php

namespace App\Controller;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\SlidingPaginationInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Ingredient;
use App\Form\IngredientType;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient', methods: ['GET'])]
    public function index(IngredientRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1)
        );

        $totalItemCount = ($pagination instanceof SlidingPaginationInterface) ? $pagination->getTotalItemCount() : 0;

        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients' => $pagination,
            'totalItemCount' => $totalItemCount,
        ]);
    }

    #[Route('/ingredient/new', name: 'ingredient.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientExisting = $manager->getRepository(Ingredient::class)->findOneBy(['name' => $ingredient->getName()]);

            if ($ingredientExisting) {
                // Handle the case where the ingredient with the same name already exists
                $this->addFlash('danger', 'Ingredient with this name already exists');
            } else {
                // The ingredient with the same name doesn't exist, proceed to persist and flush
                $this->addFlash('success', 'Votre ingrédient a été créé avec succès');
                $manager->persist($ingredient);
                $manager->flush();
                
                // Redirect to the index page
                return $this->redirectToRoute('app_ingredient');
            }
        }

        return $this->render('pages/ingredient/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ingredient/edit/{id}', name: 'ingredient.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $manager, Ingredient $ingredient): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();
            $manager->persist($ingredient);
            $manager->flush();
            $this->addFlash(
                'success', 
                'Votre ingrédient a été modifié avec succès');

            return $this->redirectToRoute('app_ingredient');
        }
            return $this->render('pages/ingredient/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        #[Route('/ingredient/delete/{id}', name: 'ingredient.delete', methods: ['GET'])]
        public function delete(Request $request, EntityManagerInterface $manager, Ingredient $ingredient): Response
    {
     
        if (!$ingredient) {
            $this->addFlash(
                'success',
                'Votre ingrédient n/a pas été trouvé',
            );
            
            return $this->redirectToRoute('app_ingredient');
        }
        $manager->remove($ingredient);
            $manager->flush();
        $this->addFlash(
            'success',
            'Votre ingrédient  a été supprimé avec succés',
        );
        return $this->redirectToRoute('app_ingredient');

    }
}
