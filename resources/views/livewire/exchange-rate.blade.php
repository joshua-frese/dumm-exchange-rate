<div class="container" wire:poll.10000ms="changeCurrencyComparison">
    <h1>Wechselkurs</h1>

    <label for="currency">Wechselkurs auswählen:</label>
    <select wire:model='convertRates' id='convertRates' wire:change="changeCurrencyComparison">
        @foreach ($options as $data)
            <option value="{{$data['value']}}">
                {{$data['title']}}
            </option>    
        @endforeach
    </select>
    @error('convertRates') <div class='error-message'>{{ $message }}</div> @enderror


    <div class="rate-display">
        Derzeitiger Wechselkurs: 1 {{ $labelAmount }} =  {{ $this->formatFloat($exchangeRate) . ' ' . $labelResult }}
    </div>

    <label for="amount">{{ $labelAmount }}</label>
    <input type="text" wire:model.blur="amount" id="amount" wire:keyup="newResult">
    @error('amount') <div class='error-message'>{{ $labelAmount }} muss eine Zahl sein</div> @enderror

    <div class="result-display">
        Ergebnis: @if($errors->any()) - @else {{ $result }} {{ $labelResult }} @endif
    </div>

</div>