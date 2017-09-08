<?php


namespace AppBundle\Form\Handler;


use AppBundle\Entity\Manager\PostManager;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;

class PostFormHandler
{
    /**
     * @var Post
     */
private $post;

    /**
     * @var string
     */

private $FormClassName;


    /**
     * @var FormFactory
     */

private $formFactory;

    /**
     * @var PostManager
     */
private $manager;


    /**
     * @var RequestStack
     */
private $requestStack;

/**
 *@var Form
 */
private $form;
    /**
     * @var UploadableManager
     */
private $uploadableManager;

    /**
     * PostFormHandler constructor.
     * @param Post $post
     * @param string $FormClassName
     * @param FormFactory $formFactory
     * @param PostManager $manager
     * @param RequestStack $requestStack
     */
    public function __construct(Post $post, $FormClassName,
                                FormFactory $formFactory, PostManager $manager,
                                RequestStack $requestStack, UploadableManager $uploadableManager)
    {
        $this->post = $post;
        $this->FormClassName = $FormClassName;
        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->requestStack = $requestStack;
        $this->uploadableManager = $uploadableManager;


        $this->request = $requestStack->getCurrentRequest();

    }
    public function  process(){
       $this->form = $this->formFactory->create( PostType::class, $this->post);
       $this->form->handleRequest($this->request);

       $success = false;

       if($this->form->isSubmitted() and $this->form->isValid()){
           $success = true;


           if($this->post->getImageFileName() instanceof UploadedFile){
               $this->uploadableManager->markEntityToUpload(
                   $this->post,
                   $this->post->getImageFileName()
               );
           }

           $this->manager->setPost($this->post)->save();
       }
       return $success;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     * @return PostFormHandler
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param mixed $form
     * @return PostFormHandler
     */
    public function setForm($form)
    {
        $this->form = $form;
        return $this;
    }

public function getFormView(){
        return $this->form->createView();

}
}