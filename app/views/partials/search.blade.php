<div class="search-band">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="textcenter">
                    {{ Config::get('site.welcome_message') }}
                </div>
            </div>
        </div>

        <br/>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                @include('partials.searchForm', ['formClass' => 'form-horizontal'])
            </div>
        </div>
    </div>
</div>