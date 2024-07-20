<?php

namespace App\Builder;

use App\dto\request\NaturalPersonDto;
use App\dto\request\NaturalPersonUpdateDto;
use App\dto\response\NaturalPersonResponseDto;
use App\Entity\NaturalPerson;

abstract class NaturalPersonBuilder
{

    public static function buildEntity(NaturalPersonDto $dto): NaturalPerson
    {

        $person = new NaturalPerson();

        $person->setFirstName($dto->getFirstName());
        $person->setLastName($dto->getLastName());
        $person->setToken();

        return $person;
    }

    public static function buildNaturalPersonReposeDto(NaturalPerson $naturalPerson): NaturalPersonResponseDto{

        $naturalPersonDto = new NaturalPersonResponseDto();

        $naturalPersonDto->setFirstName($naturalPerson->getFirstName());
        $naturalPersonDto->setLastName($naturalPerson->getLastName());
        $naturalPersonDto-> setToken($naturalPerson->getToken());

        return $naturalPersonDto;
    }

    public static function buildNaturalPersonListDto(array $naturalPersons):array {
        $items =[];

        foreach ($naturalPersons as $naturalPerson) {
            $naturalPersonDto = self::buildNaturalPersonReposeDto($naturalPerson);
            $items[] = $naturalPersonDto;
        }
        return $items;
    }

    public static function buildEntityUpdate(NaturalPersonUpdateDto $dto, NaturalPerson $person): NaturalPerson{

        if ($dto->getFirstName() !== ''){
            $person->setFirstName($dto->getFirstName());
        }

        if ($dto->getLastName() != ''){
            $person->setLastName($dto->getLastName());
        }

        return $person;
    }
}