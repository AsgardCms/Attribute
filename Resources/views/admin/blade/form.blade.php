{!! $form !!}

@if ($entity->hasTranslatableAttribute())
    <hr>

    <div class="nav-tabs-custom">
        @include('partials.form-tab-headers', ['prefix' => 'attributes'])
        <div class="tab-content">
            {!! $translatableForm !!}
        </div>
    </div>

@endif
