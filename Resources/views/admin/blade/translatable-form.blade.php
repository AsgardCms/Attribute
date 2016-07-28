<div class="box-group" id="accordion">
    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
    <div class="panel box box-primary">
        <div class="box-header">
            <h4 class="box-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#attributes-{{ $locale }}" aria-expanded="false">
                    Attributes
                </a>
            </h4>
        </div>
        <div id="attributes-{{ $locale }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
            <div class="box-body">
                {!! $form !!}
            </div>
        </div>
    </div>
</div>
