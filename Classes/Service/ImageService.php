<?php

namespace CPSIT\Persons\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DWenzel\T3events\CallStaticTrait;
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Service\ImageService as BaseService;

/**
 * Class ImageService
 * Extended version of extbase image service.
 * Allows to get image file variants rendered according to
 * processing configuration. The configuration can be set.
 */
class ImageService extends BaseService
{
    use CallStaticTrait;

    /**
     * Processing configuration for image variants
     * @var array
     */
    protected $processingConfiguration = [
        'width' => 'm200',
        'height' => 'm200',
        'minWidth' => 50,
        'minHeight' => 50,
        'maxWidth' => 200,
        'maxHeight' => 200,
        'cropVariant' => 'default',
        'absoluteUri' => false
    ];

    /**
     * Allowed key/type pairs for processing
     * Any 'key' will be casted to 'type' before setting
     * in processing configuration
     * @var array
     */
    protected static $allowedProcessingKeys = [
        'width' => 'string',
        'height' => 'string',
        'minWidth' => 'integer',
        'minHeight' => 'integer',
        'maxWidth' => 'integer',
        'maxHeight' => 'integer',
        'cropVariant' => 'string',
        'absoluteUri' => 'boolean'
    ];

    /**
     * Sets the processing configuration.
     * Replaces existing configuration
     * @param array $configuration
     */
    public function setProcessingConfiguration(array $configuration) {
        $this->processingConfiguration = $configuration;
    }

    /**
     * Get the processing configuration
     * @return array
     */
    public function getProcessingConfiguration() {
        return $this->processingConfiguration;
    }

    /**
     * Overwrites the processing configuration. See $allowedProcessingKeys
     * for allowed key/type.
     * @param array $configuration
     */
    public function overwriteProcessingConfiguration(array $configuration) {
        foreach ($configuration as $key => $value) {
            if (array_key_exists($key, static::$allowedProcessingKeys)) {
                settype($value, static::$allowedProcessingKeys[$key]);
                $this->processingConfiguration[$key] = $value;
            }
        }
    }

    /**
     * Gets a processed file by applying processing instructions
     * to a file reference.
     * Default processing configuration can be changed using method setProcessingConfiguration()
     * @param FileReference $fileReference
     * @return ProcessedFile
     */
    public function getProcessedFile(FileReference $fileReference) {

        $originalResource = $fileReference->getOriginalResource();
        $referenceProperties = $originalResource->getReferenceProperties();

        $image = $originalResource->getOriginalFile();
        $cropString = !empty($referenceProperties['crop']) ? $referenceProperties['crop'] : '';

        /** @var CropVariantCollection $cropVariantCollection */
        $cropVariantCollection = $this->callStatic(
            CropVariantCollection::class,
            'create',
            $cropString
        );
        $cropArea = $cropVariantCollection->getCropArea($this->processingConfiguration['cropVariant']);
        $crop = null;
        if (!$cropArea->isEmpty()) {
            $crop = $cropArea->makeAbsoluteBasedOnFile($image);
        }
        $processingInstructions = [
            'width' => $this->processingConfiguration['width'],
            'height' => $this->processingConfiguration['height'],
            'minWidth' => $this->processingConfiguration['minWidth'],
            'minHeight' => $this->processingConfiguration['minHeight'],
            'maxWidth' => $this->processingConfiguration['maxWidth'],
            'maxHeight' => $this->processingConfiguration['maxHeight'],
            'crop' => $crop,
        ];

        return $this->applyProcessingInstructions($image, $processingInstructions);
    }
}
