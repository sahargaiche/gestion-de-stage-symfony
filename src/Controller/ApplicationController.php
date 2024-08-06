<?php

// src/Controller/ApplicationController.php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Stage;
use App\Entity\VerifiedCandidate;
use App\Form\CandidateType;
use App\Form\StageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\CandidateRepository;


class ApplicationController extends AbstractController
{
    
    /**
     * @Route("/", name="home")
     */
    #[Route(path: "/index/{id}", name: "home")]

    public function index($id):Response
    {
        return $this->render('index.html.twig',['id'=>$id]);
    }

    #[Route(path: "/", name: "indexx")]
    public function indexx():Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/apply", name="apply")
     */
    #[Route(path: "/apply", name: "apply")]
    public function apply(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidate = new Candidate();
        $stage = new Stage();

        $form = $this->createForm(CandidateType::class, $candidate);
        //$stageForm = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);
       // $stageForm->handleRequest($request);
//&& $stageForm->isSubmitted() && $stageForm->isValid()
        if ($form->isSubmitted() && $form->isValid() ) {
            // Upload CV
            $cvFile = $form['cv']->getData();
            if ($cvFile) {
                $cvFilename = uniqid().'.'.$cvFile->guessExtension();
                $cvFile->move(
                    $this->getParameter('cv_directory'),
                    $cvFilename
                );
                $candidate->setCv($cvFilename);
            }

            //$stage->setCandidate($candidate);

            $entityManager->persist($candidate);
            $verified=new VerifiedCandidate();
            $verified->setCandidate($candidate);
            $verified->setStage($candidate->getStage());

            $entityManager->persist($verified);
            //$entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('home',['id'=>$candidate->getId()]);
        }

        return $this->render('application/apply.html.twig', [
            'form' => $form->createView(),
          //  'stageForm' => $stageForm->createView(),
        ]);
    }
  /**
 * @Route("/ExportPdf/{id}", name="app_user_pdf", methods={"GET"}, requirements={"id"="\d+"})
 */
#[Route('/ExportPdf/{id}', name: 'app_user_pdf', methods: ['GET'])]

public function exportPdf(int $id = null, CandidateRepository $candidateRepository): Response
{
    if ($id === null) {
        throw $this->createNotFoundException('Candidate ID is required');
    }

    $candidate = $candidateRepository->find($id);

    if (!$candidate) {
        throw $this->createNotFoundException('Candidate not found');
    }

    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);

    $html = $this->renderView('pdf.html.twig', [
        'candidate' => $candidate,
    ]);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $pdfFilename = 'candidate_' . $candidate->getId() . '_confirmation.pdf';
    return new Response($dompdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . $pdfFilename . '"',
    ]);
}
}

