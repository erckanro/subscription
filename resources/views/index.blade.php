@extends('layouts.master')
@section('content')
<div class="flex-center position-ref full-height">

    <div class="content" id="content">
        @if(session()->has('success_message'))
                <div class="message">
                    <img class="tick" src="{{url('/tick.png')}}" alt="Tick"/>
                    <br>
                    <p class="success-message"> {{ session()->get('success_message') }} <p><br>
                    <p class="success-message"> Please see your email for next steps. </p>
                    <p class="success-message"> At anytime, you can contact us at xxxx@xxxx.com </p>
                </div>
            @endif
        <div class="left">
        </div>
        <div class="right title">
            <form action="{{ route('subscribe') }}" method="post" id="payment-form">
                {{ csrf_field() }}
                <div class="formDesc">
                    @if(count($errors) > 0)
                        <div class="messagef">
                            @foreach ($errors->all() as $error)
                                <strong> Payment failed! </strong>
                                <small><li> {{ $error }} </li></small>
                            @endforeach
                        </div>
                    @else
                    <strong> Growth Plan </strong><br>
                    <small> 99usd/month - cancel anytime</small>
                    @endif
                </div>
              <div class="form-row">
                <div class="inp">
                    <input type="text" name="name" placeholder="Name" id="name" required>
                    <input type="email" name="email" placeholder="Email Address" id="email" required>
                </div>
            
                <div id="card-element">
                  <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
              </div>

              <button id="submitBtn">Subscribe</button>
            </form>
        </div>
    </div>
</div>
@endsection