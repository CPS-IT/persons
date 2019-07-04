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
 *
 ***/
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for Persons
 */
class PersonRepository extends Repository
{
    /**
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface Matching Records
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @var string $recordList A comma separated string containing ids
     * @var string $order Optional ordering in the form 'fieldName1|asc,fieldName2/desc'
     */
    public function findMultipleByUid($recordList, $order = null)
    {
        $query = $this->createQuery();
        $query->setQuerySettings($query->getQuerySettings()->setRespectSysLanguage(false));
        $ids = GeneralUtility::intExplode(',', $recordList, true);
        if (!empty($ids)) {
            $query->matching($query->in('uid', $ids));

            if ( null !== $order) {
                $orderings = $this->createOrderingsFromList($order);
                if (!empty($orderings))  {
                    $query->setOrderings($orderings);
                }
            }
        }

        return $query->execute();
    }

    /**
     * Creates an array of orderings orderings.
     * For a list in the form 'field1|asc
     * @param $orderList
     * @return array
     */
    public function createOrderingsFromList($orderList)
    {
        $orderings = [];

        $orderItems = GeneralUtility::trimExplode(',', $orderList, true);

        if (!empty($orderItems)) {
            // go through every order statement
            foreach ($orderItems as $orderItem) {
                $configuration = GeneralUtility::trimExplode('|', $orderItem, true, 2);
                // count == 1 means that no direction is given
                if (count($configuration) > 1) {
                    list($orderField, $ascDesc) = $configuration;
                    $orderings[$orderField] = ((strtolower($ascDesc) == 'desc') ?
                        QueryInterface::ORDER_DESCENDING :
                        QueryInterface::ORDER_ASCENDING);
                } else {
                    $orderings[$configuration[0]] = QueryInterface::ORDER_ASCENDING;
                }
            }
        }

        return $orderings;
    }
}
