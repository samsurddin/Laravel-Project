{{-- <link rel="stylesheet" type="text/css" href="http://localhost:8000/admin/assets/css/vendors/bootstrap.css">
<link rel="stylesheet" type="text/css" href="http://localhost:8000/admin/assets/css/style.css"> --}}
<div class="row g-2" id="img-list">
    {{-- @php
        dd($images)
    @endphp --}}
    @if (count($images) > 0)
        @foreach ($images as $img)
        <div class="col-md-3 mb-3 img">
            <div class="img-box p-3" id="img-{{ $img['id'] }}">
                @php
                $img_src = $img['url'];
                if ($img['extension'] == 'pdf') {
                    $img_src = '/admin/assets/images/adobe-pdf-file-icon.svg';
                }
                @endphp
                <img src="{{ $img_src }}" alt="{{ empty($img['alt'])?$img['name']:$img['alt'] }}" data-bs-toggle="modal" data-bs-target="#image_details">
                <div class="img-info d-none">
                    <p class="form-action-link">{{ route('images.update', [app()->getLocale(), $img['id']]) }}</p>
                    <p class="img-del-link">{{ route('images.destroy', [app()->getLocale(), $img['id']]) }}</p>
                    <p class="name">{{ $img['name'] }}</p>
                    <p class="caption">{{ $img['caption'] }}</p>
                    <p class="description">{{ $img['description'] }}</p>
                </div>
                <div class="img-select" title="Select">
                    <label class="btn btn-primary btn-sm"><input type="checkbox" value="{{ $img['id'] }}"></label>
                </div>
            </div>
        </div>
        @endforeach
        <div class="paginage mt-4">
            {{ $images->links() }}
        </div>
    @else
        <div class="col-md-12 text-muted">
            File not found, please <a href="{{ route('images.create', app()->getLocale()) }}">upload now</a>!
        </div>
    @endif
</div>