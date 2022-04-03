<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class WalletRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private LoggerInterface $logger
    )
    {
        parent::__construct($registry, Wallet::class);
    }

    public function create(Wallet $wallet): void
    {
        $this->_em->persist($wallet);
        $this->_em->flush();

        $this->logger->notice(
            sprintf(
                'New wallet with id: %d was create.',
                $wallet->getId()
            )
        );
    }

    public function update(Wallet $wallet): void
    {
        $this->_em->persist($wallet);
        $this->_em->flush();

        $this->logger->notice(
            sprintf(
                'Wallet with id: %d was updated.',
                $wallet->getId()
            )
        );
    }

}