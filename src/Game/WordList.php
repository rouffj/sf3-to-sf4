<?php

namespace App\Game;

use App\Game\Loader\LoaderInterface;

class WordList implements DictionaryLoaderInterface, WordListInterface
{
    /**
     * @var string[][]
     */
    private $words = [];
    /**
     * @var LoaderInterface[]
     */
    private $loaders = [];

    /**
     * {@inheritdoc}
     */
    public function addLoader($type, LoaderInterface $loader)
    {
        $this->loaders[strtolower($type)] = $loader;
    }

    /**
     * {@inheritdoc}
     */
    public function loadDictionaries(array $dictionaries)
    {
        foreach ($dictionaries as $dictionary) {
            $this->loadDictionary($dictionary);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addWord($word)
    {
        $length = strlen($word);

        if (!isset($this->words[$length])) {
            $this->words[$length] = [];
        }

        if (!in_array($word, $this->words[$length])) {
            $this->words[$length][] = $word;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRandomWord($length)
    {
        if (!isset($this->words[$length])) {
            throw new \InvalidArgumentException(sprintf('There is no word of length %u.', $length));
        }

        $key = array_rand($this->words[$length]);

        return $this->words[$length][$key];
    }

    private function loadDictionary($path)
    {
        $loader = $this->findLoader(pathinfo($path, PATHINFO_EXTENSION));

        foreach ($loader->load($path) as $word) {
            $this->addWord($word);
        }
    }

    private function findLoader($type)
    {
        $type = strtolower($type);

        if (empty($this->loaders[$type])) {
            throw new \LogicException(sprintf('There is no loader able to load a %s dictionary.', $type));
        }

        return $this->loaders[$type];
    }
}
