@extends('layouts.app')
@section('content')
<livewire:reports.reportings :team="$team" :user="Auth::user()" :request="request()" />
@endsection
