<?php

namespace Studio1\Web2PrintBricksBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

/**
 * Web2Print Bricks Bundle
 */
class Web2PrintBricksBundle extends AbstractPimcoreBundle
{
    /**
     * @inheritDoc
     */
    public function getVersion(): string
    {
        return '1.0.0';
    }

    /**
     * @inheritDoc
     */
    public function getNiceName(): string
    {
        return 'Web2Print Bricks Bundle';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Bricks for Web2Print';
    }

    /**
     * @inheritDoc
     */
    public function getInstaller(): ?object
    {
        return $this->container->get(Installer::class);
    }
}
