<?php

namespace UPSS\Controller;

use UPSS\Components\Analyzers\IAnalyzer;
use UPSS\Components\Modifiers\IModifier;
use UPSS\Preprocessing\EntityCollection\IEntityCollection;
use UPSS\Storage\IStorage;

class MainController
{
    private $components;

    private $storage;

    private $analysisResult;

    private $collection;

    private $collectionHashSum;

    public function __construct(
        IEntityCollection $data,
        array $components,
        IStorage $storage = null
    ) {
        $this->collection = $data;
        $this->components = $components;
        if (!is_null($storage)) {
            $this->storage = $storage;
            $this->collectionHashSum = sha1(serialize($this->collection));
        }
    }

    public function handle() : IEntityCollection
    {
        if ($this->lookInStorage('result')){
           $result = $this->getFromStorage('result');
           if ($result instanceof IEntityCollection){
               return $result;
           }
        }

        if ($this->lookInStorage('analysis')){
            $result = $this->getFromStorage('analysis');
            if ($result){
                $this->analysisResult = $result;
            }
        } else {
            $this->sendToAnalyzers();
            $this->saveInStorage('analysis', $this->analysisResult);
        }


        $this->sendToModifiers();

        $this->saveInStorage('result', $this->collection);

        return $this->collection;
    }

    private function lookInStorage(string $type) : bool
    {
        if (isset($this->storage)){
            $result = $this->storage->select($type)
                ->where('collection', $this->collectionHashSum)
                ->execute();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }


    private function getFromStorage(string $type)
    {
        $result = $this->storage->select($type)
            ->where('collection', $this->collectionHashSum)
            ->get();

        $result = unserialize($result);
        return $result;
    }


    private function saveInStorage(string $type, $data)
    {
        if (isset($this->storage)){
            $this->storage->insert($type, serialize($data))
                ->where('collection', $this->collectionHashSum)
                ->execute();
        }
    }

    private function sendToAnalyzers()
    {
        if (isset($this->components['analyzers']) && !empty($this->components['analyzers'])) {
            foreach ($this->components['analyzers'] as $analyzerClass) {
                $analyzer = new $analyzerClass;
                if ($analyzer instanceof IAnalyzer) {
                    $result = $analyzer->analyze($this->collection);
                    $this->addAnalysisResult($result);
                }
            }
        }
    }

    private function addAnalysisResult(array $result)
    {
        foreach ($result as $key => $value) {
            $this->analysisResult[$key] = $value;
        }
    }

    private function sendToModifiers()
    {
        if (isset($this->components['modifiers']) && !empty($this->components['modifiers'])) {
            foreach ($this->components['modifiers'] as $modifierClass) {
                $modifier = new $modifierClass;
                if ($modifier instanceof IModifier) {
                    $modifier->modify($this->collection, $this->analysisResult);
                }
            }
        }
    }

}