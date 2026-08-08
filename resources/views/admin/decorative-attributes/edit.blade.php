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
                            <input type="text" name="name" class="form-control" required value="{{ $attribute->name }}">
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
                            @foreach($attribute->values as $index => $val)
                            <tr>
                                <td><input type="text" name="values[{{ $index }}][name]" class="form-control form-control-sm" required value="{{ $val->name }}"></td>
                                <td>
                                    @php
                                        $attrNameLower = strtolower($attribute->name);
                                        $isColor = str_contains($attrNameLower, 'color') || str_contains($attrNameLower, 'colour') || str_contains($attrNameLower, 'finish');
                                    @endphp
                                    @if($isColor)
                                        @php
                                            $valHex = $val->hex_code ?? '#ffffff';
                                            $isGradient = str_contains($valHex, 'gradient');
                                            $gradAngle = 45;
                                            $gradColor1 = '#ffffff';
                                            $gradColor2 = '#000000';
                                            if ($isGradient) {
                                                preg_match('/linear-gradient\(\s*(\d+)deg\s*,\s*(#[a-fA-F0-9]{3,6})\s*,\s*(#[a-fA-F0-9]{3,6})\s*\)/', $valHex, $matches);
                                                if(count($matches) >= 4) {
                                                    $gradAngle = $matches[1];
                                                    $gradColor1 = $matches[2];
                                                    $gradColor2 = $matches[3];
                                                }
                                            }
                                        @endphp
                                        <div class="color-input-container">
                                            <div class="mb-1 d-flex align-items-center" style="gap: 5px;">
                                                <select class="form-control form-control-sm color-type-select" style="width: auto;">
                                                    <option value="solid" {{ !$isGradient ? 'selected' : '' }}>Solid</option>
                                                    <option value="gradient" {{ $isGradient ? 'selected' : '' }}>Gradient</option>
                                                </select>
                                                <div class="solid-picker" style="{{ $isGradient ? 'display: none;' : 'display: block;' }}">
                                                    <input type="color" class="form-control form-control-sm p-1 color-1" style="max-width: 40px; cursor: pointer;" value="{{ !$isGradient ? $valHex : $gradColor1 }}">
                                                </div>
                                                <div class="gradient-pickers" style="{{ $isGradient ? 'display: flex;' : 'display: none;' }} align-items: center; gap: 5px;">
                                                    <input type="color" class="form-control form-control-sm p-1 color-1" style="max-width: 40px; cursor: pointer;" value="{{ $gradColor1 }}">
                                                    <input type="color" class="form-control form-control-sm p-1 color-2" style="max-width: 40px; cursor: pointer;" value="{{ $gradColor2 }}">
                                                    <div class="input-group input-group-sm" style="width: 80px;">
                                                        <input type="number" class="form-control gradient-angle" value="{{ $gradAngle }}">
                                                        <div class="input-group-append"><span class="input-group-text">deg</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" name="values[{{ $index }}][hex_code]" class="form-control form-control-sm final-color-output" placeholder="#ffffff" value="{{ $valHex }}">
                                        </div>
                                    @else
                                        <input type="text" name="values[{{ $index }}][hex_code]" class="form-control form-control-sm" placeholder="Leave blank for non-colors" value="{{ $val->hex_code }}">
                                    @endif
                                </td>
                                <td><button type="button" class="btn btn-sm btn-danger remove-val">X</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary mt-3">Update Attribute</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('extra_js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let valueIndex = {{ $attribute->values->count() }};

    document.getElementById('add-value').addEventListener('click', function() {
        const attrName = document.querySelector('input[name="name"]').value.toLowerCase();
        const isColor = attrName.includes('color') || attrName.includes('colour') || attrName.includes('finish');
        
        let hexHtml = '';
        if (isColor) {
            hexHtml = `
                <div class="color-input-container">
                    <div class="mb-1 d-flex align-items-center" style="gap: 5px;">
                        <select class="form-control form-control-sm color-type-select" style="width: auto;">
                            <option value="solid">Solid</option>
                            <option value="gradient">Gradient</option>
                        </select>
                        <div class="solid-picker">
                            <input type="color" class="form-control form-control-sm p-1 color-1" style="max-width: 40px; cursor: pointer;" value="#ffffff">
                        </div>
                        <div class="gradient-pickers" style="display: none; align-items: center; gap: 5px;">
                            <input type="color" class="form-control form-control-sm p-1 color-1" style="max-width: 40px; cursor: pointer;" value="#ffffff">
                            <input type="color" class="form-control form-control-sm p-1 color-2" style="max-width: 40px; cursor: pointer;" value="#000000">
                            <div class="input-group input-group-sm" style="width: 80px;">
                                <input type="number" class="form-control gradient-angle" value="45">
                                <div class="input-group-append"><span class="input-group-text">deg</span></div>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="values[${valueIndex}][hex_code]" class="form-control form-control-sm final-color-output" placeholder="#ffffff">
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

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('color-type-select')) {
            const container = e.target.closest('.color-input-container');
            const solidPicker = container.querySelector('.solid-picker');
            const gradPickers = container.querySelector('.gradient-pickers');
            if (e.target.value === 'gradient') {
                solidPicker.style.display = 'none';
                gradPickers.style.display = 'flex';
            } else {
                solidPicker.style.display = 'block';
                gradPickers.style.display = 'none';
            }
            updateColorOutput(container);
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('color-1') || e.target.classList.contains('color-2') || e.target.classList.contains('gradient-angle')) {
            const container = e.target.closest('.color-input-container');
            if (container) {
                if (e.target.classList.contains('color-1')) {
                    const c1s = container.querySelectorAll('.color-1');
                    c1s.forEach(el => el.value = e.target.value);
                }
                updateColorOutput(container);
            }
        }
    });

    function updateColorOutput(container) {
        const type = container.querySelector('.color-type-select').value;
        const output = container.querySelector('.final-color-output');
        const color1 = container.querySelector('.color-1').value;
        if (type === 'solid') {
            output.value = color1;
        } else {
            const color2 = container.querySelector('.color-2').value;
            const angle = container.querySelector('.gradient-angle').value || 45;
            output.value = `linear-gradient(${angle}deg, ${color1}, ${color2})`;
        }
    }
});
</script>
@stop
@stop
