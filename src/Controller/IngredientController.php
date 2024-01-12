<?php
namespace App\Controller;
use App\Repository\IngredientRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\SlidingPaginationInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ingredient;
use App\Form\IngredientType; 

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient', methods: ['GET'])]
    public function index(IngredientRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
        $repository->findAll(),
        $request->query->getInt('page', 1), 
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
    
    public function new(Request $request): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form -> handleRequest($request);
        //$request=>handleRequest();
       // $request(m);
         //$div=>gic(200);

       // $form-> hndleRequest ($form);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd ($form);
        }else{
       $ingredient =$form->getData();
       $manager->persist($ingredient); 
       $manager->flush();
       $this->redirectToRoute('app_ingredient');
       }
        
        return $this->render('pages/ingredient/new.html.twig', [
            'form' => $form->createView(),
        ]);

}
}

   
    