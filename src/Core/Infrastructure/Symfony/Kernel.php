<?php

namespace Core\Infrastructure\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    private string $dir = "";

    public function getProjectDir(): string
    {
        if ($this->dir == "")
            $this->dir = \dirname(__DIR__, 4); //4 number of level to get srv/app path : srv\Core\Infrastructure\Symfony
        return $this->dir;
    }


    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import($this->getConfigDir() . "/{packages}/*.php");
        $container->import($this->getConfigDir() . "/{packages}/*.yaml");

        $container->import($this->getConfigDir() . "/{services}/*.php");
        $container->import($this->getConfigDir() . "/{services}/$this->environment/*.php");
        $container->import($this->getConfigDir() . "/{services}/*.yaml");


    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import($this->getConfigDir() . '/{routes}/*.php');
        $routes->import($this->getConfigDir() . '/{routes}/*.yaml');
        $routes->import($this->getConfigDir() . "/{routes}/$this->environment/*.yaml");
    }
}