<?php

namespace App\Repositories;

use App\Models\CRM;
use App\Repositories\Contracts\CrmRepositoryInterface;

class CrmRepository implements CrmRepositoryInterface
{
    public function getAll()
    {
        return CRM::with(['district', 'dataSource'])->latest()->get();
    }

    public function getRecent(int $limit)
    {
        return CRM::with(['district', 'dataSource'])->latest()->take($limit)->get();
    }

    public function count()
    {
        return CRM::count();
    }

    public function create(array $data)
    {
        return CRM::create($data);
    }

    public function getHistoryByPhone(string $phone)
    {
        return CRM::with(['district', 'dataSource'])
            ->where('phone', $phone)
            ->latest()
            ->get();
    }
}
