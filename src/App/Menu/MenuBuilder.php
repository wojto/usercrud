<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Menu class
 *
 * @package App\Menu
 */
class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(
        FactoryInterface $factory,
        AuthorizationCheckerInterface $authorizationChecker,
        RequestStack $requestStack
    )
    {
        $this->factory = $factory;
        $this->authorizationChecker = $authorizationChecker;
        $this->requestStack = $requestStack;
    }

    /**
     * Creating admin menu
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createAdminMenu()
    {
        $menu = $this->factory->createItem('root');
        // menu positions for authoried user
        if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $menu
                ->addChild(
                    'Role',
                    array(
                        'route' => 'admin_role_list'
                    )
                )
                ->setAttribute('icon', 'fa fa-group fa-fw');

            $menu
                ->addChild(
                    'Użytkownicy',
                    array(
                        'route' => 'admin_user_list'
                    )
                )
                ->setAttribute('icon', 'fa fa-user fa-fw');
        } else {
            // menu positions for unauthorized users
            $menu
                ->addChild('Logowanie', array('route' => 'admin_homepage'))
                ->setAttribute('icon', 'fa fa-home fa-fw');
        }
        return $menu;
    }
}
