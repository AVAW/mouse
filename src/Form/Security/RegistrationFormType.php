<?php

namespace App\Form\Security;

use App\Entity\User;
use App\Validator\Captcha;
use App\Validator\UniqueField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', TextType::class, [
                'mapped' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3,
                        'max' => 50,
                    ]),
                    new UniqueField([
                        'entityClass' => User::class,
                        'field' => 'login',
                    ]),
                ],
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => 'user.login',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'email',
                'attr' => [
                    'placeholder' => 'user.email',
                ],
                'constraints' => [
                    new Email(),
                    new UniqueField([
                        'entityClass' => User::class,
                        'field' => 'email',
                    ])
                ],
                'required' => true,
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'password',
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'autofocus' => true,
                    'placeholder' => 'user.password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('captcha', TextType::class, [
                'label' => 'security.captcha',
                'attr' => [
                    'placeholder' => 'security.captcha.enter result',
                ],
                'constraints' => [
                    new Captcha(),
                ],
                'required' => true,
            ])
            ->add('captchaId', HiddenType::class, [
                'required' => true,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'agree terms',
                'constraints' => [
                    new IsTrue(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
