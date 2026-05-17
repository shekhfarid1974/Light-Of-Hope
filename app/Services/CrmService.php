<?php

namespace App\Services;

use App\Repositories\Contracts\CrmRepositoryInterface;

class CrmService
{
    protected $crmRepository;

    public function __construct(CrmRepositoryInterface $crmRepository)
    {
        $this->crmRepository = $crmRepository;
    }

    public function getAllCrms(string $type = null)
    {
        return $this->crmRepository->getAll($type);
    }

    public function getDashboardCrms()
    {
        // Currently the user wants the full report on the dashboard, so we get all.
        // If they ever want it paginated, we would adjust this.
        return $this->crmRepository->getAll();
    }

    public function getTotalCrms()
    {
        return $this->crmRepository->count();
    }

    public function createCrm(array $data)
    {
        $crm = $this->crmRepository->create($data);

        if (!empty($data['call_back'])) {
            \App\Models\CallBack::create([
                'crm_id'  => $crm->id,
                'name'    => $crm->parents_name ?? $crm->trainee_name ?? '—',
                'date'    => $data['call_back_date'] ?? null,
                'time'    => $data['call_back_time'] ?? null,
                'remarks' => $crm->remarks ?? $crm->query_complaint,
            ]);
        }

        return $crm;
    }

    public function getHistoryForAjax(string $phone)
    {
        $records = $this->crmRepository->getHistoryByPhone($phone);

        return $records->map(function ($r) {
            return [
                'id' => $r->id,
                'parents_name' => $r->parents_name,
                'phone' => $r->phone,
                'district' => $r->district ? $r->district->name : '—',
                'interested_for' => $r->interested_for,
                'calling_status' => $r->calling_status,
                'query_source' => $r->query_source,
                'query_status' => $r->query_status,
                'assigned_person' => $r->assigned_person,
                'data_source' => $r->dataSource ? $r->dataSource->name : '—',
                'date' => $r->created_at->format('d M Y h:i A'),
            ];
        });
    }

    public function getCallBackCrms()
    {
        return $this->crmRepository->getCallBacks();
    }
}
