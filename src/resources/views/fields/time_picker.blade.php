<!-- bootstrap timepicker input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <input type="hidden" name="{{ $field['name'] }}" value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}">
    <label>{!! $field['label'] !!}</label>
    <div class="input-group bootstrap-timepicker timepicker">
        <input
            data-bs-timepicker="{{ isset($field['time_picker_options']) ? json_encode($field['time_picker_options']) : '{}'}}"
            type="text"
            @include('crud::inc.field_attributes')
            >
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-time"></span>
        </div>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/timepicker/bootstrap-timepicker.min.css') }}">
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="{{ asset('vendor/adminlte/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script>
        if (jQuery.ui) {
            var timepicker = $.fn.timepicker.noConflict();
            $.fn.bootstrapTP = timepicker;
        } else {
            $.fn.bootstrapTP = $.fn.timepicker;
        }

        jQuery(document).ready(function($){
            $('[data-bs-timepicker]').each(function(){

                var $fake = $(this),
                $field = $fake.parents('.form-group').find('input[type="hidden"]'),
                $customConfig = $.extend({
                    showInputs: 'true'
                }, $fake.data('bs-timepicker'));
                $picker = $fake.bootstrapTP($customConfig);

                var $existingVal = $field.val();

                if( $existingVal.length ){
                    $fake.val($existingVal);
                    $picker.bootstrapTP('setTime', $existingVal);
                }

               $fake.focus(function (){
                $fake.timepicker('showWidget');
                });

               $picker.on('show hide change', function(e){
                    if( e.date ){
                        var sqlTime = e.format('H:i:s');
                    } else {
                        try {
                            var sqlTime = $fake.val();
                        } catch(e){
                            if( $fake.val() ){
                                PNotify.removeAll();
                                new PNotify({
                                    title: 'Whoops!',
                                    text: 'Sorry we did not recognise that time format, please make sure it uses a h:m:s combination',
                                    type: 'error',
                                    icon: false
                                });
                            }
                        }
                    }
                    $field.val(sqlTime);
                });
            });
        });
    </script>
    @endpush
@endif
{{-- End of Extra CSS and JS --}}
