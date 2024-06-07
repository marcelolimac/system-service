@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('plugins.DateRangePicker', true)
@section('plugins.BsCustomFileInput', true)
@section('plugins.BootstrapSelect', true)

@section('content_header')
    <div style="
        display: flex;
        align-items: center;
        justify-content: space-between;
    ">
        <h1 class="m-0 text-dark">{{ $uniform->name }}</h1>
        <div>
            <x-adminlte-button data-toggle="modal" data-target="#modalAddSize" label="Adicionar tamanho" theme="primary" />
        </div>
    </div>
@stop

@section('content')
{{-- Setup data for datatables --}}
@php
$heads = [
    ['label' => 'ID', 'width' => 20],
    ['label' => 'Tamanho', 'width' => 20],
    ['label' => 'Quantidade', 'width' => 40],
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => [],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];

foreach ($uniform->sizes as $size) {
    $btnDetails = '
        <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
            <i class="fa fa-lg fa-fw fa-eye" data-toggle="modal" data-target="#modalToView-'.$size->id.'"></i>
        </button>
    ';
    $btnEdit = '
        <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
            <i class="fa fa-lg fa-fw fa-pen" data-toggle="modal" data-target="#modalEdit-'.$size->id.'"></i>
        </button>
    ';
    $btnDelete = '
        <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
            <i class="fa fa-lg fa-fw fa-trash"></i>
        </button>
    ';

    $config['data'][] = [
        $size->id,
        $size->type,
        $size->amount,
        '<nobr>'.$btnEdit.$btnDelete.'</nobr>',
    ];
}
@endphp

<style>.modal-footer {display: none;}</style>

{{-- Modal de edição --}}
<x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" >
    @foreach($config['data'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{!! $cell !!}</td>
            @endforeach
        </tr>

        {{-- Editar um tamanho --}}
        <x-adminlte-modal 
            id="modalEdit-{{ $row[0] }}" 
            title="Adicionar funcionário" 
            size="lg"
            theme="teal"
            icon="fa fa-lg fa-fw fa-pen" 
            with-footer="{{ false }}"
            v-centered static-backdrop scrollable
        >
            <form action="/sizes/{{ $row[0] }}" method="POST">
                @csrf
                @method('PUT')
                <div style="display: flex; gap: .5em;">
                    <x-adminlte-input
                        id="type" 
                        name="type" 
                        label="Tamanho"
                        fgroup-class="w-100"
                        value="{{ $row[1] }}"
                    />

                    <x-adminlte-input
                        id="amount" 
                        name="amount" 
                        type="number"
                        label="Quantidade"
                        fgroup-class="w-100"
                        value="{{ $row[2] }}"
                    />
                </div>

                <div style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-top: 2em;
                ">
                    <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Adicionar"/>
                    <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
                </div>
            </form>
        </x-adminlte-modal>
    @endforeach
</x-adminlte-datatable>

{{-- Modal para adicionar mais um tamanho --}}
@php
    $configSel = [
        "liveSearch" => false,
        "showTick" => false,
        "actionsBox" => false,
    ];
@endphp
<x-adminlte-modal 
    id="modalAddSize" 
    title="Adicionar Quantidade" 
    size="lg" theme="teal"
    icon="fa fa-lg fa-fw fa-pen" 
    v-centered static-backdrop scrollable
>
    <form action="/sizes" method="POST">
        @csrf
        <x-adminlte-select-bs 
            id="uniformId" 
            name="uniformId" 
            label="Uniforme" 
            :config="$configSel"
        >
            <option value="{{ $uniform->id }}" selected>{{ $uniform->name }}</option>
        </x-adminlte-select-bs>

        <div style="display: flex; gap: .5em;">
            <x-adminlte-input
                id="type" 
                name="type" 
                label="Tamanho"
                fgroup-class="w-100"
            />

            <x-adminlte-input
                id="amount" 
                name="amount" 
                type="number"
                label="Quantidade"
                fgroup-class="w-100"
            />
        </div>

        <div style="
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 2em;
        ">
            <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Adicionar"/>
            <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
        </div>
    </form>
</x-adminlte-modal>

@stop


