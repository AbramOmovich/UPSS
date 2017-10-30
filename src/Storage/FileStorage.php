<?php

namespace UPSS\Storage;

class FileStorage implements IStorage
{
    private const BAD_DIR = 'Directory settings for storage is invalid';

    private $storageDir;

    private $queryType = '';
    private $type = null;
    private $where = [];
    private $data = null;
    private $returnResult = false;

    public function __construct(array $settings)
    {
        if (isset($settings['folder'])){
            if (file_exists($settings['folder']) && is_dir($settings['folder']))
            $this->storageDir = $settings ['folder'];
        } else {
            throw new StorageException(self::BAD_DIR);
        }
    }

    public function select(string $type) : IStorage
    {
        $this->type = $type;
        $this->queryType = __FUNCTION__;
        return $this;
    }

    public function where(
        string $field,
        string $value,
        string $operator = '='
    ): IStorage {
        $this->where = [
            'folder' => $field,
            'name' => $value,
            'operator' => $operator
        ];

        return $this;
    }

    public function execute()
    {
        $file = '';
        switch ($this->queryType){
            case 'select' : {
                $file = $this->storageDir . DIRECTORY_SEPARATOR .
                    $this->where['folder'] . DIRECTORY_SEPARATOR .
                    $this->where['name'] . DIRECTORY_SEPARATOR .
                    $this->type;
                $this->cleanFields();
                if (file_exists($file)){
                    if ($this->returnResult){
                        $result = file_get_contents($file);
                        if ($result) {
                            return $result;
                        } else {
                            return [];
                        }
                    }
                    return true;
                } else {
                    return false;
                }
                break;
            }
            case 'insert' : {
                //main folder
                $file = $this->storageDir . DIRECTORY_SEPARATOR .
                    $this->where['folder'];
                if (!file_exists($file)){
                    mkdir($file);
                }
                //subfolder
                $file .= DIRECTORY_SEPARATOR . $this->where['name'];
                if (!file_exists($file)){
                    mkdir($file);
                }
                $file .= DIRECTORY_SEPARATOR . $this->type;

                if (!file_exists($file)){
                    file_put_contents($file, $this->data);
                    $this->cleanFields();
                    return true;
                } else {
                    $this->cleanFields();
                    return false;
                }
                break;
            }
            default : {
                return false;
            }
        }
    }

    private function cleanFields()
    {
        $this->queryType = '';
        $this->type = null;
        $this->where = [];
        $this->data = null;
    }

    public function get()
    {
        $this->returnResult = true;
        return $this->execute();
    }

    public function insert(string $type, $data) : IStorage
    {
        $this->queryType = __FUNCTION__;
        $this->type = $type;
        $this->data = $data;
        $this->returnResult = false;
        return $this;
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function merge(array $data)
    {
        // TODO: Implement merge() method.
    }
}