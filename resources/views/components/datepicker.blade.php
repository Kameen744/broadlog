<div>
    <div>
        <input
        x-data
        x-ref="input"
        x-init="$(this).datetimepicker({ field: $refs.input })"
        type="time"
        {{ $attributes }}
        >
    </div>
</div>
@push('scripts')
    {{-- <script>
        $('.timepicker').datetimepicker({
                format: "LT",
            }).on('change', function(e){
                // @this.set('time_from', e.target.value)
                console.log(e.target.value);
            });
    </script> --}}
@endpush
