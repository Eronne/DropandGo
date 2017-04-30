<?php

namespace AppBundle\Repository;

use AppBundle\Entity\File;
use Doctrine\ORM\EntityRepository;

class FileRepository extends EntityRepository
{
    public function store(File $file)
    {
        $this->_em->persist($file);
        $this->_em->flush($file);
    }
}
