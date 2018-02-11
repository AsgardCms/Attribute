<?php $oldOptions = old('options') !== null ? OptionsNormaliser::normalise(old('options')) : null ?>

<div class="jumbotron noOptionsArea"
     style="{{ (isset($attribute) && $attribute->useOptions() === false) && $oldOptions === null ? '' : 'display: none;'}}">
    <h4 class="text-center">{{ trans('attribute::attributes.no options') }}</h4>
</div>

<div class="form-group optionsArea" style="{{ (isset($attribute) && $attribute->useOptions() === true) || $oldOptions !== null ? '' : 'display: none;'}}">
    <div class="dd">
        <ol class="options list-group dd-list jsOptionsWrapper" data-item-count="0">
            <li class="dd-item hidden jsItemTemplate">
                <div class="form-inline">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon dd-handle"><i class="fa fa-arrows"></i></div>
                            <input class="form-control" name="options[count][value]"
                                   type="text" value="" placeholder="{{ trans('attribute::attributes.option value') }}">
                        </div>
                        <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                        <div class="lang-group {{ $locale }}" style="{{ $locale !== locale() ? 'display: none;' : ''}}">
                            <input class="form-control" id="label" name="options[count][{{$locale}}][label]"
                                   type="text" value="" placeholder="{{ trans('attribute::attributes.option label') }}">
                        </div>
                        <?php endforeach; ?>
                        <select name="" class="form-control jsOptionLanguage">
                            <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                            <option value="{{ $locale }}">{{ $language['name'] }}</option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-default jsAddRow"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-default jsRemoveRow"><i class="fa fa-trash-o"></i></button>
                    </div>
                </div>
            </li>
            @include('attribute::admin.attributes.partials.old_options')
        </ol>
    </div>
</div>
