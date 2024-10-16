<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Repository
{
    protected $model;

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getAllPaginated(int $paginate = 25)
    {
        return $this->model->paginate($paginate);
    }

    public function whereIn(string $field, array $values = []): Collection
    {
        return $this->model->whereIn($field, $values)->get();
    }

    public function create(array $create): Model
    {
        return $this->model
            ->create($create);
    }

    private function encryptBeforeUpdate(array $encryptable, array $update): array
    {
        foreach ($encryptable as $key) {
            if (isset($update[$key]) && (! is_null($update[$key])) && $update[$key] != '') {
                $update[$key] = Crypt::encryptString($update[$key]);
            }
        }

        return $update;
    }

    private function decryptBeforeUpdate(array $encryptable, $update): array
    {
        foreach ($encryptable as $key) {
            if (isset($update[$key]) && (! is_null($update[$key])) && $update[$key] != '') {
                try {
                    $update[$key] = Crypt::decryptString($update[$key]);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

        return $update;
    }

    public function update(int $id, array $update): Model
    {
        if (method_exists($this->model, 'getEncryptable') && $encryptable = $this->model->getEncryptable()) {
            $update = $this->encryptBeforeUpdate($encryptable, $update);
        }

        $this->model
            ->where('id', $id)
            ->update($update);

        return $this->model
            ->where('id', $id)
            ->first();
    }

    public function deleteWhere(array $where): bool
    {
        return $this->model->where($where)->delete();
    }
}
