<?php

namespace App\Http\Livewire\Admin\Withdraw;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;

class Index extends Component
{

    use WithFileUploads;

    private $methods;
    public $search = "";
    public $perPage = 10;
    public $orderBy = "created_at";
    public $sortBy = "desc";
    public $admin;
    public $name;
    public $min;
    public $max;
    public $requirements;
    public $fc;
    public $pc;    
    public $fc_required = 1;
    public $pc_required = 1;
    public $pct;
    public $status = 1;
    public $image;

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function updatedPct(){
        if($this->pct == 'both'){
            $this->fc_required = 1;
            $this->pc_required = 1;
        }elseif($this->pct == 'percent'){
            $this->fc_required = 0;
            $this->pc_required = 1;
        }elseif($this->pct == 'none'){
            $this->fc_required = 0;
            $this->pc_required = 0;
        }else{
            $this->fc_required = 1;
            $this->pc_required = 0;
        }
    }

    public function addMethod()
    {

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'min' => ['required', 'integer', 'lt:max'],
            'max' => ['required', 'integer', 'gte:min'],
            'status' => ['required'],
            'requirements' => ['required'],
            'fc' => ['required', 'numeric'],
            'pc' => ['required', 'numeric'],
            'pct' => ['required'],
            'image' => 'required|file|mimes:'.allowedFileTypes().'|max:'.allowedFileSize(),
        ]);

        $filePath = $this->image->storePublicly('withdraw');

        Category::create([
            'name' =>  $this->name,
            'min' => $this->min,
            'max' => $this->max,
            'status' => $this->status,
            'requirements' => $this->requirements,
            'fc' => $this->fc,
            'pc' => $this->pc,
            'pct' => $this->pct,
            'type' => 'withdraw',
            'image' => $filePath,
        ]);
        $this->reset(['name', 'min', 'max', 'status', 'requirements', 'fc', 'pc', 'pct', 'image']);
        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('success', __('Payout Method Created'));
    }

    public function disable(Category $method)
    {
        $method->update(['status' => 0]);
        $this->emit('success', __('Disabled'));
        $this->emitUp('saved');
    }

    public function enable(Category $method)
    {
        $method->update(['status' => 1]);
        $this->emit('success', __('Enabled'));
        $this->emitUp('saved');
    }

    public function render()
    {
        $this->methods = Category::whereType('withdraw')
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->Where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->paginate($this->perPage);

        return view('livewire.admin.withdraw.index', ['methods' => $this->methods]);
    }
}
