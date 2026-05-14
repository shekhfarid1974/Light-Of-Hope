<?php

namespace App\Repositories\Contracts;

interface CrmRepositoryInterface
{
    public function getAll();
    public function getRecent(int $limit);
    public function count();
    public function create(array $data);
    public function getHistoryByPhone(string $phone);
    public function getCallBacks();
}
