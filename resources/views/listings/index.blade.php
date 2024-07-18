@extends('layout')

@section('content')
@include('partials._hero')
@include('partials._search')
@include('partials._clear-tags')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">


    @if($listings->isEmpty())
    <p class="p-1 text-gray-400">No listings found.</p>
    @else
        @foreach($listings as $listing)
            <x-listing-card :listing="$listing">
            </x-listing-card>
        @endforeach
    @endif

    <div class="mt-6 p-4">
        {{$listings->links()}}
    </div>

@endsection

