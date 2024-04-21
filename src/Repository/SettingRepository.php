<?php

namespace App\Repository;

use App\Entity\Setting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Setting>
 *
 * @method Setting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Setting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Setting[]    findAll()
 * @method Setting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Setting::class);
    }

    /**
     * @return string[]
     */
    public function findMemberships(): array
    {
        $settings = $this->createQueryBuilder('s')
            ->getQuery()
            ->getResult()[0] ?? null;

        return $settings?->getMembershipLogos() ?? [];
    }

	public function findSettingPage(): ?Setting
	{
		return $this->createQueryBuilder('Setting')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult()
            ;
	}
}
