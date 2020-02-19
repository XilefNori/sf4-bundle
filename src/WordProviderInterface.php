<?php


namespace KnpU\LoremIpsumBundle;

interface WordProviderInterface
{
    /**
     * Return word list to use for fake text
     *
     * @return array
     */
    public function getWordList(): array;
}
