@extends('layout.web',['theme' => 'light'])

@section('page-content')
<div class="px-lg-5 project-page">
    <div class="container-fluid">
        <h1 class="section-title">{{@$title}}</h1>
        <div class="row">
            @foreach($events as $event)
            <div class="col-12 col-lg-6  mt-4">
                <a href="{{route('event.detail', $event->slug)}}">
                    <img src="{{ @$event->eventImages[0] ? asset('storage/uploads/events/'.@$event->eventImages[0]->image) : asset('images/default.png') }}"
                        class="img-fluid w-100 mt-5">
                </a>
                <div class="project-subtitle text-uppercase fw-500 pt-4">{{$event->location}}</div>
                <a href="{{route('event.detail', $event->slug)}}" class="project-title text-decoration-none fw-500 mb-5">
                    {{$event->name}}
                </a>
            </div>
            @endforeach
            {{-- <div class="col-12 col-lg-5  mt-4">
                <a href="#">
                    <img src="{{asset('img/fairs-events/fairs-events-image2.jpg')}}" class="img-fluid w-100 mt-5">
                </a>
                <div class="project-subtitle text-uppercase fw-500 pt-4">Madrid, spain</div>
                <a href="#" class="project-title text-decoration-none fw-500 mb-5">
                    Matelec Fair - 2018
                </a>
            </div> --}}

        </div>

        <div class="row mt-5"></div>
        <div class="row mt-5"></div>
    </div>
</div>

@endsection

@push('css')
@vite(['resources/scss/projects.scss'])
@endpush

@push('js')
@vite(['resources/js/app.js'])
@vite(['resources/js/projects.js'])
@endpush