<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/categories/create", name="categories.create")
     */
    function create(Request $request)
    {
        $category = new Category();

        $formBuilder = $this->createFormBuilder($category);
        $formBuilder->add("name");
        $formBuilder->add("submit", SubmitType::class);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute("posts.list");
        }

        return $this->render('category/create.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
