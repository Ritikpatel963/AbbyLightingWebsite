@extends('layout.web', ['theme' => 'light'])
@section("title", "Our Clients | Abby Lighting")
@section("description", "Our clients include the top names across industries - 5000+ and counting")
@section('page-content')
<div class="project-category">
    <div class="container-fluid p-0">
        @if(App\Models\Setting::getValue('CLIENT_BANNER_IMAGE', false))
        <img src="{{App\Models\Setting::getValue('CLIENT_BANNER_IMAGE')}}" alt="" class="img-fluid">
        @else
        <img src="{{ asset('storage/uploads/banners/banner_image-clients.jpg') }}" alt="" class="img-fluid">
        @endif
    </div>

    <section>
        <div class="container-fluid stupid-padding no-mobile-padding mt-0 mt-md-5">
            <h1 class="section-title pt-4 pb-0 pb-md-4 mb-0">
                Our Clients
            </h1>
            <div class="section-text">
                We've designed beautiful spaces for countless happy clients. Each project that we undertake has a story
                to tell. However big or small a customer might be, we invest time with each of them to understand their
                needs.
            </div>
            <div class="section-text">
                Our forte is attention to details and customization. Honesty in our work, client satisfaction and
                sustainability are the driving forces, along with the ability to constantly explore and evolve.
            </div>

            <div class="mb-5">&nbsp;</div>
        </div>
        <div class="container-fluid stupid-padding no-mobile-padding mt-5 bg-white">
            <div class="row py-5">
                @foreach ($clients as $client)
                <div class="col-6 col-md-3 col-lg-2 text-center">
                    <img src="/storage/uploads/clients/{{$client->path}}" class="img-fluid" alt="">
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection
