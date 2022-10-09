<?php

declare(strict_types=1);

namespace App\DB\DataBase;

use App\Exceptions\AppException;

class JsonDB
{
    private string $path;

    /** @var object[] $items */
    private array $items = [];

    public function __construct(string $path, string $class)
    {
        $this->path = $path;
        $json = file_get_contents($this->path);
        $itemsJson = json_decode($json) ?? [];

        foreach ($itemsJson as $itemJson) {
            $this->items[] = new $class((array)$itemJson);
        }
    }

    public function create(object $item): ?object
    {
        try {
            $this->items[] = $item;
            $this->saveItemsToFile();

            return $item;
        } catch (\Exception $e) {
            throw new \Error(
                json_encode(['status' => 'fatal']),
                AppException::INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getByField(string $field, string $value): ?object
    {
        foreach ($this->items as $itemFind) {
            if (isset($itemFind->$field)) {
                if ($itemFind->$field == $value) {

                    return $itemFind;
                }
            }
        }

        return null;
    }

    public function updateByField(string $field, string $value, object $item): ?object
    {
        try {
            foreach ($this->items as $index => $itemFind) {
                if (isset($itemFind->$field)) {
                    if ($itemFind->$field == $value) {

                        $this->items[$index] = $item;
                    }
                }
            }
            $this->saveItemsToFile();

            return $item ?? null;
        } catch (\Exception $e) {
            throw new \Error(
                json_encode(['status' => 'fatal']),
                AppException::INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteByField(string $field, string $value): ?object
    {
        try {

            foreach ($this->items as $index => $itemFind) {
                if (isset($itemFind->$field)) {
                    if ($itemFind->$field == $value) {
                        $item = $itemFind;
                        array_splice($this->items, $index, 1);
                    }
                }
            }

            $this->saveItemsToFile();

            return $item ?? null;
        } catch (\Exception $e) {
            throw new \Error(
                json_encode(['status' => 'fatal']),
                AppException::INTERNAL_SERVER_ERROR
            );
        }
    }

    public function saveItemsToFile()
    {
        $json = json_encode($this->items);
        file_put_contents($this->path, $json);
    }
}