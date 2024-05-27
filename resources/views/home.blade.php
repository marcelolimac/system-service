@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('plugins.DateRangePicker', true)

@section('content_header')
    <h1 class="m-0 text-dark">Controle Estoque Fardamento</h1>
@stop

@section('content')
{{-- Setup data for datatables --}}
@php
$heads = [
    ['label' => 'Descrição do produto', 'width' => 40],
    ['label' => 'Tamanho', 'width' => 40],
    ['label' => 'Estoque atual', 'width' => 40],
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

$btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen" data-toggle="modal" data-target="#modalCustom"></i>
            </button>';
$btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
$btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

$config = [
    'data' => [
        [22, 'John Bender', '+02 (123) 123456789', '<nobr>'.$btnEdit.$btnDelete.'</nobr>'],
        [19, 'Sophia Clemens', '+99 (987) 987654321', '<nobr>'.$btnEdit.$btnDelete.'</nobr>'],
        [3, 'Peter Sousa', '+69 (555) 12367345243', '<nobr>'.$btnEdit.$btnDelete.'</nobr>'],
    ],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark">
    @foreach($config['data'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{!! $cell !!}</td>
            @endforeach
        </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="modalMin" title="Minimal"/>
<x-adminlte-modal id="modalCustom" title="Editar Dados" size="lg" theme="teal"
    icon="fa fa-lg fa-fw fa-pen" v-centered static-backdrop scrollable>
   <div style="display: flex;" >
        <x-adminlte-input name="iLabel" label="Descrição do Produto"
        fgroup-class="col-md-6" disable-feedback />

        <div style="width: 100%;">
            <x-adminlte-select2 name="sel2Basic" label="Tamanho">
                <option selected>Nenhum</option>
                <option>P</option>
                <option>M</option>
                <option>G</option>
                <option>GG</option>
                <option>XG</option>
            </x-adminlte-select2>
        </div>

    </div>
    <x-adminlte-input name="iLabel" label="Estoque Atual" type="number"
    fgroup-class="col-md-6" disable-feedback/>

    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" onclick="alert('Editado')" theme="success" label="Salvar"/>
        <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
    </x-slot>
</x-adminlte-modal>
@stop


