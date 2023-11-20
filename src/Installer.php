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

use Exception;
use Pimcore\Extension\Bundle\Installer\SettingsStoreAwareInstaller;
use Pimcore\Model\Asset\Image\Thumbnail\Config;
use Pimcore\Model\Property\Predefined;
use Pimcore\Model\Property\Predefined\Listing;

/**
 * Installer
 *
 * @see \Pimcore\Bundle\PortalEngineBundle\Installer
 */
class Installer extends SettingsStoreAwareInstaller
{
    /**
     * @inheritDoc
     */
    public function install(): void
    {
        $this
            ->installPredefinedProperties()
            ->installThumbnailConfigurations()
        ;

        parent::install();
    }

    /**
     * Install pre-defined properties
     *
     * @return self
     *
     * @see \Pimcore\Bundle\PortalEngineBundle\Installer::installPredefinedProperties()
     */
    protected function installPredefinedProperties(): self
    {
        $predefinedPropertyConfigs = [
            [
                'name' => 'Print Register Title',
                'description' => 'Defines title for register.',
                'key' => 'print_register_title',
                'type' => 'text',
                'data' => '',
                'config' => '',
                'contentType' => 'document',
            ],
            [
                'name' => 'Print Register Type',
                'description' => 'Defines color and size of register.',
                'key' => 'print_register_type',
                'type' => 'select',
                'data' => '',
                'config' => 'orange,red,violett,green,blue,yellow',
                'contentType' => 'document',
            ],
        ];

        foreach ($predefinedPropertyConfigs as $predefinedPropertyConfig) {
            $exists = false;
            $predefinedProperties = new Listing;

            /**
             * @var Predefined $predefinedProperty
             */
            foreach ($predefinedProperties->load() as $predefinedProperty) {
                if ($predefinedProperty->getKey() === $predefinedPropertyConfig['key']
                    && $predefinedProperty->getType() === $predefinedPropertyConfig['type']
                    && $predefinedProperty->getCtype() === $predefinedPropertyConfig['contentType']
                ) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                (new Predefined())
                    ->setName($predefinedPropertyConfig['name'])
                    ->setDescription($predefinedPropertyConfig['description'])
                    ->setKey($predefinedPropertyConfig['key'])
                    ->setType($predefinedPropertyConfig['type'])
                    ->setData($predefinedPropertyConfig['data'])
                    ->setConfig($predefinedPropertyConfig['config'])
                    ->setCtype($predefinedPropertyConfig['contentType'])
                    ->setInheritable(true)
                    ->save();
            }
        }

        return $this;
    }

    /**
     * Install thumbnail configurations
     *
     * @return self
     * @noinspection PhpReturnValueOfMethodIsNeverUsedInspection
     */
    private function installThumbnailConfigurations(): self
    {
        /** @noinspection SpellCheckingInspection */
        $thumbnailConfigurations = [
            'print_backgroundimage_small' => [
                'items' => [[
                    'method' => 'scaleByWidth',
                    'arguments' => [
                        'width' => 800,
                        'forceResize' => false,
                    ],
                ]],
                'modificationDate' => 1674619156,
                'creationDate' => 1674618942,
            ],
            'print_backgroundimage' => [
                'items' => [[
                    'method' => 'scaleByWidth',
                    'arguments' => [
                        'width' => 3000,
                        'forceResize' => false,
                    ],
                ]],
                'modificationDate' => 1674619130,
                'creationDate' => 1674618911,
            ],
            'print_image_small' => [
                'items' => [
                    [
                        'method' => 'cover',
                        'arguments' => [
                            'width' => 100,
                            'height' => 60,
                            'positioning' => 'center',
                            'forceResize' => false,
                        ],
                    ], [
                        'method' => 'roundCorners',
                        'arguments' => [
                            'width' => 2,
                            'height' => 2,
                        ],
                    ]
                ],
                'modificationDate' => 1674619217,
                'creationDate' => 1674619217,
            ],
            'print_keyvisual' => [
                'items' => [[
                    'method' => 'scaleByWidth',
                    'arguments' => [
                        'width' => 2000,
                        'forceResize' => false,
                    ],
                ]],
                'modificationDate' => 1674619256,
                'creationDate' => 1674619010,
            ],
            'print_titleimage' => [
                'items' => [[
                    'method' => 'scaleByWidth',
                    'arguments' => [
                        'width' => 1000,
                        'forceResize' => false,
                    ],
                ]],
                'modificationDate' => 1674619287,
                'creationDate' => 1674618978,
            ],
        ];

        foreach ($thumbnailConfigurations as $thumbnailName => $thumbnailDetails) {
            try {
                $config = Config::getByName($thumbnailName);
                if ($config !== null) {
                    continue;
                }
            } catch (Exception $e) {
                //TODO optimize exception handling
                continue;
            }

            $config = new Config();
            $config->setName($thumbnailName);
            $config->setItems($thumbnailDetails['items']);
            $config->setMedias([]);
            $config->setDescription('');
            $config->setGroup('Print');
            $config->setFormat('SOURCE');
            $config->setQuality(85);
            $config->setHighResolution(0.0);
            $config->setPreserveColor(false);
            $config->setPreserveMetaData(false);
            $config->setRasterizeSVG(false);
            $config->setDownloadable(false);
            $config->setModificationDate($thumbnailDetails['modificationDate']);
            $config->setCreationDate($thumbnailDetails['creationDate']);
            $config->setPreserveAnimation(false);
            $config->save();
        }

        return $this;
    }
}
