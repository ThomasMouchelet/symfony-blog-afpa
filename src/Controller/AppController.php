<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AppController extends AbstractController
{
    /**
     * @Route("/", name="posts.list")
     */
    public function index(PostRepository $repo): Response
    {
        $post_list = $repo->findAll();

        return $this->render('app/index.html.twig', [
            "post_list" => $post_list
        ]);
    }

    /**
     * @Route("/posts/add", name="posts.create")
     */
    public function create(Request $request)
    {
        $post = new Post();

        $formBuilder = $this->createFormBuilder($post);
        $formBuilder
            ->add("title")
            ->add("content")
            ->add("categories", EntityType::class, [
                "class" => Category::class,
                'label'         => 'Categories',
                'choice_label'  => 'name',
                'multiple'      => true,
                'expanded'      => true,
            ])
            ->add("submit", SubmitType::class);
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute("posts.list");
        }

        return $this->render("app/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/posts/{id}", name="posts.show")
     */
    public function show(PostRepository $repo, Request $request, Post $post)
    {
        // $post = $repo->findOneBy(["id" => $request->attributes->get("id")]);
        return $this->render('app/show.html.twig', [
            "post" => $post
        ]);
    }
}
