@extends('admin.page')

@section('title', $title)
@section('content_header')
<div class="row">
    <div class="col-12">
        <div class="my-3">
            <h4>{{ $title }}</h4>
            <a href="{{ route('decorative_product_admin') }}" class="btn btn-secondary mt-2">Back to List</a>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('decorative_product_admin.insert') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title">Title *</label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="sku">SKU *</label>
                            <input type="text" name="sku" class="form-control" required value="{{ old('sku') }}">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="categories">Categories</label>
                            <select name="categories[]" class="form-control select2" multiple="multiple" data-placeholder="Select Categories">
                                @foreach($categories as $category)
                                    @if($category->parent_id == null)
                                        <optgroup label="{{ $category->name }}">
                                            <option value="{{ $category->id }}">{{ $category->name }} (Main)</option>
                                            @foreach($category->children as $child)
                                                <option value="{{ $child->id }}">-- {{ $child->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="short_description">Short Description</label>
                            <textarea name="short_description" class="form-control">{{ old('short_description') }}</textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="primary_image">Primary Image</label>
                            <input type="file" name="primary_image" class="form-control-file" accept="image/*" onchange="previewImage(this, 'primary-image-preview')">
                            <div class="mt-2" id="primary-image-preview" style="display: none;">
                                <img src="" style="max-height: 150px; border: 1px solid #ccc; padding: 2px;">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="gallery_images">Gallery Images (Multiple)</label>
                            <input type="file" name="gallery_images[]" class="form-control-file" accept="image/*" multiple onchange="previewGalleryImages(this, 'gallery-images-preview')">
                            <div class="mt-2 d-flex flex-wrap gap-2" id="gallery-images-preview">
                                <!-- Previews will be appended here -->
                            </div>
                        </div>
                    </div>

                    <!-- Product Attributes -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>Product Attributes</h5>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <select id="global-attribute-select" class="form-control">
                                        <option value="">Select an attribute...</option>
                                        @if(isset($global_attributes))
                                            @foreach($global_attributes as $attr)
                                                <option value="{{ $attr->id }}" data-name="{{ $attr->name }}" data-values="{{ json_encode($attr->values) }}">{{ $attr->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-info" id="add-product-attribute">Add</button>
                                </div>
                            </div>
                            <div id="product-attributes-container">
                                <!-- Attributes will be appended here -->
                            </div>
                        </div>
                    </div>

                    <!-- Product Variations -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>Product Variations</h5>
                                <div>
                                    <button type="button" class="btn btn-sm btn-warning" id="generate-variations">Generate Variations</button>
                                    <button type="button" class="btn btn-sm btn-success" id="add-variation">Add Manually</button>
                                </div>
                            </div>
                            <div id="product-variations-container">
                                <!-- Variations will be appended here -->
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Specifications -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>Specification Sections</h5>
                                <button type="button" class="btn btn-sm btn-info" id="add-spec-section">Add Specification Section</button>
                            </div>
                            <div id="spec-sections-container">
                                <!-- Sections will be appended here -->
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('extra_js')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    CKEDITOR.replace('short_description');
    CKEDITOR.replace('description');

    let attrIndex = 0;
    let varIndex = 0;

    // Add Attribute
    document.getElementById('add-product-attribute').addEventListener('click', function() {
        const select = document.getElementById('global-attribute-select');
        const selectedOption = select.options[select.selectedIndex];
        
        if (!selectedOption.value) return;

        const attrId = selectedOption.value;
        const attrName = selectedOption.getAttribute('data-name');
        const attrValues = JSON.parse(selectedOption.getAttribute('data-values'));

        let optionsHtml = '';
        attrValues.forEach(val => {
            optionsHtml += `<option value="${val.id}">${val.name}</option>`;
        });

        const container = document.getElementById('product-attributes-container');
        const html = `
            <div class="card bg-light mb-3 prod-attr-block" data-attr-id="${attrId}" data-attr-name="${attrName}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6>${attrName}</h6>
                            <input type="hidden" name="product_attributes[${attrIndex}][attribute_id]" value="${attrId}">
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input is-variation-checkbox" name="product_attributes[${attrIndex}][is_variation]" value="1" id="var_chk_${attrIndex}">
                                <label class="form-check-label" for="var_chk_${attrIndex}">Used for variations</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label>Select Values</label>
                            <select name="product_attributes[${attrIndex}][values][]" class="form-control attr-values-select" multiple required>
                                ${optionsHtml}
                            </select>
                            <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple</small>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-prod-attr">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        attrIndex++;
        select.value = ''; // Reset
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-prod-attr')) {
            e.target.closest('.prod-attr-block').remove();
        }
        if (e.target.classList.contains('remove-var')) {
            e.target.closest('.variation-block').remove();
        }
    });

    // Generate Variations
    document.getElementById('generate-variations').addEventListener('click', function() {
        const blocks = document.querySelectorAll('.prod-attr-block');
        let attributesForVariations = [];

        blocks.forEach(block => {
            const isVar = block.querySelector('.is-variation-checkbox').checked;
            if (isVar) {
                const attrId = block.getAttribute('data-attr-id');
                const attrName = block.getAttribute('data-attr-name');
                const select = block.querySelector('.attr-values-select');
                const selectedOptions = Array.from(select.selectedOptions);
                
                if (selectedOptions.length > 0) {
                    attributesForVariations.push({
                        id: attrId,
                        name: attrName,
                        values: selectedOptions.map(opt => ({ id: opt.value, name: opt.text }))
                    });
                }
            }
        });

        if (attributesForVariations.length === 0) {
            alert('Please select attributes, add values, and check "Used for variations".');
            return;
        }

        // Cartesian product of arrays
        const cartesian = (...a) => a.reduce((a, b) => a.flatMap(d => b.map(e => [d, e].flat())));
        
        const valueArrays = attributesForVariations.map(a => a.values);
        let combinations = [];
        if (valueArrays.length === 1) {
            combinations = valueArrays[0].map(v => [v]);
        } else {
            combinations = cartesian(...valueArrays);
        }

        const container = document.getElementById('product-variations-container');
        container.innerHTML = ''; // Clear existing
        varIndex = 0;

        const baseSku = document.querySelector('input[name="sku"]').value;

        combinations.forEach(combo => {
            let comboNameParts = [];
            let comboIdsHtml = '';
            
            combo.forEach(val => {
                comboNameParts.push(val.name);
                comboIdsHtml += `<input type="hidden" name="variations[${varIndex}][attributes][]" value="${val.id}">`;
            });

            const comboName = comboNameParts.join(' - ');
            const suggestedSku = baseSku ? baseSku + '-' + comboNameParts.map(p => p.substring(0,3).toUpperCase()).join('-') : '';

            const varHtml = `
                <div class="card border-info mb-2 variation-block">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <strong>${comboName}</strong>
                                ${comboIdsHtml}
                            </div>
                            <div class="col-md-2">
                                <label>SKU (Optional)</label>
                                <input type="text" name="variations[${varIndex}][sku]" class="form-control form-control-sm" placeholder="SKU" value="${suggestedSku}">
                            </div>
                            <div class="col-md-3">
                                <label>Primary Image</label>
                                <input type="file" name="variations[${varIndex}][image]" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'var-img-preview-${varIndex}')">
                                <div class="mt-1" id="var-img-preview-${varIndex}" style="display: none;">
                                    <img src="" style="max-height: 50px; border: 1px solid #ccc; padding: 1px;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Gallery Images</label>
                                <input type="file" name="variations[${varIndex}][gallery_images][]" class="form-control form-control-sm" accept="image/*" multiple onchange="previewGalleryImages(this, 'var-gal-preview-${varIndex}')">
                                <div class="mt-1 d-flex flex-wrap gap-1" id="var-gal-preview-${varIndex}"></div>
                            </div>
                            <div class="col-md-1">
                                <label>Status</label>
                                <select name="variations[${varIndex}][status]" class="form-control form-control-sm">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-sm btn-danger remove-var">X</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', varHtml);
            varIndex++;
        });
    });

    document.getElementById('add-variation').addEventListener('click', function() {
        alert('Manual variation adding is useful for editing, but initially try "Generate Variations" based on attributes!');
    });

    // Specifications
    document.getElementById('add-spec-section').addEventListener('click', function() {
        const container = document.getElementById('spec-sections-container');
        const secHtml = `
            <div class="card bg-light mb-3 spec-section" data-sec-index="${specSectionIndex}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <label>Section Title (e.g., Physical, Electrical)</label>
                            <input type="text" name="spec_sections[${specSectionIndex}][title]" class="form-control" required>
                        </div>
                        <div class="col-md-5">
                            <label>Display Order</label>
                            <input type="number" name="spec_sections[${specSectionIndex}][display_order]" class="form-control" value="0">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-sec">Remove Section</button>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Specifications</h6>
                        <table class="table table-sm table-bordered bg-white">
                            <thead>
                                <tr>
                                    <th>Label (e.g., Voltage)</th>
                                    <th>Value (e.g., 220V)</th>
                                    <th>Order</th>
                                    <th><button type="button" class="btn btn-sm btn-success add-spec-value" data-index="${specSectionIndex}">Add Spec</button></th>
                                </tr>
                            </thead>
                            <tbody class="spec-values-container">
                                <!-- Specs appended here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', secHtml);
        specSectionIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-sec')) {
            e.target.closest('.spec-section').remove();
        }
        if (e.target.classList.contains('add-spec-value')) {
            const sIndex = e.target.getAttribute('data-index');
            const tbody = e.target.closest('.card-body').querySelector('.spec-values-container');
            const vIndex = tbody.children.length;
            const tr = `
                <tr>
                    <td><input type="text" name="spec_sections[${sIndex}][specs][${vIndex}][label]" class="form-control form-control-sm" required></td>
                    <td><input type="text" name="spec_sections[${sIndex}][specs][${vIndex}][value]" class="form-control form-control-sm"></td>
                    <td><input type="number" name="spec_sections[${sIndex}][specs][${vIndex}][display_order]" class="form-control form-control-sm" value="0"></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-spec">X</button></td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', tr);
        }
        if (e.target.classList.contains('remove-spec')) {
            e.target.closest('tr').remove();
        }
});

$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select Categories",
        allowClear: true
    });
});

function previewImage(input, previewId) {
    const previewContainer = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.querySelector('img').src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
        previewContainer.querySelector('img').src = '';
    }
}

function previewGalleryImages(input, previewContainerId) {
    const container = document.getElementById(previewContainerId);
    container.innerHTML = ''; // clear existing previews
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxHeight = '100px';
                img.style.border = '1px solid #ccc';
                img.style.padding = '2px';
                img.style.marginRight = '5px';
                img.style.marginBottom = '5px';
                container.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@stop
