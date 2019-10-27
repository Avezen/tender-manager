<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-08-05
 * Time: 11:34
 */

namespace App\Factory;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        $menu
            ->setChildrenAttributes([
                'class' => 'nav nav-pills nav-sidebar flex-column',
                'role' => 'menu',
                'data-accordion' => 'false',
                'data-widget' => 'treeview'
            ]);

        $menu
            ->addChild('Dashboard', ['route' => 'dashboard'])
            ->setAttributes([
                'class' => 'nav-item',
                'icon' => 'fas fa-chart-line'
            ])
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Request', [
                'route' => 'auction_list',
                'label' => 'Zapotrzebowanie'
            ])
            ->setAttributes([
                'class' => 'nav-item li-disabled',
                'icon' => 'fas fa-comments',
            ])
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Auction', [
                'route' => 'auction_list',
                'label' => 'Przetargi'
            ])
            ->setAttributes([
                'class' => 'nav-item',
                'icon' => 'fas fa-magic'
            ])
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('ProductGroupList', [
                'route' => 'product_group_list',
                'label' => 'Baza produktów'
            ])
            ->setAttributes([
                'class' => 'nav-item',
                'icon' => 'fas fa-server'
            ])
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Order', [
                'route' => 'order_list',
                'label' => 'Zamówienia i dostawy'
            ])
            ->setAttributes([
                'class' => 'nav-item',
                'icon' => 'fas fa-luggage-cart'
            ])
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Contractor', [
                'route' => 'contractor_list',
                'label' => 'Kontrahenci'
            ])
            ->setAttributes([
                'class' => 'nav-item',
                'icon' => 'fas fa-users'
            ])
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Company', [
                'route' => 'company_list',
                'label' => 'Firmy'
            ])
            ->setAttributes([
                'class' => 'nav-item',
                'icon' => 'fas fa-building'
            ])
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Project', [
                'route' => 'project_list',
                'label' => 'Projekty'
            ])
            ->setAttributes([
                'class' => 'nav-item',
                'icon' => 'fas fa-drafting-compass'
            ])
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Location', [
                'route' => 'location_list',
                'label' => 'Lokalizacje'
            ])
            ->setAttributes([
                'class' => 'nav-item',
                'icon' => 'fas fa-map-marked-alt'
            ])
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Config', ['label' => 'Konfiguracja'])
            ->setAttributes([
                'class' => 'nav-item has-treeview',
                'icon' => 'fas fa-wrench'
            ])
            ->setLinkAttribute('class', 'nav-link')
            ->setChildrenAttribute('class', 'nav nav-treeview');

        $menu['Config']
            ->addChild('Config', [
                'route' => 'product_group_create',
                'label' => 'Example 1'
            ])
            ->setAttributes([
                'class' => 'nav-item',
                'icon' => 'fas fa-th'
            ])
            ->setLinkAttribute('class', 'nav-link');


        return $menu;
    }
}