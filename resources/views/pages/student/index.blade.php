<x-admin title="Student">
    <x-page-header head="Student" />
    <div class="row">
        <div class="col-md-12">
            <x-data-table dataUrl="/student" id="students" :columns="$columns" />
        </div>
    </div>
    @push('js')
        <script>
             
        </script>
    @endpush
</x-admin>