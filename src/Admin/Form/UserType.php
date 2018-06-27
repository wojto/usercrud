<?php

namespace Admin\Form;

use Admin\Command\UpdateUserCommand;
use Crud\Domain\Model\Role;
use Crud\Domain\Repository\RoleRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * User form
 *
 * @package Admin\Form
 */
class UserType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * BundleType constructor.
     * @param TranslatorInterface $translator
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(TranslatorInterface $translator, RoleRepositoryInterface $roleRepository)
    {
        $this->translator = $translator;
        $this->roleRepository = $roleRepository;
    }

    /**
     * User form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'user_form_name_label',
                    'constraints' => [new NotBlank(), new Length(array('min' => 2))]
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => true,
                    'label' => 'user_form_email_label',
                    'constraints' => [new NotBlank(), new Email()]
                ]
            )
            ->add(
                'twitterHandle',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'user_form_twitter_handle_label',
                    'constraints' => [
                        new Regex(
                            [
                                'pattern' => '/(^|[^@\w])@(\w{1,15})\b/',
                                'message' => 'invalid_twitter_username'
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'roleId',
                ChoiceType::class,
                [
                    'required' => true,
                    'label' => 'user_form_role_id_label',
                    'choices' => $this->getRoleIdChoices(),
                    'placeholder' => false,
                    'multiple' => false
                ]
            )
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => is_null($builder->getData()->id),
                'invalid_message' => 'error_user_password_invalid_message',
                'first_options' => array(
                    'label' => 'user_form_password_label'
                ),
                'second_options' => array(
                    'label' => 'user_form_repeated_password_label'
                ),
                'constraints' => [
                    new Regex(
                        [
                            'pattern' => "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[ĄąĆćĘęŁłŃńÓóŚśŹźŻż])[A-Za-z\dĄąĆćĘęŁłŃńÓóŚśŹźŻż]{8,}$/",
                            'message' => 'invalid_password_regex'
                        ]
                    )
                ]
            ))
        ;
    }

    /**
     * @return array
     */
    private function getRoleIdChoices()
    {
        $result = [
        ];
        $roles = $this->roleRepository->getRoles()->execute();

        /** @var Role $role */
        foreach ($roles as $role) {
            $result[$role->getName()] = $role->getId();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => UpdateUserCommand::class,
            )
        );
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'user';
    }
}
