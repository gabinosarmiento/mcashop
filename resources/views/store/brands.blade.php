@extends('layouts.site')
@section('title', 'MCAShop - Solo las mejores marcas')
@section('description', 'Descubre las mejores marcas, seleccionadas cuidadosamente, para que siempre encuentres lo mejor a solo un clic de distancia.')
@php($navbar_mobile = 'up.partials.navbar_mobile')
@section('content')
<div class="container">
    {{ Breadcrumbs::render('marcas') }}
    <div class="row row-brands">
        <div class="col-12">
            <nav class="alphabet-nav">
                @foreach($data['alphabet'] as $key => $brands)
                <a href="#letter-{{ $key }}" class="alphabet-letter">
                    {{ $key }}
                </a>
                @endforeach
            </nav>
            <div class="wrapper-bottom">
                @foreach($data['alphabet'] as $key => $brands)
                <div id="letter-{{ $key }}" class="grid grid-brands">
                    @foreach($brands as $brand)
                    <a id="select-brand-{{ $brand['id'] }}" href="{{ route('marca', [$brand['id'], str($brand['name'])->slug()]) }}" class="img-container item-scale" data-id="{{ $brand['id'] }}" data-name="{{ $brand['name'] }}">
                        <img src="{{ asset($brand['image']) }}" class="img-fluid img-loading rounded-4" alt="{{ $brand['name'] }}"/>
                    </a>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    // Add smoth efect when the user pick a brand
    document.addEventListener('DOMContentLoaded', function () {
        const alphabet = document.querySelector('.alphabet-nav');
        const letters = alphabet.querySelectorAll('.alphabet-letter');

        window.addEventListener('scroll', function () {
            if (alphabet.getBoundingClientRect().top > 0) return;
            let active = null;

            letters.forEach(function (letter) {
                const target = document.querySelector(letter.getAttribute('href'));
                if (target) {
                    const sectionTop = target.getBoundingClientRect().top;
                    if (sectionTop <= alphabet.offsetHeight) {
                        active = letter;
                    }
                }
            });

            if (active) {
                letters.forEach(l => l.classList.remove('alphabet-active'));
                active.classList.add('alphabet-active');
            }
        });

        letters.forEach(function (letter) {
            letter.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    let top = window.scrollY + target.getBoundingClientRect().top;
                    top -= alphabet.offsetHeight;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                }
            });
        });
    });
</script>
@endsection
