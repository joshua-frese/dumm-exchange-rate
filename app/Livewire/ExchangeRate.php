<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\CoinEnum;
use App\APIs\CoinGeckoApi;

class ExchangeRate extends Component
{
    public array $options = [];
    public string $convertRates = '';

    public $amount = 1;

    public string $result = '0';
    public string $labelAmount = '';
    public string $labelResult = '';
    public float $exchangeRate = 0;

    private array $coins = [];
    private CoinGeckoApi $coinGekoApi;

    public function boot(
        CoinGeckoApi $coinGekoApi,
    )
    {
        $this->coinGekoApi = $coinGekoApi;
    }

    public function mount()
    {
        $this->options = $this->buildExchangeRateOptions();
        $this->convertRates = $this->options[1]['value']; // Als Beispiel einfach den 2. Eintrag nehmen
        $this->changeCurrencyComparison();
    }

    public function rules() {
        $names = implode('|', CoinEnum::names());

        return [
            'amount' => 'required|numeric',
            'convertRates' => ['required', 'regex:/^[' . $names . ']*\:['. $names . ']*$/']
        ];
    }

    public function render()
    {
        return view('livewire.exchange-rate');
    }

    public function changeCurrencyComparison()
    {
        $this->validateOnly('convertRates');

        $fromRate = $this->getFromRate();
        $toRate =  $this->getToRate();

        $this->exchangeRate = $this->coinGekoApi->getExchangeRateFor($fromRate, $toRate);
        $this->labelResult = $toRate->name;
        $this->labelAmount = $fromRate->name;
        $this->newResult();
    }

    public function newResult()
    {
        $this->validateOnly('amount');

        $this->result = $this->formatFloat(($this->amount ?? 0) * $this->exchangeRate);
    }

    public function formatFloat(float $float): string
    {
        return number_format($float, 6, ',', '.');
    }

    #region Private
    private function getFromRate()
    {
        $value = $this->splitConvertRates()[0];
        return CoinEnum::{$value};
    }

    private function getToRate()
    {
        $value = $this->splitConvertRates()[1];
        return CoinEnum::{$value};
    }

    private function splitConvertRates(): array
    {
        return explode(':', $this->convertRates);
    }

    private function buildExchangeRateOptions(): array
    {
        $options = [];

        $enumCases = CoinEnum::cases();

        foreach ($enumCases as $fromEnum) {
            foreach ($enumCases as $toEnum) {
                if ($fromEnum->name !== $toEnum->name) {
                    $options[] = [
                        'value' => $fromEnum->name . ':' . $toEnum->name,
                        'title' => $fromEnum->name . ' => ' . $toEnum->name
                    ];
                }
            }
        }
        
        return $options;
    }
    #endregion
}
