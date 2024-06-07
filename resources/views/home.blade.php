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
        <h1 class="m-0 text-dark">Pedidos</h1>
    </div>
@stop

@section('content')
{{-- Setup data for datatables --}}
@php
$heads = [
    ['label' => 'ID', 'width' => 5],
    ['label' => 'Funcionário', 'width' => 10],
    ['label' => 'Uniforme', 'width' => 10],
    ['label' => 'Tamanho', 'width' => 5],
    ['label' => 'Quantidade', 'width' => 5],
    ['label' => 'Data de saída', 'width' => 10],
    ['label' => 'Data de entrega', 'width' => 10],
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => [],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];

foreach ($withdraws as $withdraw) {
    $btnDelete = '
        <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
            <i class="fa fa-lg fa-fw fa-trash" data-toggle="modal" data-target="#modalDelete-'.$withdraw->id.'"></i>
        </button>
    ';

    $config['data'][] = [
        $withdraw->id,
        $withdraw->employee->name,
        $withdraw->uniform->name,
        $withdraw->size->type,
        $withdraw->withdrawal_amount,
        $withdraw->exit_date,
        $withdraw->delivery_date,
        '<nobr>'.$btnDelete.'</nobr>',
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

        {{-- Deletar pedido --}}
        <x-adminlte-modal 
            id="modalDelete-{{ $row[0] }}" 
            title="Deletar" 
            size="lg"
            theme="teal"
            icon="fa fa-lg fa-fw fa-trash" 
            v-centered static-backdrop scrollable
        >
            <form action="/withdraws/{{ $row[0] }}" method="POST">
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
@stop


