<?php

namespace Ekyna\Bundle\CommerceBundle\Service\Common;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Ekyna\Component\Commerce\Common\Generator\KeyGeneratorInterface;
use Ekyna\Component\Commerce\Common\Model\KeySubjectInterface;
use Ekyna\Component\Commerce\Common\Model\SaleInterface;
use Ekyna\Component\Commerce\Exception\InvalidArgumentException;

/**
 * Class SaleKeyGenerator
 * @package Ekyna\Bundle\CommerceBundle\Service\Common
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SaleKeyGenerator implements KeyGeneratorInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;


    /**
     * Constructor.
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritdoc
     */
    public function generate(KeySubjectInterface $subject)
    {
        if (null !== $subject->getKey()) {
            return $this;
        }

        if (!$subject instanceof SaleInterface) {
            throw new InvalidArgumentException("Expected instance of SaleInterface.");
        }

        // TODO (eventually) $this->manager->getFilters()->disable('softdeleteable');

        $class = get_class($subject);

        $query = $this->manager->createQuery(
            "SELECT o.id " .
            "FROM $class o " .
            "WHERE o.key = :key"
        );
        $query->setMaxResults(1);

        do {
            $key = substr(preg_replace('~[^a-zA-Z\d]~', '', base64_encode(random_bytes(64))), 0, 32);
            $result = $query
                ->setParameter('key', $key)
                ->getOneOrNullResult(Query::HYDRATE_SCALAR);
        } while (null !== $result);

        $subject->setKey($key);

        // TODO (eventually) $this->manager->getFilters()->enable('softdeleteable');

        return $this;
    }
}
