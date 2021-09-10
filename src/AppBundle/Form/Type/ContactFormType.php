<?php

namespace AppBundle\Form\Type;

use AppBundle\Contact\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'translation_domain' => 'form',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'contact.email.label',
            ])
            ->add('subject', TextType::class, [
                'label' => 'contact.subject.label',
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'contact.content.label',
            ])
            ->add('send', SubmitType::class, [
                'label' => 'contact.send.label',
            ])
        ;
    }
}
