<div class="radio-item">
    <div class="col-sm-3 col-md-2">
        <div class="thumbnail">
            <img src="{{ asset('images/radio_logo.jpg') }}" alt="...">
            <div class="caption">  
                <a href="{{ route('radios.show', $radio->id) }}">
                    <h4>{{ $radio->name }}</h4>
                </a>
            </div>
        </div>
    </div>
</div>
