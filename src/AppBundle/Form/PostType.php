<?php

namespace AppBundle\Form;

use AppBundle\Form\Transformer\UploadedFileDataTransformer;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * @var UploadedFileDataTransformer
     */
    private $fileTransformer;

    /**
     * PostType constructor.
     * @param $fileTransformer
     */
    public function __construct($fileTransformer)
    {
        $this->fileTransformer = $fileTransformer;
    }

    /**
     * @ {@inheritdoc}

    */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ["label"=>"titre"])
            ->add('text', CKEditorType::class,[
                "label" => "texte",
                "attr" => ["rows" => 12]

            ])
           /** ->add('author', EmailType::class, ["label" => "Auteur"])
            ->add('createdAt', DateTimeType::class,
                ["label" => "Date de publication", "widget" => "single_text"]
            )**/
            ->add('theme', EntityType::class, [
                "class" => "AppBundle\Entity\Theme",
                "placeholder" => "choisissez un thème",
                "choice_label" => "name"

            ])
            ->add("imageFileName", FileType::class, ["label" => "image", "required"=> false])
            ->add( 'submit', SubmitType::class, ["label"=> "valider"]);

            $builder->addViewTransformer($this->fileTransformer);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_post';
    }


}
