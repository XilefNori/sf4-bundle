<?php

namespace KnpU\LoremIpsumBundle\Controller;

use KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent;
use KnpU\LoremIpsumBundle\Event\KnpULoremIpsumEvents;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class IpsumApiController extends AbstractController
{
    /** @var KnpUIpsum */
    private $knpUIpsum;
    /** @var EventDispatcherInterface */
    private $dispatcher;

    public function __construct(KnpUIpsum $knpUIpsum, EventDispatcherInterface $dispatcher = null)
    {
        $this->knpUIpsum  = $knpUIpsum;
        $this->dispatcher = $dispatcher;
    }

    public function index()
    {
        $data = [
            'paragraphs' => $this->knpUIpsum->getParagraphs(),
            'sentences'  => $this->knpUIpsum->getSentences(),
        ];

        if ($this->dispatcher) {
            $event = new FilterApiResponseEvent($data);
            $this->dispatcher->dispatch($event, KnpULoremIpsumEvents::FILTER_API);
            $data = $event->getData();
        }

        return $this->json($data);
    }
}
