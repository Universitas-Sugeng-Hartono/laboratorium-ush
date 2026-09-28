@php
    $defaultPerPage = $default ?? 25;
    $currentPerPage = (int) request('per_page', $defaultPerPage);
    $options = $options ?? [10, 25, 50, 100];
@endphp
<div class="d-inline-flex align-items-center gap-1 ms-sm-2 my-1">
    <label class="text-muted font-12 mb-0 fw-semibold text-nowrap"><i class="fas fa-list-ol me-1 text-muted"></i> Tampilkan:</label>
    <select class="form-select form-select-sm" 
            style="width: auto; font-size: 12px; border-radius: 7px; padding: 4px 26px 4px 10px; border: 1px solid #cbd5e1; background-color: #ffffff; color: #334155; font-weight: 500; cursor: pointer;" 
            onchange="updatePerPage(this.value)">
        @foreach($options as $opt)
            <option value="{{ $opt }}" {{ $currentPerPage == $opt ? 'selected' : '' }}>{{ $opt }} baris</option>
        @endforeach
    </select>
</div>
