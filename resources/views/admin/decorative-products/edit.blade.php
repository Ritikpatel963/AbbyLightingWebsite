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
                <form action="{{ route('decorative_product_admin.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title">Title *</label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title', $product->title) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="sku">SKU *</label>
                            <input type="text" name="sku" class="form-control" required value="{{ old('sku', $product->sku) }}">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="categories">Categories</label>
                            @php
                                $selected_cats = $product->categories->pluck('id')->toArray();
                            @endphp
                            <select name="categories[]" class="form-control select2" multiple="multiple" data-placeholder="Select Categories">
                                @foreach($categories as $category)
                                    @if($category->parent_id == null)
                                        <optgroup label="{{ $category->name }}">
                                            <option value="{{ $category->id }}" {{ in_array($category->id, $selected_cats) ? 'selected' : '' }}>{{ $category->name }} (Main)</option>
                                            @foreach($category->children as $child)
                                                <option value="{{ $child->id }}" {{ in_array($child->id, $selected_cats) ? 'selected' : '' }}>-- {{ $child->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="short_description">Short Description</label>
                            <textarea name="short_description" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $product->sort_order) }}">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="primary_image">Primary Image</label>
                            <input type="file" name="primary_image" class="form-control-file" accept="image/*" onchange="previewImage(this, 'primary-image-preview')">
                            <div class="mt-2" id="primary-image-preview" style="{{ $product->primaryImage ? 'display: block;' : 'display: none;' }}">
                                <img src="{{ $product->primaryImage ? asset('uploads/decorative_products/' . $product->primaryImage->image) : '' }}" style="max-height: 150px; border: 1px solid #ccc; padding: 2px;">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="gallery_images">Gallery Images (Multiple)</label>
                            <input type="file" name="gallery_images[]" class="form-control-file" accept="image/*" multiple onchange="previewGalleryImages(this, 'gallery-images-preview')">
                            <div class="mt-2 d-flex flex-wrap gap-2" id="gallery-images-preview">
                                <!-- New previews will be appended here -->
                            </div>
                            @if($product->galleryImages && $product->galleryImages->count() > 0)
                                <div class="mt-2 d-flex flex-wrap gap-2">
                                    <label class="w-100">Existing Gallery Images:</label>
                                    @foreach($product->galleryImages as $galImg)
                                        <div style="position: relative; display: inline-block;">
                                            <img src="{{ asset('uploads/decorative_products/' . $galImg->image) }}" style="max-height: 100px; border: 1px solid #ccc; padding: 2px; margin-right: 5px; margin-bottom: 5px;">
                                            <!-- Optional: Add a small delete button here later if needed -->
                                        </div>
                                    @endforeach
                                </div>
                            @endif
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
                                @foreach($product->attributes as $aIndex => $prodAttr)
                                <div class="card bg-light mb-3 prod-attr-block" data-attr-id="{{ $prodAttr->decorative_attribute_id }}" data-attr-name="{{ $prodAttr->attribute->name ?? '' }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h6>{{ $prodAttr->attribute->name ?? '' }}</h6>
                                                <input type="hidden" name="product_attributes[{{ $aIndex }}][attribute_id]" value="{{ $prodAttr->decorative_attribute_id }}">
                                                <div class="form-check mt-2">
                                                    <input type="checkbox" class="form-check-input is-variation-checkbox" name="product_attributes[{{ $aIndex }}][is_variation]" value="1" id="var_chk_{{ $aIndex }}" {{ $prodAttr->is_variation ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="var_chk_{{ $aIndex }}">Used for variations</label>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <label>Select Values</label>
                                                <select name="product_attributes[{{ $aIndex }}][values][]" class="form-control attr-values-select" multiple required>
                                                    @if($prodAttr->attribute && $prodAttr->attribute->values)
                                                        @foreach($prodAttr->attribute->values as $val)
                                                            <option value="{{ $val->id }}" {{ $prodAttr->values->contains('decorative_attribute_value_id', $val->id) ? 'selected' : '' }}>{{ $val->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple</small>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-prod-attr">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
                                @foreach($product->variations as $vIndex => $variation)
                                <div class="card border-info mb-2 variation-block">
                                    <div class="card-body p-2">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <strong>
                                                    @php
                                                        $varNameParts = [];
                                                        foreach($variation->attributeValues as $varAttrVal) {
                                                            $varNameParts[] = $varAttrVal->name;
                                                        }
                                                        echo implode(' - ', $varNameParts);
                                                    @endphp
                                                </strong>
                                                <input type="hidden" name="variations[{{ $vIndex }}][existing_id]" value="{{ $variation->id }}">
                                                @foreach($variation->attributeValues as $varAttrVal)
                                                    <input type="hidden" name="variations[{{ $vIndex }}][attributes][]" value="{{ $varAttrVal->id }}">
                                                @endforeach
                                            </div>
                                            <div class="col-md-2">
                                                <label>SKU (Optional)</label>
                                                <input type="text" name="variations[{{ $vIndex }}][sku]" class="form-control form-control-sm" placeholder="SKU" value="{{ $variation->sku }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Primary Image</label>
                                                <input type="file" name="variations[{{ $vIndex }}][image]" class="form-control-file form-control-sm" accept="image/*" onchange="previewImage(this, 'var-img-preview-exist-{{ $vIndex }}')">
                                                <div class="mt-1" id="var-img-preview-exist-{{ $vIndex }}" style="{{ $variation->image ? 'display: block;' : 'display: none;' }}">
                                                    <img src="{{ $variation->image ? asset('uploads/decorative_products/'.$variation->image) : '' }}" style="max-height: 50px; border: 1px solid #ccc; padding: 1px;">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Gallery Images</label>
                                                <input type="file" name="variations[{{ $vIndex }}][gallery_images][]" class="form-control form-control-sm" accept="image/*" multiple onchange="previewGalleryImages(this, 'var-gal-preview-exist-{{ $vIndex }}')">
                                                <div class="mt-1 d-flex flex-wrap gap-1" id="var-gal-preview-exist-{{ $vIndex }}"></div>
                                                @if($variation->galleryImages && $variation->galleryImages->count() > 0)
                                                    <div class="mt-1 d-flex flex-wrap gap-1">
                                                        @foreach($variation->galleryImages as $galImg)
                                                            <div style="position: relative; display: inline-block;">
                                                                <img src="{{ asset('uploads/decorative_products/' . $galImg->image) }}" style="max-height: 40px; border: 1px solid #ccc; padding: 1px; margin-right: 2px; margin-bottom: 2px;">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-1">
                                                <label>Status</label>
                                                <select name="variations[{{ $vIndex }}][status]" class="form-control form-control-sm">
                                                    <option value="active" {{ $variation->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ $variation->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                             <div class="col-md-1 text-right">
                                                <button type="button" class="btn btn-sm btn-danger remove-var">X</button>
                                            </div>
                                        </div>
                                        <!-- Specification Sections for this variation -->
                                        <div class="mt-3 border-top pt-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Specification Sections</h6>
                                                <button type="button" class="btn btn-xs btn-info add-var-spec-section" data-var-index="{{ $vIndex }}">+ Add Section</button>
                                            </div>
                                            <div class="var-spec-sections-container" id="var-spec-container-{{ $vIndex }}">
                                                @foreach($variation->specificationSections as $sIndex => $section)
                                                <div class="card bg-light mb-2 var-spec-section" data-sec-index="{{ $sIndex }}">
                                                    <div class="card-body p-2">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <label>Section Title</label>
                                                                <input type="text" name="variations[{{ $vIndex }}][spec_sections][{{ $sIndex }}][title]" class="form-control form-control-sm" required value="{{ $section->title }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Display Order</label>
                                                                <input type="number" name="variations[{{ $vIndex }}][spec_sections][{{ $sIndex }}][display_order]" class="form-control form-control-sm" value="{{ $section->display_order }}">
                                                            </div>
                                                            <div class="col-md-3 d-flex align-items-end">
                                                                <button type="button" class="btn btn-danger btn-sm remove-var-sec w-100">Remove Section</button>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <table class="table table-sm table-bordered bg-white mb-1">
                                                                <thead><tr>
                                                                    <th>Label</th><th>Value</th><th>Order</th>
                                                                    <th><button type="button" class="btn btn-xs btn-success add-var-spec-row" data-var-index="{{ $vIndex }}" data-sec-index="{{ $sIndex }}">+ Row</button></th>
                                                                </tr></thead>
                                                                <tbody class="var-spec-rows-container" id="var-spec-rows-{{ $vIndex }}-{{ $sIndex }}">
                                                                    @foreach($section->specifications as $spIdx => $spec)
                                                                    <tr>
                                                                        <td><input type="text" name="variations[{{ $vIndex }}][spec_sections][{{ $sIndex }}][specs][{{ $spIdx }}][label]" class="form-control form-control-sm" required value="{{ $spec->label }}"></td>
                                                                        <td><input type="text" name="variations[{{ $vIndex }}][spec_sections][{{ $sIndex }}][specs][{{ $spIdx }}][value]" class="form-control form-control-sm" value="{{ $spec->value }}"></td>
                                                                        <td><input type="number" name="variations[{{ $vIndex }}][spec_sections][{{ $sIndex }}][specs][{{ $spIdx }}][display_order]" class="form-control form-control-sm" value="{{ $spec->display_order }}"></td>
                                                                        <td><button type="button" class="btn btn-sm btn-danger remove-var-spec-row">X</button></td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('extra_css')
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-search__field {
        width: 100% !important;
    }
</style>
@stop

@section('extra_js')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    CKEDITOR.replace('short_description');
    CKEDITOR.replace('description');

    let attrIndex = {{ $product->attributes->count() }};
    let varIndex = {{ $product->variations->count() }};

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

        // Optional confirmation dialog removed since it's now smart enough to upgrade old blocks smoothly

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
        const baseSku = document.querySelector('input[name="sku"]').value;

        const existingBlocks = Array.from(document.querySelectorAll('.variation-block'));
        const existingVars = existingBlocks.map(block => {
            const attrInputs = Array.from(block.querySelectorAll('input[name*="[attributes][]"]'));
            const ids = attrInputs.map(inp => inp.value).sort();
            return {
                block: block,
                ids: ids,
                used: false
            };
        });

        combinations.forEach(combo => {
            let comboNameParts = [];
            
            combo.forEach(val => {
                comboNameParts.push(val.name);
            });

            const comboName = comboNameParts.join(' - ');
            const suggestedSku = baseSku ? baseSku + '-' + comboNameParts.map(p => p.substring(0,3).toUpperCase()).join('-') : '';
            const comboIds = combo.map(v => String(v.id)).sort();

            // 1. Check for exact match
            const exactMatch = existingVars.find(ev => ev.ids.join(',') === comboIds.join(','));
            if (exactMatch) {
                exactMatch.used = true;
                return; // Already exists, do nothing
            }

            // 2. Check for subset match (an old variation that can be upgraded)
            const subsetMatch = existingVars.find(ev => !ev.used && ev.ids.length > 0 && ev.ids.every(id => comboIds.includes(id)));
            if (subsetMatch) {
                subsetMatch.used = true;
                // Update title
                const titleEl = subsetMatch.block.querySelector('strong');
                if (titleEl) titleEl.textContent = comboName;
                
                // Add missing attribute hidden inputs
                const attrContainer = titleEl.parentNode;
                const match = subsetMatch.block.innerHTML.match(/variations\[(\d+)\]/);
                const bVarIndex = match ? match[1] : varIndex; 

                combo.forEach(val => {
                    if (!subsetMatch.ids.includes(String(val.id))) {
                        attrContainer.insertAdjacentHTML('beforeend', `<input type="hidden" name="variations[${bVarIndex}][attributes][]" value="${val.id}">`);
                    }
                });

                // Update suggested SKU if empty
                const skuInput = subsetMatch.block.querySelector('input[placeholder="SKU"]');
                if (skuInput && skuInput.value === '') {
                    skuInput.value = suggestedSku;
                }
                return; // Upgraded existing, so don't append a new one
            }

            // 3. No match, create a brand new block
            let comboIdsHtml = '';
            combo.forEach(val => {
                comboIdsHtml += `<input type="hidden" name="variations[${varIndex}][attributes][]" value="${val.id}">`;
            });

            const varHtml = `
                <div class="card border-info mb-2 variation-block" data-var-index="${varIndex}">
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
                            <div class="col-md-1 text-right">
                                <button type="button" class="btn btn-sm btn-danger remove-var">X</button>
                            </div>
                        </div>
                        <!-- Specification Sections for this variation -->
                        <div class="mt-3 border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Specification Sections</h6>
                                <button type="button" class="btn btn-xs btn-info add-var-spec-section" data-var-index="${varIndex}">+ Add Section</button>
                            </div>
                            <div class="var-spec-sections-container" id="var-spec-container-${varIndex}"></div>
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

    // Variation-level Specification Sections
    function buildSpecSectionHtml(varIdx, secIdx) {
        return `
            <div class="card bg-light mb-2 var-spec-section" data-sec-index="${secIdx}">
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-5">
                            <label>Section Title</label>
                            <input type="text" name="variations[${varIdx}][spec_sections][${secIdx}][title]" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-4">
                            <label>Display Order</label>
                            <input type="number" name="variations[${varIdx}][spec_sections][${secIdx}][display_order]" class="form-control form-control-sm" value="0">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-var-sec w-100">Remove Section</button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <table class="table table-sm table-bordered bg-white mb-1">
                            <thead><tr>
                                <th>Label</th><th>Value</th><th>Order</th>
                                <th><button type="button" class="btn btn-xs btn-success add-var-spec-row" data-var-index="${varIdx}" data-sec-index="${secIdx}">+ Row</button></th>
                            </tr></thead>
                            <tbody class="var-spec-rows-container" id="var-spec-rows-${varIdx}-${secIdx}"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
    }

    function buildSpecRowHtml(varIdx, secIdx, rowIdx) {
        return `
            <tr>
                <td><input type="text" name="variations[${varIdx}][spec_sections][${secIdx}][specs][${rowIdx}][label]" class="form-control form-control-sm" required></td>
                <td><input type="text" name="variations[${varIdx}][spec_sections][${secIdx}][specs][${rowIdx}][value]" class="form-control form-control-sm"></td>
                <td><input type="number" name="variations[${varIdx}][spec_sections][${secIdx}][specs][${rowIdx}][display_order]" class="form-control form-control-sm" value="0"></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-var-spec-row">X</button></td>
            </tr>
        `;
    }

    const varSpecIndexes = {};

    $(document).on('click', '.add-var-spec-section', function() {
        const varIdx = $(this).data('var-index');
        if (varSpecIndexes[varIdx] === undefined) {
            // Seed from existing rendered sections so indexes don't collide
            const container = document.getElementById('var-spec-container-' + varIdx);
            varSpecIndexes[varIdx] = container ? container.children.length : 0;
        }
        const secIdx = varSpecIndexes[varIdx];
        const container = document.getElementById('var-spec-container-' + varIdx);
        container.insertAdjacentHTML('beforeend', buildSpecSectionHtml(varIdx, secIdx));
        varSpecIndexes[varIdx]++;
    });

    $(document).on('click', '.remove-var-sec', function() {
        $(this).closest('.var-spec-section').remove();
    });

    $(document).on('click', '.add-var-spec-row', function() {
        const varIdx = $(this).data('var-index');
        const secIdx = $(this).data('sec-index');
        const tbody = document.getElementById('var-spec-rows-' + varIdx + '-' + secIdx);
        const rowIdx = tbody.children.length;
        tbody.insertAdjacentHTML('beforeend', buildSpecRowHtml(varIdx, secIdx, rowIdx));
    });

    $(document).on('click', '.remove-var-spec-row', function() {
        $(this).closest('tr').remove();
    });

    // Select2
    $('.select2').select2({
        placeholder: "Select Categories",
        allowClear: true,
        width: '100%'
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
        // We do not clear the image if they cancel selection, it keeps the old preview
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
