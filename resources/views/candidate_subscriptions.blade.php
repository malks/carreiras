@extends('layouts/public')

@section('content')
    <input type="hidden" value="{{ json_encode($subscriptions) }}" id='subscriptions-data'>
    <div class='row margin-top-30'>
        <div class="col-12 margin-bottom-30" id='app' candidate-subscriptions>

            <div class="card">
                
                <div class='card-header'>
                    <h3>Minhas Inscrições</h3>
                </div>

                <div class="card-body">
                    <template v-for='subscription in subscriptions'>
                        @{ subscription }
                    </template>
                </div>

            </div>
        </div>
    </div>
@stop
