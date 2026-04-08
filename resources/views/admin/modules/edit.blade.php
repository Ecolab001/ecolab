@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Modifier le module</h1>

    <form action="{{ route('modules.update', $module->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Nom</label>
            <input type="text" name="name" value="{{ $module->name }}" class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Événement</label>
            <select name="event_id" class="border p-2 w-full">
                @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ $module->event_id == $event->id ? 'selected' : '' }}>
                        {{ $event->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Centre</label>
            <select name="center_id" class="border p-2 w-full">
                @foreach($centers as $center)
                    <option value="{{ $center->id }}" {{ $module->center_id == $center->id ? 'selected' : '' }}>
                        {{ $center->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Capacité</label>
            <input type="number" name="capacity" value="{{ $module->capacity }}" class="border p-2 w-full">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
            Mettre à jour
        </button>
    </form>
</div>
@endsection