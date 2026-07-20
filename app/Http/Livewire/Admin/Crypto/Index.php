<?php

namespace App\Http\Livewire\Admin\Crypto;

use Livewire\Component;
use App\Models\CryptoCurrencies;
use Livewire\WithFileUploads;
use App\Jobs\AddCryptoWallet;
use App\Jobs\ExchangeRate;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Http;

class Index extends Component
{
    use WithFileUploads;

    public $admin;
    public $settings;
    public $active = 1;
    public string $currency;
    public $vendor = 'hasapay';
    public string $name;
    public $image;
    public $search;

    protected $listeners = ['saved' => '$refresh'];

    public function addCurrency()
    {
        $this->validate([
            'currency' => ['required'],
            'image' => 'required|file|mimetypes:' . allowedImageTypes() . '|max:' . allowedFileSize(),
        ]);

        $crypto = $this->cryptos()[$this->currency];

        if (CryptoCurrencies::whereNetwork($crypto['network'])->whereToken($crypto['token'])->exists()) {
            return $this->emit('alert', __('Cryptocurrency already added'));
        }

        if (CryptoCurrencies::whereNetwork($crypto['network'])->whereToken($crypto['token'])->withTrashed()->exists()) {
            $check = CryptoCurrencies::whereNetwork($crypto['network'])->whereToken($crypto['token'])->withTrashed();
            if ($check->first()->deleted_at != null) {
                $check->restore();
                dispatch(new AddCryptoWallet());
                $this->emit('saved');
                $this->emit('drawer');
                return $this->emit('success', __('Currency Restored from trash'));
            }
        }

        $filePath = Cloudinary::upload($this->image->getRealPath(), [
            'folder' => 'images',
            'format' => 'jpg'
        ])->getSecurePath();

        CryptoCurrencies::create([
            'network' => $crypto['network'],
            'token' => $crypto['token'],
            'status' => $this->active,
            'image' => $filePath,
            'crypto_wallet_vendor' => $this->vendor,
            'name' => $crypto['name'],
        ]);

        dispatch(new AddCryptoWallet());

        $this->reset(['currency', 'image', 'name', 'active']);
        $this->emit('drawer');
        $this->emit('resetForm');
        $this->emit('saved');
        $this->emit('success', __('Crypto created'));
    }

    public function cryptos()
    {
        return [
            [
                'network' => 'ETH',
                'token' => 'ETH',
                'name' => 'Ethereum'
            ],
            [
                'network' => 'ETH',
                'token' => 'USDC',
                'name' => 'USD Coin'
            ],
            [
                'network' => 'TRX',
                'token' => 'USDT',
                'name' => 'Tether USD'
            ],
            [
                'network' => 'TRX',
                'token' => 'TRX',
                'name' => 'Tronix'
            ],
        ];
    }

    public function allCurrencies()
    {
        return CryptoCurrencies::when($this->search, function ($query) {
            $this->emit('drawer');
            $query->Where('token', 'like', '%' . $this->search . '%')
                ->orWhere('network', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%');
        })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })->orderBy('network', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.admin.crypto.index', ['data' => $this->allCurrencies()]);
    }
}
