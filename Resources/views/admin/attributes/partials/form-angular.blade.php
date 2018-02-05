@push('js-stack')
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js"></script>
<script src="{{ Module::asset('attribute:js/ng-components/slug-only.directive.js') }}"></script>
<script>
angular.module('app', [
    'app.directive.slug-only'
])
.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('{%');
  $interpolateProvider.endSymbol('%}');
});
</script>
@endpush
