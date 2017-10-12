<?php

namespace CPSIT\Persons\View;

/**
 * This file is part of the "Events" project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Mvc\View\JsonView;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

/**
 * Class AbstractJsonView
 */
class AbstractJsonView extends JsonView
{
    /**
     * settings key for image processing configuration
     */
    const IMAGE_PROCESSING_KEY = 'imageProcessing';

    /**
     * @var \CPSIT\Persons\Service\ImageService
     */
    protected $imageService;

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @param \CPSIT\Persons\Service\ImageService $imageService
     */
    public function injectImageService(\CPSIT\Persons\Service\ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Traverses the given object structure in order to transform it into an
     * array structure.
     * This implementation transforms FileReference objects too.
     *
     * @param object $object Object to traverse
     * @param array $configuration Configuration for transforming the given object or NULL
     * @return array Object structure as an array
     */
    protected function transformObject($object, array $configuration)
    {
        $transformedObject = [];

        if ($object instanceof LazyLoadingProxy) {
            $object = $object->_loadRealInstance();
        }

        if ($object instanceof ObjectStorage) {
            $object = $object->toArray();
        }

        if (is_object($object)) {
            $transformedObject = parent::transformObject($object, $configuration);
        }
        if (
            $object instanceof FileReference
            && isset($configuration['_descend']['_only'])
        ) {
            $transformedObject = $this->transformFileReference($object, $configuration['_descend']['_only'], $transformedObject);
        }

        return $transformedObject;
    }

    /**
     * Transforms a value depending on type recursively using the
     * supplied configuration.
     *
     * @param mixed $value The value to transform
     * @param array $configuration Configuration for transforming the value
     * @return array The transformed value
     */
    protected function transformValue($value, array $configuration)
    {
        if (!$value instanceof ObjectStorage) {
            return parent::transformValue($value, $configuration);
        }

        $items = $value->toArray();

        $value = [];
        foreach ($items as $item) {
            $value[] = parent::transformValue($item, $configuration);
        }

        return $value;
    }

    /**
     * Transforms a file reference by transforming its original resource.
     * Its properties are added to the incoming transformedObject array
     * as key => value pairs. The key corresponds to the property name.
     * The value is transformed recursively.
     *
     * @param $object FileReference
     * @param array $configuration Local configuration for property of type FileReference
     * @param array $transformedObject
     * @return array
     */
    protected function transformFileReference($object, array $configuration, $transformedObject)
    {
        $originalResource = $object->getOriginalResource();

        if (!empty($this->settings[static::IMAGE_PROCESSING_KEY])) {
            $processedImage = $this->imageService->getProcessedFile($object);
            $transformedObject['uri'] = ltrim($this->imageService->getImageUri($processedImage), DIRECTORY_SEPARATOR);
        }

        foreach ($configuration as $propertyName) {
            if (ObjectAccess::isPropertyGettable($originalResource, $propertyName)) {
                $propertyValue = ObjectAccess::getProperty($originalResource, $propertyName);
                if (is_object($propertyValue)) {
                    $transformedObject[$propertyName] = $this->transformObject($propertyValue, $configuration);
                } else {
                    $transformedObject[$propertyName] = $this->transformValue($propertyValue, $configuration);
                }
            }
        }

        return $transformedObject;
    }


    /**
     * Injects the settings
     * @param $settings
     */
    public function injectSettings(array $settings)
    {
        $this->settings = $settings;
    }
}
