<div class="radio-item">
    <div class="radio-img">
        <img src="{{ $radio->getImgUrl() }}"></img>
    </div>
    <div class="radio-title">  
        <a href="{{ route('radios.show', $radio->id) }}">
            <h4>{{ $radio->name }}</h4>
        </a>
    </div>
</div>
