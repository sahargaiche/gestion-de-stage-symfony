<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\User;
use App\Entity\Stage;
use App\Entity\VerifiedCandidate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use Doctrine\ORM\EntityManagerInterface;



class DashboardController extends AbstractDashboardController
{
  private EntityManagerInterface $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
      $this->entityManager = $entityManager;
  }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
      $candidateCount = $this->entityManager->getRepository(Candidate::class)->count([]);
      $subjectCount = $this->entityManager->getRepository(Stage::class)->count([]);
      $validSubjectCount = $this->entityManager->getRepository(VerifiedCandidate::class)->count(['statut' => 'verifie']);

      return $this->render('EasyAdminBundle/home.html.twig', [
        'candidateCount' => $candidateCount,
        'subjectCount' => $subjectCount,
        'validSubjectCount' => $validSubjectCount,
    ]);
  }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Project Symfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        

        yield MenuItem::subMenu('Utilisateur', 'fas fa-user')->setSubItems([
            MenuItem::linkToCrud('Créer un utilisateur', 'fas fa-plus', User::class)
              ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des utilisateurs', 'fas fa-eye', User::class)
              ->setAction(Crud::PAGE_INDEX),
              ]);
        yield MenuItem::subMenu('Stage', 'fa fa-home')->setSubItems([
            MenuItem::linkToCrud('Créer un Stage', 'fas fa-plus', Stage::class)
              ->setAction(Crud::PAGE_NEW),     
            MenuItem::linkToCrud('Liste des Stages', 'fas fa-eye', Stage::class)
              ->setAction(Crud::PAGE_INDEX), 
            ]);
            yield MenuItem::subMenu('Candidate', 'fas fa-user')->setSubItems([    
                MenuItem::linkToCrud('Liste des Stages', 'fas fa-eye', Candidate::class)
                  ->setAction(Crud::PAGE_INDEX), 
                ]);
                yield MenuItem::subMenu('Verified', 'fa fa-home')->setSubItems([    
                  MenuItem::linkToCrud('Liste des verification', 'fas fa-eye', VerifiedCandidate::class)
                    ->setAction(Crud::PAGE_INDEX), 
                  ]);
              }

    public function configureActions(): Actions
    {
        return Actions::new()
            ->add(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DELETE)

            ->add(Crud::PAGE_DETAIL, Action::EDIT)
            ->add(Crud::PAGE_DETAIL, Action::INDEX)
            ->add(Crud::PAGE_DETAIL, Action::DELETE)

            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

            ->add(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER);
    }
}

