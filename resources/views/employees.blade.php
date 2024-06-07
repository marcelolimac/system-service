@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('plugins.DateRangePicker', true)

@section('content_header')
    <div style="
        display: flex;
        align-items: center;
        justify-content: space-between;
    ">
        <h1 class="m-0 text-dark">Funcionários</h1>
        <x-adminlte-button data-toggle="modal" data-target="#modalToAdd" label="Adicionar funcionário" theme="primary" />
    </div>
@stop

@section('content')
{{-- Setup data for datatables --}}
@php
$heads = [
    ['label' => 'ID', 'width' => 20],
    ['label' => 'Matrícula', 'width' => 10],
    ['label' => 'Nome Funcionário', 'width' => 20],
    ['label' => 'Setor', 'width' => 20],
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => [],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];

foreach ($employees as $employee) {
    $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen" data-toggle="modal" data-target="#modalEdit-'.$employee->id.'"></i>
                </button>';
    $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash" data-toggle="modal" data-target="#modalDelete-'.$employee->id.'"></i>
                </button>';

    $config['data'][] = [
        $employee->id,
        $employee->enrollment,
        $employee->name,
        $employee->sector,
        '<nobr>'.$btnEdit.$btnDelete.'</nobr>',
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

        {{-- Modal de edição --}}
        <x-adminlte-modal 
            id="modalEdit-{{ $row[0] }}" 
            title="Editar funcionário" 
            size="lg"
            theme="teal"
            icon="fa fa-lg fa-fw fa-pen"
            v-centered static-backdrop scrollable
        >
            <form action="/employees/{{ $row[0] }}" method="POST">
                @csrf
                @method('PUT')
                <x-adminlte-input
                    id="name" 
                    name="name" 
                    label="Nome do funcionário"
                    fgroup-class="w-100"
                    value="{{ $row[2] }}"
                />

                <div style="display: flex; gap: .5em;">
                    <x-adminlte-input
                        id="enrollment" 
                        name="enrollment"
                        type="number"
                        label="Matrícula"
                        fgroup-class="w-100"
                        value="{{ $row[1] }}"
                    />

                    <x-adminlte-input
                        id="sector" 
                        name="sector" 
                        label="Setor"
                        fgroup-class="w-100"
                        value="{{ $row[3] }}"
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

        {{-- Deletar pedido --}}
        <x-adminlte-modal 
            id="modalDelete-{{ $row[0] }}" 
            title="Deletar pedido" 
            size="lg"
            theme="teal"
            icon="fa fa-lg fa-fw fa-trash" 
            v-centered static-backdrop scrollable
        >
            <form action="/employees/{{ $row[0] }}" method="POST">
                @csrf
                @method('DELETE')
                <div style="
                    display: flex; 
                    justify-content: center;
                    align-items: center;
                ">
                    <strong>Deseja deletar esse funcionário?</strong>
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

{{-- Modal de Registro --}}
<x-adminlte-modal 
    id="modalToAdd" 
    title="Adicionar funcionário" 
    size="lg"
    theme="teal"
    icon="fa fa-lg fa-fw fa-plus" 
    v-centered static-backdrop scrollable
>
    <form action="/employees" method="POST">
        @csrf
        <x-adminlte-input
            id="name" 
            name="name" 
            label="Nome do funcionário"
            fgroup-class="w-100"
        />

        <div style="display: flex; gap: .5em;">
            <x-adminlte-input
                id="enrollment" 
                name="enrollment"
                type="number"
                label="Matrícula"
                fgroup-class="w-100"
            />

            <x-adminlte-input
                id="sector" 
                name="sector" 
                label="Setor"
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


{{-- Modal de Visualização --}}
<x-adminlte-modal id="modalToView" title="Funcionário" size="lg" theme="teal"
    icon="fa fa-lg fa-fw fa-pen" v-centered static-backdrop scrollable>
   
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Fechar" data-dismiss="modal"/>
    </x-slot>
</x-adminlte-modal>
@stop


