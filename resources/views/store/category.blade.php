@extends('layouts.site')
@section('title', "MCAShop - {$data['name']}")
@section('description', "En esta sección encontrarás solo lo mejor en productos {$data['name']}")
@section('mobile')
<x-store.mobilebar :data="$data" source="categoria"/>
@endsection
@section('content')
<x-products :data="$data" source="categoria"/>
@endsection
