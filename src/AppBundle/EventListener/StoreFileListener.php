<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\File;
use function Deployer\get;
use Doctrine\ORM\Event\LifecycleEventArgs;

class StoreFileListener
{
    /**
     * @var string
     */
    private $storagePath;

    /**
     * @param string $storagePath
     */
    public function __construct(string $storagePath)
    {
        $this->storagePath = $storagePath.'/uploads/';
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $file = $eventArgs->getEntity();
        if (!$file instanceof File) {
            return;
        }

        $file->setKey(bin2hex(random_bytes(5)));
        $uploadedFile = $file->getFile();
        $uploadedFile->move($this->storagePath, $file->getKey().'_'.$uploadedFile->getClientOriginalName());
        $file->setPath($this->storagePath.$file->getKey().'_'.$uploadedFile->getClientOriginalName());
        $file->setFile(null);
    }
}
