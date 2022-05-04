<form action="{{ route('shop.index', app()->getLocale()) }}" class="form-group">
    <div class="input-group">
        {{-- <button class="input-group-text categories">Categories<i data-feather="chevron-down"></i></button> --}}
        {{-- {{ dd($_GET) }} --}}
        @php
        $selected = '';
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $selected = $_GET['category'];
        }
        $keyword = '';
        if (isset($_GET['s']) && !empty($_GET['s'])) {
            $keyword = $_GET['s'];
        }
        @endphp
        <select name="category" id="top_cat_dd" class="input-group-text categories tz-info">
            <option value="">Categories</option>
            {{ getCategoryTreeOption($selected) }}
        </select>
        <input name="s" type="text" value="{{ $keyword }}" class="form-control" aria-label="Search products">
        <button type="submit" class="input-group-text"><i data-feather="search"></i></button>
    </div>
</form>