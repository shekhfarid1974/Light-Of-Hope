<?php

namespace App\Repositories;

use App\Models\KidsCrm;
use App\Models\TeachersCrm;
use App\Models\CallBack;
use App\Repositories\Contracts\CrmRepositoryInterface;

class CrmRepository implements CrmRepositoryInterface
{
    public function getAll(string $type = null)
    {
        if ($type === 'kids_crm') {
            return KidsCrm::with(['district', 'dataSource'])->latest()->get();
        } elseif ($type === 'teachers_crm') {
            return TeachersCrm::with(['district', 'dataSource'])->latest()->get();
        }

        $course = KidsCrm::with(['district', 'dataSource'])->latest()->get()->map(function($item) {
            $item->crm_type = 'kids_crm';
            return $item;
        });
        $teachers = TeachersCrm::with(['district', 'dataSource'])->latest()->get()->map(function($item) {
            $item->crm_type = 'teachers_crm';
            return $item;
        });

        return $course->concat($teachers)->sortByDesc('created_at')->values();
    }

    public function getRecent(int $limit)
    {
        $course = KidsCrm::with(['district', 'dataSource'])->latest()->take($limit)->get()->map(function($item) {
            $item->crm_type = 'kids_crm';
            return $item;
        });
        $teachers = TeachersCrm::with(['district', 'dataSource'])->latest()->take($limit)->get()->map(function($item) {
            $item->crm_type = 'teachers_crm';
            return $item;
        });

        return $course->concat($teachers)->sortByDesc('created_at')->take($limit)->values();
    }

    public function count()
    {
        return KidsCrm::count() + TeachersCrm::count();
    }

    public function create(array $data)
    {
        $type = $data['crm_type'] ?? null;
        unset($data['crm_type']);

        return match ($type) {
            'kids_crm' => KidsCrm::create($data),
            'teachers_crm' => TeachersCrm::create($data),
            default => throw new \InvalidArgumentException("Invalid CRM type: {$type}"),
        };
    }

    public function getHistoryByPhone(string $phone)
    {
        $course = KidsCrm::with(['district', 'dataSource'])
            ->where(function($q) use ($phone) {
                $q->where('father_phone', $phone)
                  ->orWhere('mother_phone', $phone);
            })
            ->latest()
            ->get()
            ->map(function($item) {
                $item->crm_type = 'kids_crm';
                return $item;
            });
            
        $teachers = TeachersCrm::with(['district', 'dataSource'])
            ->where('phone', $phone)
            ->latest()
            ->get()
            ->map(function($item) {
                $item->crm_type = 'teachers_crm';
                return $item;
            });

        return $course->concat($teachers)->sortByDesc('created_at')->values();
    }

    public function getCallBacks()
    {
        return CallBack::with('crm')->latest()->get();
    }
}
