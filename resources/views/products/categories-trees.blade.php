@php
$cls = '';
if (isset($is_child) && $is_child) {
	$cls = 'is_child';
}
@endphp

<ul class="cat-tree {{ $cls }}">
	@foreach ($category_tree as $all_cat)
		<li><a href="{{ route('categories.show', [app()->getLocale(), $all_cat['slug']]) }}">{{ $all_cat['name'] }}</a>
			@if (!empty($all_cat['child']))
				@include('products.categories-trees', ['category_tree' => $all_cat['child'], 'is_child'=> true])
			@endif
		</li>
	@endforeach
</ul>