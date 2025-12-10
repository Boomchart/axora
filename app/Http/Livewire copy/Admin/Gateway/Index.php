<?php

namespace App\Http\Livewire\Admin\Gateway;

use Livewire\Component;
use App\Models\Gateway;
use Livewire\WithFileUploads;

class Index extends Component
{

    use WithFileUploads;

    private $manual;
    private $gateway;
    public $search = "";
    public $admin;
    public $currency;
    public $name;
    public $min;
    public $max;
    public $fc;
    public $pc;
    public $instructions;
    public $details;
    public $receipt = 1;
    public $crypto = 0;
    public $wallet_address;
    public $status = 1;
    public $showCrypto = 0;
    public $image;

    protected $listeners = ['saved' => '$refresh'];

    public function updatedCrypto(){
        if($this->crypto == 1){
            $this->showCrypto = 1;
        }else{
            $this->showCrypto = 0;
        }
    }

    public function addMethod()
    {

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'min' => ['required', 'integer', 'lt:max'],
            'max' => ['required', 'integer', 'gte:min'],
            'status' => ['required'],
            'fc' => ['required', 'numeric'],
            'pc' => ['required', 'numeric'],
            'crypto' => ['required'],
            'instructions' => ['required'],
            'details' => ['required'],
            'wallet_address' => [($this->crypto == 1) ? 'required' : 'nullable'],
            'image' => 'required|file|mimes:'.allowedFileTypes().'|max:'.allowedFileSize(),
        ]);

        $filePath = $this->image->storePublicly('gateway');

        Gateway::create([
            'name' => $this->name,
            'minamo' => $this->min,
            'maxamo' => $this->max,
            'fiat_charge' => $this->fc,
            'percent_charge' => $this->pc,
            'val1' => $this->details,
            'val2' => $this->wallet_address,
            'instructions' => $this->instructions,
            'crypto' => $this->crypto,
            'type' => 1,
            'status' => $this->status,
            'receipt' => $this->receipt,
            'image' => $filePath,
        ]);

        $this->reset(['name', 'min', 'max', 'status', 'fc', 'pc', 'instructions', 'details', 'wallet_address', 'crypto', 'receipt', 'image']);
        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('success', __('Gateway Created'));
    }

    public function render()
    {
        $this->manual = Gateway::whereType(1)
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                return $query->Where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderBy('name', 'ASC')
            ->get();
            
        $this->gateway = Gateway::orderBy('name', 'ASC')->get();

        return view('livewire.admin.gateway.index', ['manual' => $this->manual, 'gateway' => $this->gateway]);
    }
}
