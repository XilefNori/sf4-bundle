<?php


namespace KnpU\LoremIpsumBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class FilterApiResponseEvent extends Event
{
    /** @var array */
    private $data;

    public function __construct(array $data) {

        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
