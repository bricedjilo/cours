<section class="property-area section-gap relative" id="hot-deals">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 header-text">
                <h1>Hot Deals in Various Cities</h1>
                <p>
                    We bring you new and hot deals.
                </p>
            </div>
        </div>
        
        <div class="row">
            @foreach ($classes as $class)
            
                @include('class')

            @endforeach
        </div>
    </div>
</section>