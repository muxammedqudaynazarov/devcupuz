@extends('layouts.welcome')

@section('title', "Tizim qoidalari")

@section('content')
    <section id="faq">
        <h1 class="section-title">Turnirlarda ishtirok etish qoidalari</h1>
        <div class="section-subtitle">Turnirlarda ishtirok etish qoidalari va platforma haqida barcha savollarga javoblar</div>

        <div class="faq-container">
            <div class="faq-card">
                @foreach($faqs as $faq)
                    <h3 class="faq-question">
                        {{ $faq->order }}. {!! $faq->question !!}
                    </h3>
                    <div class="faq-answer">
                        {!! $faq->answer !!}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
