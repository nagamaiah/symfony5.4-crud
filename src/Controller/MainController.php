<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Crud;
use App\Form\CrudType;
use App\Repository\CrudRepository;


class MainController extends AbstractController
{

    public function __construct(
        public CrudRepository $crudRepo
        )
    {

    }

    // #[Route('/', name: 'app_main')]
    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
        $data = $this->getDoctrine()->getRepository(Crud::class)->findAll();
        // $data = $this->crudRepo->findAll();
        return $this->render('main/index.html.twig', [
            'items' => $data
        ]);
    }

    /**
     * @Route("create", name="create")
     */
    public function create(Request $request): Response
    {
        $crudEntity = new Crud();
        $crudForm = $this->createForm(CrudType::class, $crudEntity);
        $crudForm->handleRequest($request);
        if($crudForm->isSubmitted() && $crudForm->isValid()){
            $entityManager = $this->getDoctrine()->getManager(); 
            $entityManager->persist($crudEntity);
            $entityManager->flush();
            $this->addFlash('msg', 'Created successfully');
            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/create.html.twig', [
            'crud_form' => $crudForm->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods:"GET")]
    public function delete($id): Response
    {
        $data = $this->getDoctrine()->getRepository(Crud::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager(); 
        $entityManager->remove($data);
        $entityManager->flush();
        $this->addFlash('msg', 'Deleted successfully');
        return $this->redirectToRoute('app_main');
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, $id): Response
    {
        $crud = $this->getDoctrine()->getRepository(Crud::class)->find($id);
        $crudForm = $this->createForm(CrudType::class, $crud);
        $crudForm->handleRequest($request);
        if($crudForm->isSubmitted() && $crudForm->isValid()){
            $entityManager = $this->getDoctrine()->getManager(); 
            $entityManager->persist($crud);
            $entityManager->flush();
            $this->addFlash('msg', 'Updated successfully');
            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/update.html.twig', [
            'crud_form' => $crudForm->createView()
        ]);
    }
}
