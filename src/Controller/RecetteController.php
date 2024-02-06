<?php
namespace App\Controller;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\SlidingPaginationInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Recette;
use App\Form\RecetteType;

class RecetteController extends AbstractController
{
    #[Route('/recette', name: 'app_recette', methods: ['GET'])]
    public function index(RecetteRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1) 
        );

        $totalItemCount = ($pagination instanceof SlidingPaginationInterface) ? $pagination->getTotalItemCount() : 0;
       
        return $this->render('pages/recette/index.html.twig', [
            'recettes' => $pagination,
            'totalItemCount' => $totalItemCount,
        ]);
    }

    #[Route('/recette/new', name: 'recette.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
    $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientExisting = $manager->getRepository(Recette::class)->findOneBy(['name' => $recette->getName()]);
            if ($recetteExisting) {
                // Handle the case where the ingredient with the same name already exists
                $this->addFlash('danger', 'Recette with this name already exists');
            } else {
                // The ingredient with the same name doesn't exist, proceed to persist and flush
                $this->addFlash('success', 'Votre recette a été créé avec succès');
                $manager->persist($recette);
                $manager->flush();
                
                // Redirect to the index page
                return $this->redirectToRoute('app_recette');
            }
        }

        return $this->render('pages/recette/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/recette/edit/{id}', name: 'recette.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $manager, Recette $recette): Response
    {
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();
            $manager->persist($recette);
            $manager->flush();
            $this->addFlash(
                'success', 
                'Votre recette a été modifié avec succès');
                return $this->redirectToRoute('app_recette');
        }
            return $this->render('pages/recette/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        }


        #[Route('/recette/delete/{id}', name: 'recette.delete', methods: ['GET'])]
        public function delete(Request $request, EntityManagerInterface $manager, Recette $recette): Response
     {
     
        if (!$recette) {
            $this->addFlash(
                'success',
                'Votre recette n/a pas été trouvé',
            );   
            return $this->redirectToRoute('app_recette');
        }
        $manager->remove($recette);
            $manager->flush();
        $this->addFlash(
            'success',
            'Votre recette  a été supprimé avec succés',
        );
        return $this->redirectToRoute('app_recette');

    }
}
