<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Jobs\SendEmail;
use App\Exports\AuditExport;
use Maatwebsite\Excel\Facades\Excel;

class Audit extends Component
{
    public $perPage = 200;
    public $admin;
    public $client;
    public $settings;
    public $search = "";
    public $status = "";
    public $priority = "";
    public $orderBy = "created_at";
    public $sortBy = "desc";
    public $exportEmail;

    protected $listeners = ['saved' => '$refresh'];

    public function mount(){
        $this->exportEmail = $this->admin->email;
    }
    
    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function save()
    {
        $this->validate([
            'exportEmail' => ['required', 'email:rfc,dns']
        ]);

        $query = [
            'business_id' => $this->client->business_id,
        ];

        $filename = $this->client->business_id . now() . '-audit.xlsx';
        Excel::queue(new AuditExport($query), $filename)
            ->chain([
                new SendEmail(
                    $this->settings->email,
                    $this->settings->site_name,
                    __('Audit Log'),
                    __('Audit log of ') . $this->client?->business?->name,
                    storage_path('app/' . $filename),
                    null,
                    null,
                    [$this->exportEmail]
                )
            ]);

        $this->emit('success', __('Transaction Statement sent to your email'));
    }

    protected function pages()
    {
        return \App\Models\Audit::whereBusinessId($this->client->business_id)->withTrashed()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->Where('log', 'like', '%' . $this->search . '%');
                });
            })
            ->orderby($this->orderBy, $this->sortBy);
    }

    public function render()
    {
        return view('livewire.admin.users.audit', ['audit' => $this->pages()->paginate($this->perPage)]);
    }
}
