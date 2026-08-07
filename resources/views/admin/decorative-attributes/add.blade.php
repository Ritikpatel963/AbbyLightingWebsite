@extends('admin.page')
@section('title', $title)
@section('content_header')
<div class="row mb-2">
  <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
    <h1 class="m-0">{{ $title }}</h1>
    <a href="{{ route('decorative_attribute_admin') }}" class="btn btn-secondary"><i class="ft-arrow-left mr-1"></i>Back to List</a>
  </div>
</div>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ $action }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Attribute Name (e.g., Colour, Size)</label>
                            <input type="text" name="name" class="form-control" required placeholder="Enter attribute name">
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Attribute Values</h5>
                        <button type="button" class="btn btn-sm btn-info" id="add-value">Add Value</button>
                    </div>

                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Value Name (e.g., Red, Small)</th>
                                <th>Hex Code (optional)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="values-container">
                            <!-- JS injected values -->
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary mt-3">Save Attribute</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('extra_js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let valueIndex = 0;

    document.getElementById('add-value').addEventListener('click', function() {
        const attrName = document.querySelector('input[name="name"]').value.toLowerCase();
        const isColor = attrName.includes('color') || attrName.includes('colour') || attrName.includes('finish');
        
        let hexHtml = '';
        if (isColor) {
            hexHtml = `
                <div class="input-group input-group-sm">
                    <input type="color" class="form-control form-control-sm p-1" style="max-width: 40px; cursor: pointer;" onchange="this.nextElementSibling.value = this.value" value="#ffffff">
                    <input type="text" name="values[${valueIndex}][hex_code]" class="form-control form-control-sm" placeholder="#ffffff">
                </div>
            `;
        } else {
            hexHtml = `<input type="text" name="values[${valueIndex}][hex_code]" class="form-control form-control-sm" placeholder="Leave blank for non-colors">`;
        }

        const container = document.getElementById('values-container');
        const tr = `
            <tr>
                <td><input type="text" name="values[${valueIndex}][name]" class="form-control form-control-sm" required placeholder="e.g. White"></td>
                <td>
                    ${hexHtml}
                </td>
                <td><button type="button" class="btn btn-sm btn-danger remove-val">X</button></td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', tr);
        valueIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-val')) {
            e.target.closest('tr').remove();
        }
    });
});
</script>
@stop
@stop
