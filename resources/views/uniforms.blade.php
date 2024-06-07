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
        <h1 class="m-0 text-dark">Uniformes</h1>

        <div>
            <x-adminlte-button data-toggle="modal" data-target="#modalToAdd" label="Adicionar uniforme" theme="primary" />
            <x-adminlte-button data-toggle="modal" data-target="#modalSizeAmount" label="Adicionar tamanho" theme="primary" />
        </div>
    </div>
@stop

@section('content')
{{-- Setup data for datatables --}}
@php
$heads = [
    ['label' => 'ID', 'width' => 20],
    ['label' => 'Nome do produto', 'width' => 40],
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => [],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];

foreach ($uniforms as $uniform) {
    $btnWithdraw = '
        <a class="btn btn-xs btn-default text-teal mx-1 shadow" title="Retirar" href="/uniforms/'.$uniform->id.'/edit">
            <i class="fa fa-lg fa-fw fa-share"></i>
        </a>
    ';
    $btnEdit = '
        <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
            <i class="fa fa-lg fa-fw fa-pen" data-toggle="modal" data-target="#modalEdit-'.$uniform->id.'"></i>
        </button>
    ';
    $btnDelete = '
        <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
            <i class="fa fa-lg fa-fw fa-trash" data-toggle="modal" data-target="#modalDelete-'.$uniform->id.'"></i>
        </button>
    ';

    $config['data'][] = [
        $uniform->id,
        $uniform->name,
        '<nobr>'.$btnWithdraw.$btnEdit.$btnDelete.'</nobr>',
    ];
}
@endphp

<style>.modal-footer {display: none;}</style>

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" >
    @foreach($config['data'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{!! $cell !!}</td>
            @endforeach
        </tr>

        <x-adminlte-modal 
            id="modalEdit-{{ $row[0] }}" 
            title="Editar uniforme" 
            size="lg" theme="teal"
            icon="fa fa-lg fa-fw fa-pen" 
            v-centered static-backdrop scrollable
        >
            <form action="/uniforms/{{ $row[0] }}" method="POST">
                @csrf
                @method('PUT')
                <x-adminlte-input
                    id="name" 
                    name="name" 
                    label="Nome do uniforme"
                    fgroup-class="w-100"
                    value="{{ $row[1] }}"
                />
                
                <div style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-top: 2em;
                ">
                    <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Adicionar" />
                    <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal" />
                </div>
            </form>
        </x-adminlte-modal>

        {{-- Deletar --}}
        <x-adminlte-modal 
            id="modalDelete-{{ $row[0] }}" 
            title="Deletar" 
            size="lg"
            theme="teal"
            icon="fa fa-lg fa-fw fa-trash" 
            v-centered static-backdrop scrollable
        >
            <form action="/uniforms/{{ $row[0] }}" method="POST">
                @csrf
                @method('DELETE')
                <div style="
                    display: flex; 
                    justify-content: center;
                    align-items: center;
                ">
                    <strong>Deseja deletar esse registro?</strong>
                </div>

                <div style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-top: 2em;
                ">
                    <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Deletar"/>
                    <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
                </div>
            </form>
        </x-adminlte-modal>
    @endforeach
</x-adminlte-datatable>


{{-- Modal de Quantidade e Tamanho --}}
@php
    $configSel = [
        "title" => "Procurar",
        "liveSearch" => true,
        "liveSearchPlaceholder" => "Procurar...",
        "showTick" => true,
        "actionsBox" => true,
    ];
@endphp
<x-adminlte-modal 
    id="modalSizeAmount" 
    title="Adicionar tamanho" 
    size="lg" theme="teal"
    icon="fa fa-lg fa-fw fa-plus" 
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
            @foreach($uniforms as $uniform)
                <option value="{{ $uniform->id }}">{{ $uniform->name }}</option>
            @endforeach
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

{{-- Modal de Uniforme --}}
<x-adminlte-modal 
    id="modalToAdd" 
    title="Adicionar uniforme" 
    size="lg"
    theme="teal"
    icon="fa fa-lg fa-fw fa-plus" 
    with-footer="{{ false }}"
    v-centered static-backdrop scrollable
>
    {{-- Criar um Uniforme --}}
    <form action="/uniforms" method="POST">
        @csrf
        <x-adminlte-input
            id="name" 
            name="name" 
            label="Nome do uniforme"
            fgroup-class="w-100"
        />
        
        <div style="
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 2em;
        ">
            <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Adicionar" />
            <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal" />
        </div>
    </form>
</x-adminlte-modal>
@stop


