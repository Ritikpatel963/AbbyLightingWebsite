@extends('layout.web',['theme' => 'light'])

@push('css')
@vite(['resources/scss/company.scss'])
@endpush
@section("title", "About Us | Abby Lighting")
@section("description","With three generations of expertise, we've emerged as one of India's top LED lighting players. Explore our Studio, our Machines, and our Quality Commitment.")
@section('page-content')
<div class="container-fluid p-0 mt-5">
    <div class="row">
        <div class="col-12">
            <img src="{{asset('img/about-us/Artboard1.png')}}" alt="" class="img-fluid w-100">
        </div>
    </div>
</div>
<section>
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 col-lg-6 px-3 ps-lg-5 pe-lg-0 align-self-center">
                <div class="p-0 p-md-3 px-lg-0 px-xl-5">
                    <div class="section-title custom-title-color custom-underline">
                        Our History
                    </div>
                    <p class="section-text stupid-text-1">
                        Designing and producing lighting systems has been in our veins for the third generation running. As the lighting industry has evolved, so has Abby - to emerge as one of India’s top manufacturers of LED lighting fixtures. Today, with our 85,000+ sq ft design and manufacturing facility, we provide tailored architectural lighting solutions across sectors.
                    </p>

                </div>
            </div>
            <div class="col-12 col-lg-6 p-0">
                <a href="#" style="position: relative">
                    <img src="{{asset('img/about-us/Artboard2.png')}}" alt="" class="img-fluid">
                </a>
            </div>

        </div>
    </div>
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 col-lg-6 p-0 order-2 order-lg-1">
                <a href="#" style="position: relative">
                    <img src="{{asset('img/about-us/Artboard3.png')}}" alt="" class="img-fluid">
                </a>
            </div>
            <div class="col-12 col-lg-6 px-3 ps-lg-5 pe-lg-0 align-self-center order-1 order-lg-2">
                <div class="p-0 p-md-3 px-lg-0 px-xl-5">
                    <div class="section-title custom-title-color custom-underline">
                        The Abby Studio
                    </div>
                    <p class="section-text stupid-text-1">
                        Established in 2018, Abby Studio is a one-of-a-kind experience centre and office space that doubles up as an event venue after hours. The lighting in the entire Studio is configured wirelessly, to serve as a tangible showcase of how smart lighting can transform spaces.
                    </p>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 col-lg-6 px-3 ps-lg-5 pe-lg-0 align-self-center">
                <div class="p-0 p-md-3 px-lg-0 px-xl-5">
                    <div class="section-title custom-title-color custom-underline">
                        The Design Lab
                    </div>
                    <p class="section-text stupid-text-1">
                        Innovation is the essence of our heritage. We make luminaires that add character and ambience to spaces. Whatever the individual style, we have something for everyone. Being in full control of the manufacturing process end-to-end, we’re able to carry out customised fixtures and promptly respond to changes in designs, wherever required. </p>

                </div>
            </div>
            <div class="col-12 col-lg-6 p-0">
                <a href="#" style="position: relative">
                    <img src="{{asset('img/about-us/Artboard4.png')}}" alt="" class="img-fluid">
                </a>
            </div>

        </div>
    </div>
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 col-lg-6 p-0 order-2 order-lg-1">
                <a href="#" style="position: relative">
                    <img src="{{asset('img/about-us/Artboard5.png')}}" alt="" class="img-fluid">
                </a>
            </div>
            <div class="col-12 col-lg-6 px-3 ps-lg-5 pe-lg-0 align-self-center order-1 order-lg-2">
                <div class="p-0 p-md-3 px-lg-0 px-xl-5">
                    <div class="section-title custom-title-color custom-underline">
                        The Quality
                    </div>
                    <p class="section-text stupid-text-1">
                        Our state-of-the-art facility is equipped with the finest of machines across the entire manufacturing process (SMT Lines, Pressure Die Casting, Laser Cutting, Powder Coating, and various other CNC operations). Supported by our ISO 9001:2015 certification, we uphold uncompromising standards of quality at every step, with a highly skilled workforce to bolster us. </p>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 col-lg-6 px-3 ps-lg-5 pe-lg-0 align-self-center">
                <div class="p-0 p-md-3 px-lg-0 px-xl-5">
                    <div class="section-title custom-title-color custom-underline">
                        Sustainability
                    </div>
                    <p class="section-text stupid-text-1">
                        While we prioritise design and customer satisfaction, we place equal emphasis on sustainability. Recognizing the urgent need to protect our environment, all our machinery is energy-efficient and undergoes regular checks. Our internal operations are continuously monitored and optimised to minimise environmental impact. As pioneers in LED manufacturing, we take pride in converting many customers to LED lighting, thereby reducing the overall carbon footprint. </p>

                </div>
            </div>
            <div class="col-12 col-lg-6 p-0">
                <a href="#" style="position: relative">
                    <img src="{{asset('img/about-us/Artboard6.png')}}" alt="" class="img-fluid">
                </a>
            </div>

        </div>
    </div>

</section>
<div class="container-fluid p-0 mt-5">
    <div class="row">
        <div class="col-12">
            <img src="{{asset('img/about-us/Artboard7.png')}}" alt="" class="img-fluid w-100">
        </div>
    </div>
</div>

<div class="mb-5">&nbsp;</div>

@endsection