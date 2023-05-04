<?php

/**
 * Studio1 Kommunikation GmbH
 *
 * This source file is available under following license:
 * - GNU General Public License v3.0 (GNU GPLv3)
 *
 *  @copyright  Copyright (c) Studio1 Kommunikation GmbH (http://www.studio1.de)
 *  @license    https://www.gnu.org/licenses/gpl-3.0.txt
 */

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
        return '1.0.1';
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
