<?php

namespace Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Login form
 *
 * @package Admin\Form
 */
class LoginType extends AbstractType
{
    /**
     * Login form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                EmailType::class,
                [
                    'required' => true,
                    'label' => 'login_form_email_label',
                    'constraints' => [new NotBlank(), new Length(array('min' => 2))]
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'required' => true,
                    'label' => 'login_form_password_label',
                    'constraints' => [
                        new Regex(
                            [
                                'pattern' => "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[ĄąĆćĘęŁłŃńÓóŚśŹźŻż])[A-Za-z\dĄąĆćĘęŁłŃńÓóŚśŹźŻż]{8,}$/",
                                'message' => 'invalid_password_regex'
                            ]
                        )
                    ]
                ]
            );
    }

    /**
     * Options configuration
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'intention' => 'authentication'
            ]
        );
    }
}
