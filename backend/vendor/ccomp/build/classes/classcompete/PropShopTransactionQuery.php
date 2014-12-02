<?php



/**
 * Skeleton subclass for performing query and update operations on the 'shop_transactions' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropShopTransactionQuery extends BasePropShopTransactionQuery {
    public function filterByChallengeId($id = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($id)) {
                $comparison = Criteria::IN;
                foreach ($id as $k => $i) {
                    $id[$k] = sprintf('Completed challengeID=%d', $i);
                }
            } else {
                $challengeId = intval($id);
                $description = str_replace('*', '%', sprintf('Completed challengeID=%d', $challengeId));
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(PropShopTransactionPeer::DESCRIPTION, $description, $comparison);
    }
} // PropShopTransactionQuery
