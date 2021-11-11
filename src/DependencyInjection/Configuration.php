<?php

namespace MartenaSoft\Warehouse\DependencyInjection;

use MartenaSoft\Warehouse\WarehouseBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(WarehouseBundle::getConfigName());

        return $treeBuilder;
    }
}