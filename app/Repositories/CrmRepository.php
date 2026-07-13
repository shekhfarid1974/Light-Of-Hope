<?php

namespace App\Repositories;

use App\Models\CourseOutboundCrm;
use App\Models\TeachersTrainingCrm;
use App\Models\CallBack;
use App\Repositories\Contracts\CrmRepositoryInterface;

class CrmRepository implements CrmRepositoryInterface
{
    public function getAll(string $type = null)
    {
        if ($type === 'course_outbound') {
            return CourseOutboundCrm::with(['district', 'dataSource'])->latest()->get();
        } elseif ($type === 'teachers_training') {
            return TeachersTrainingCrm::with(['district', 'dataSource'])->latest()->get();
        }

        $course = CourseOutboundCrm::with(['district', 'dataSource'])->latest()->get()->map(function($item) {
            $item->crm_type = 'course_outbound';
            return $item;
        });
        $teachers = TeachersTrainingCrm::with(['district', 'dataSource'])->latest()->get()->map(function($item) {
            $item->crm_type = 'teachers_training';
            return $item;
        });

        return $course->concat($teachers)->sortByDesc('created_at')->values();
    }

    public function getRecent(int $limit)
    {
        $course = CourseOutboundCrm::with(['district', 'dataSource'])->latest()->take($limit)->get()->map(function($item) {
            $item->crm_type = 'course_outbound';
            return $item;
        });
        $teachers = TeachersTrainingCrm::with(['district', 'dataSource'])->latest()->take($limit)->get()->map(function($item) {
            $item->crm_type = 'teachers_training';
            return $item;
        });

        return $course->concat($teachers)->sortByDesc('created_at')->take($limit)->values();
    }

    public function count()
    {
        return CourseOutboundCrm::count() + TeachersTrainingCrm::count();
    }

    public function create(array $data)
    {
        $type = $data['crm_type'] ?? null;
        unset($data['crm_type']);

        return match ($type) {
            'course_outbound' => CourseOutboundCrm::create($data),
            'teachers_training' => TeachersTrainingCrm::create($data),
            default => throw new \InvalidArgumentException("Invalid CRM type: {$type}"),
        };
    }

    public function getHistoryByPhone(string $phone)
    {
        $course = CourseOutboundCrm::with(['district', 'dataSource'])->where('phone', $phone)->latest()->get()->map(function($item) {
            $item->crm_type = 'course_outbound';
            return $item;
        });
        $teachers = TeachersTrainingCrm::with(['district', 'dataSource'])->where('phone', $phone)->latest()->get()->map(function($item) {
            $item->crm_type = 'teachers_training';
            return $item;
        });

        return $course->concat($teachers)->sortByDesc('created_at')->values();
    }

    public function getCallBacks()
    {
        return CallBack::with('crm')->latest()->get();
    }
}
