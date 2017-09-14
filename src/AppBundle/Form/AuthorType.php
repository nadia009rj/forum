<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', textType::class, ["label"=>"Prenom", "required"=>true])
            ->add('name', textType::class, ["label"=>"nom", "required"=>true])
            ->add('email', EmailType::class, ["label"=>"Email", "required"=>true])
            ->add('plainPassword', RepeatedType::class,[
                "type"=> passwordType::class,
                "first_options" => ["label" => "votre mot de passe", "required" => true],
                "second_options" => ["label" => "confirmation de mot de passe"]
            ])
            ->add("submit", SubmitType::class, ["label" => "valider"]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Author'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_author';
    }


}
