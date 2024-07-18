<!-- Clear tags -->
<div class="p-5 text-right">
    @if(request()->has('tag'))
    <a href="{{ url()->current() }}{{ request('search') ? '?search='.request('search') : '' }}"
       class="bg-red-500 text-white rounded-xl px-3 py-1 ml-2">
        Clear Tags
    </a>
    @endif
</div>

