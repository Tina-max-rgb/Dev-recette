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
use App\Entity\Ingredient;
use App\Form\IngredientType;
//use Doctrine\Persistence\ObjectManager;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient', methods: ['GET'])]
    public function index(IngredientRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1)
        );

        if ($pagination instanceof SlidingPaginationInterface) {
            $totalItemCount = $pagination->getTotalItemCount();
            // Vous pouvez également accéder à d'autres méthodes de SlidingPaginationInterface ici si nécessaire
        } else {
            // Gérez le cas où la pagination n'est pas de type SlidingPaginationInterface
            $totalItemCount = 0;
        }

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
        //dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientExisting = $manager->getRepository(Ingredient::class)->findOneBy(['name' => $ingredient->getName()]);
    
            if ($ingredientExisting) {
                // Handle the case where the ingredient with the same name already exists
                $this->addFlash('danger',
                 'Ingredient with this name already exists');
            } else {
                // The ingredient with the same name doesn't exist, proceed to persist and flush
                ('ingredient ajouté');
                $manager->persist($ingredient);
                $manager->flush();
                $this->addFlash('success', 'votre ingrédient à été crée avec succés !');
                // Redirect to the index page
                return $this->redirectToRoute('app_ingredient');
            }
        

        return $this->render('pages/ingredient/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        }

    #[Route('/ingredient/edit/{id}', name: 'ingredient.edit', methods: ['GET', 'POST'])]
    public function edit(IngredientRepository $repository, int $id): Response
    {
        $ingredient = $repository->findOneBy(['id'=>$id]);
        $form = $this->createForm(IngredientType::class, $ingredient);
       return $this->render('pages/ingredient/edit.html.twig',
        ['form' => $form->createView(),
    ]);

        }
    }