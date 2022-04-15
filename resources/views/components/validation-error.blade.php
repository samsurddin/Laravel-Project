@if (count($errors) > 0)
<div class="errors mt-1 text-sm">
    @foreach ($errors->all() as $error)
        <p class="bg-red-100 text-red-600 p-2 px-3 rounded-md shadow-lg my-2">{{ $error }}</p>
    @endforeach
</div>
@endif