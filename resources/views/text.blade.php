<div class="form-group row {{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="title" class="col-md-2 col-form-label form-control-label">{{ text_format($name) }}</label>
    <div class="col-md-7">
        <input id="{{ $name }}" type="text" class="form-control" name="{{ $name }}"
            value="{{ old($name) }}">

        @if ($errors->has($name))
            <span class="text-danger">{{ $errors->first($name) }}</span>
        @endif
    </div>
</div>