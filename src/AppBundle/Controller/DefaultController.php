<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository("AppBundle:Theme");
        $postRepository =$this->getDoctrine()
            ->getRepository("AppBundle:Post");

        $list = $repository->getAllTheme()->getArrayResult();
        $postListByYear = $postRepository->getPostsGroupedByYear();

        //creation de formulaire
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        return $this->render('default/index.html.twig', [

            "themeList" => $list,"postList"=>$postListByYear,
            "postForm" => $form->createView()

        ]);
    }

    /**
     * @Route("/theme/{id}", name="theme_details", requirements={"id":"\d+"})
     * @param $id
     * @return Response
     */
    public function themeAction($id){

        $repository = $this->getDoctrine()
            ->getRepository("AppBundle:Theme");
        $postRepository =$this->getDoctrine()
            ->getRepository("AppBundle:Post");

        $theme = $repository->find($id);
       $postList = $theme->getPosts();



        return $this->render('default/theme.html.twig', [

            "theme" => $theme,"postList"=>$postList

        ]);
    }
}
