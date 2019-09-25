<?php

namespace CPSIT\Persons\Domain\Repository;

/***
 *
 * This file is part of the "Persons" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Dirk Wenzel <wenzel@cps-it.de>
 *  (c) 2019 Elias Häußler <e.haeussler@familie-redlich.de>
 *
 ***/

use CPSIT\Persons\Domain\Model\Person;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for Persons
 */
class PersonRepository extends Repository
{
    /**
     * @var string Table name of associated model
     */
    public const TABLE_NAME = 'tx_persons_domain_model_person';

    /**
     * @var DataMapper Data mapper
     */
    protected $dataMapper;

    /**
     * @var ConfigurationManager Configuration manager
     */
    protected $configurationManager;

    /**
     * @param DataMapper $dataMapper
     */
    public function injectDataMapper(DataMapper $dataMapper): void
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * @param ConfigurationManager $configurationManager
     */
    public function injectConfigurationManager(ConfigurationManager $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Find multiple records by given UIDs and optional ordering.
     *
     * @param string $recordList A comma separated string containing ids
     * @param string $order Optional ordering in the form 'fieldName1|asc,fieldName2|desc'
     * @return array Matching Records
     * @throws InvalidConfigurationTypeException
     */
    public function findMultipleByUid(string $recordList, ?string $order = null): array
    {
        // Get storage PIDs
        $storagePageIds = $this->getStoragePageIds();

        // Get selected UIDs
        $ids = GeneralUtility::intExplode(',', $recordList, true);

        if (empty($ids)) {
            return [];
        }

        // Build base query
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->select('*')
            ->from(self::TABLE_NAME)
            ->where($queryBuilder->expr()->andX(
                $queryBuilder->expr()->in('uid', $ids),
                $queryBuilder->expr()->in('pid', $storagePageIds)
            ));

        // Set orderings
        if ($order === null) {
            $queryBuilder->add('orderBy', 'FIELD(' . self::TABLE_NAME . '.uid, ' . implode(',', $ids) . ')');
        } else {
            $orderings = $this->createOrderingsFromList($order);
            foreach ($orderings as $orderField => $ordering) {
                if ($queryBuilder->getQueryParts()['orderBy']) {
                    $queryBuilder->addOrderBy($orderField, $ordering);
                } else {
                    $queryBuilder->orderBy($orderField, $ordering);
                }
            }
        }

        $result = $queryBuilder->execute()->fetchAll();
        return $this->dataMapper->map(Person::class, $result);
    }

    /**
     * Create array of orderings from given order list.
     *
     * Returns an array of orderings from a given list in the form 'field1|asc,field2|desc'.
     *
     * @param string $orderList Order list, separated by comma and configured through pipe
     * @return array Array of orderings
     */
    public function createOrderingsFromList(string $orderList): array
    {
        $orderings = [];
        $orderItems = GeneralUtility::trimExplode(',', $orderList, true);

        if (empty($orderItems)) {
            return [];
        }

        // Set orderings
        foreach ($orderItems as $orderItem) {
            $configuration = GeneralUtility::trimExplode('|', $orderItem, true, 2);
            $orderField = $configuration[0];
            $order = QueryInterface::ORDER_ASCENDING;

            // Apply order if set in current order item
            if (count($configuration) > 1 && strtolower($configuration[1]) === 'desc') {
                $order = QueryInterface::ORDER_DESCENDING;
            }

            $orderings[$orderField] = $order;
        }

        return $orderings;
    }

    /**
     * Get storage page IDs from current configuration.
     *
     * @return array Storage page IDs from current configuration
     * @throws InvalidConfigurationTypeException
     */
    protected function getStoragePageIds(): array
    {
        $frameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        return GeneralUtility::intExplode(',', $frameworkConfiguration['persistence']['storagePid']);
    }

    /**
     * @return QueryBuilder
     */
    protected function getQueryBuilder(): QueryBuilder
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(self::TABLE_NAME);
    }
}
