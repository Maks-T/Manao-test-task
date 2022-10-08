<?php

namespace App\Services;

class RequestService
{
    public function getData(): array
    {
        $req = json_decode(file_get_contents('php://input'));
        $data = [];
        foreach ($req as $field => $valueField) {
            $data[$field] = $valueField;
        }

        return $data;
    }
}