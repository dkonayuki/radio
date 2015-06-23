<div class="radio-item">
    <div class="radio-img">
        <img src="{{ asset('images/radio_logo.jpg') }}" alt="...">
        <div class="caption">  
            <a href="{{ route('radios.show', $radio->id) }}">
                <h4>{{ $radio->name }}</h4>
            </a>
        </div>
    </div>
</div>
