<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use ApiPlatform\Metadata\Get;
use Banking\Infrastructure\Doctrine\Entity\DoctrineOperation;


#[Get(
    shortName: 'Operation',
)]    
final class QueryDto{
    public string $id;

            public ?string $label;
       
            public ?string $state;
       
            public ?string $category;
       
            public ?float $amount;
       
            public ?\DateTimeImmutable $valuedate;
       
            public ?\DateTimeImmutable $operationdate;
       
            //public ?AccountResource $account;
       
        
    public static function mapEntityToDto(?DoctrineOperation $doctrineEntity): ?QueryDto    {
        if ($doctrineEntity == null)
            return null;

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
                        $dto->label = $doctrineEntity->getlabel();
          
                        $dto->state = $doctrineEntity->getstate();
          
                        $dto->category = $doctrineEntity->getcategory();
          
                        $dto->amount = $doctrineEntity->getamount();
          
                        $dto->valuedate = $doctrineEntity->getvaluedate();
          
                        $dto->operationdate = $doctrineEntity->getoperationdate();
          
                        //$dto->account = AccountResource::mapEntityToDto($doctrineEntity->getaccount());
          
                return $dto;
    }    
}