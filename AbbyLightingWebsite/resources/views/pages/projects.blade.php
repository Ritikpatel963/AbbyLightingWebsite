@extends('layout.web', ['theme' => 'light'])

@section("title", "Projects across industries | Abby Lighting")
@section("description", "Lighting solutions for every project - from high-end Retail and Hospitality to Residences and Office spaces")
@section('page-content')
<div class="px-lg-5 project-page">
    <div class="container-fluid">
        <h1 class="section-title">{{ @$title }}</h1>

        {{-- Sticky dark bar (same as Products) --}}
        <section class="container-fluid py-3 p-0 bg-dark text-white sticky-top pb-0">
            <div id="links-section"
                class="links d-flex flex-nowrap"
                style="overflow-x: auto; -webkit-overflow-scrolling: touch; scroll-padding: 2rem;"
                default-data-filter="{{ $default_data_filter }}">

                        {{-- All --}}
                        <a href="#"
                        id="all-projects-link"
                        class="section-link-filter text-uppercase fw-600 pb-3"
                        style="white-space: nowrap; letter-spacing: 0.1rem; margin: 0 2rem;"
                        data-slug=""
                        data-filter="*">
                            <span class="tag-display">All</span>
                        </a>

                        @php
                            $projectTypes = [
                                'retail' => ['filter' => '.--retail', 'display' => 'Retail'],
                                'office-spaces' => ['filter' => '.--office-spaces', 'display' => 'Office&nbsp;Spaces'],
                                'hospitality' => ['filter' => '.--hospitality', 'display' => 'Hospitality'],
                                'residential' => ['filter' => '.--residential', 'display' => 'Residential'],
                                'education' => ['filter' => '.--education', 'display' => 'Education'],
                                'public-spaces' => ['filter' => '.--public-spaces', 'display' => 'Public&nbsp;Spaces'],
                            ];
                        @endphp
                        @foreach($projectTypes as $slug => $data)
                            @php
                                $hasProjects = false;
                                if(isset($projects)) {
                                    foreach($projects as $p) {
                                        if(isset($p->typeSlug) && (trim($p->typeSlug) == trim(str_replace('.', '', $data['filter'])) || trim($p->typeSlug) == trim($slug))) {
                                            $hasProjects = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            @if($hasProjects)
                            <span class="divider text-5b5b5b" style="font-size:1.3rem">|</span>
                            <a href="#"
                            class="section-link-filter text-uppercase fw-600 pb-3"
                            style="white-space: nowrap; letter-spacing: 0.1rem; margin: 0 2rem;"
                            data-slug="{{ $slug }}"
                            data-filter="{{ $data['filter'] }}">
                                <span class="tag-display">{!! $data['display'] !!}</span>
                            </a>
                            @endif
                        @endforeach            
                           
                </div>
            </section> 

            {{-- Styling identical to Products --}}
            <style>
                .tag-display {
                    color: #fff;
                    transition: color 0.3s;
                    display: inline-block;
                }
                .section-link-filter { text-decoration: none !important; border: none !important; }
                .section-link-filter:hover { text-decoration: none !important; }
                .section-link-filter.active .tag-display { color: #EBC824 !important; }

                /* Responsive behavior */
                @media (min-width: 992px) { /* lg and up */
                    #links-section {
                        justify-content: center;  /* Center on desktop */
                        overflow-x: visible;      /* Disable scroll on desktop */
                    }
                }

                @media (max-width: 991.98px) { /* below lg */
                    #links-section {
                        justify-content: flex-start; /* Left-align so scroll works */
                        padding-left: 1rem;          /* small breathing room for ALL */
                        padding-right: 1rem;
                    }
                }
            </style>


        <div class="row mt-5" id="project-tiles">
            <div class="masonry-sizer col-4"></div>
            @php $currentIndex = 0; @endphp
            @foreach($projects as $index => $project)

            @php $currentIndex = $currentIndex + 1; @endphp
            {{-- @if($currentIndex == 1) --}}
            <div class="masonry-item col-12 col-xl-{{ $project->block_column*4 }} mt-4 {{$project->typeSlug}}">
                <a href="{{route('project-detail', $project->slug)}}">
                    <img src="{{ @$project->projectImages[0] ? asset('storage/uploads/projects/'.@$project->projectImages[0]->image) : asset('images/default.png') }}"
                        class="img-fluid w-100 mt-3 mb-3">
                </a>
                <a href="{{route('project-detail', $project->slug)}}"
                    class="project-title text-decoration-none fw-500 pt-1">
                    {{$project->name}} - {{$project->location}}
                </a>
                <div class="project-subtitle fw-500">{{$project->type}}</div>
            </div>
           {{--  @endif --}}
           
            @endforeach
        </div>
        <div class="row mt-5"> </div>
        <div class="row mt-5"> </div>
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