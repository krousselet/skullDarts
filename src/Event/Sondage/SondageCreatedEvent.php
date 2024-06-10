<?php

namespace App\Event\Sondage;

use App\Entity\Sondage;

class SondageCreatedEvent
{
    public const NAME = 'sondage.created';

    protected Sondage $sondage;

    public function __construct(Sondage $sondage)
    {
        $this->sondage = $sondage;
    }

    public function getSondage(): Sondage
    {
        return $this->sondage;
    }
}