@extends('layout.web',['theme' => 'light'])
@push('css')
@vite(['resources/scss/careers.scss'])
@endpush


@section('page-content')

<section class="main-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-6 p-0">
                @if(App\Models\Setting::getValue('CAREER_BANNER_IMAGE', false))
                    <img src="{{App\Models\Setting::getValue('CAREER_BANNER_IMAGE')}}" alt="" class="img-fluid">
                @else
                    <img src="{{asset('storage/uploads/banners/banner_image-career.jpg')}}" alt="" class="img-fluid">
                @endif
            </div>
            <div class="col-12 col-lg-6 md-5 p-3 p-md-5">
                <div class="p-0 p-xl-5">
                    <h3 class="career-section-title pt-5">Work with us</h3>
                    <p class="section-career-text">
                        If you love light, Become one of us!
                    </p>
                    <p class="section-career-text">
                        Illumination is a passion that is shared by all of us who work at Abby Lighting, dedication that is much more than just a way of earning a living. We are always on the lookout for people who will help us to expand this philosophy, professionals who want to develop their career in the lighting sector, driven by an urge to succeed.
                    </p>
                    <p class="section-career-text">Send in your resumes to <span
                            class="career-email bolder"><a href="mailto:careers@abbylighting.com" class="career-email bolder" target="_blank" style="text-decoration:none">careers@abbylighting.com</a></span></p>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mt-5">
    <h4 class="career-job-title">JOB OPENINGS</h4>
    <div class="row mb-5">
        @forelse ($openings as $opening)
        <div class="col-12 col-lg-6">
            <div class="section-grayed p-3 me-3">
                <h4 class="career-head-title">{{ $opening->title }} </h4>
                <p class="career-head-location">
                    Job Location: {{ $opening->location }}<br>
                    {{ $opening->short_description }}
                </p>
                <div class="col-12 my-5">
                    <a href="#" class="section-detail-text more-details" data-bs-toggle="modal" data-bs-target="#jobDescriptionModal">More Details</a>
                    <i aria-hidden="true" class="fas fa-angle-right"></i>
                </div>
                <div class="d-none long-description">
                    {!!$opening->description!!}
                </div>
            </div>
        </div>
        @empty
            <p class="section-text text-center">
                Sorry, currently no openings are available.
            </p>
        @endforelse
    </div>
</div>
@include('partials.job-description')

@push('js')
    <script>
        document.querySelectorAll(".more-details").forEach(function(element) {
            element.addEventListener('click', function() {
                let desc = this.parentElement.parentElement.querySelector(".long-description").innerHTML;
                document.querySelector("#jobDescriptionModal").querySelector(".modal-body").innerHTML = desc;
            });
        });
    </script>
@endpush


@endsection