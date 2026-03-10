@extends('layouts.welcome')

@section('title', __('welcome.System rules'))

@section('content')
    <section id="faq">
        <h1 class="section-title">{{ __('welcome.Rules for participating in tournaments') }}</h1>
        <div class="section-subtitle">
            {{ __('welcome.Rules for participating in tournaments and answers to all questions about the platform') }}
        </div>

        <div class="faq-container">
            <div class="faq-card">
                @foreach($faqs as $faq)
                    <h3 class="faq-question">
                        {{ $faq->order }}. {!! $faq->question !!}
                    </h3>
                    <div class="faq-answer" style="text-align: justify">
                        {!! $faq->answer !!}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
