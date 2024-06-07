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
    $btnWithdraw = '
        <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Retirar">
            <i class="fa fa-lg fa-fw fa-share" data-toggle="modal" data-target="#modalWithdraw"></i>
        </button>
    ';
    $btnEdit = '
        <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
            <i class="fa fa-lg fa-fw fa-pen" data-toggle="modal" data-target="#modalEdit-'.$size->id.'"></i>
        </button>
    ';
    $btnDelete = '
        <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
            <i class="fa fa-lg fa-fw fa-trash" data-toggle="modal" data-target="#modalDelete-'.$size->id.'"></i>
        </button>
    ';

    $config['data'][] = [
        $size->id,
        $size->type,
        $size->amount,
        '<nobr>'.$btnWithdraw.$btnEdit.$btnDelete.'</nobr>',
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
            title="Editar tamanho" 
            size="lg"
            theme="teal"
            icon="fa fa-lg fa-fw fa-pen" 
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

        {{-- Retirar uniforme (store) --}}
        <x-adminlte-modal 
            id="modalWithdraw" 
            title="Adicionar funcionário" 
            size="lg"
            theme="teal"
            icon="fa fa-lg fa-fw fa-pen" 
            with-footer="{{ false }}"
            v-centered static-backdrop scrollable
        >
            <form action="/withdraws" method="POST">
                @csrf
                <div style="
                    margin-bottom: .5em;
                ">
                    <strong>Funcionário</strong>
                </div>
                <select
                    style="
                        width: 100%;
                        background-color: transparent;
                        padding: .5em;
                        margin-bottom: .5em;
                        border-color: gray;
                        border-radius: 5px;
                    "
                    id="employeeId" 
                    name="employeeId"
                >
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>

                <div style="display: flex; gap: .5em;">
                    <x-adminlte-input
                        id="readonly"
                        name="readonly"
                        label="Tamanho"
                        fgroup-class="w-100"
                        value="{{ $row[1] }}"
                        readonly
                    />  
                    <x-adminlte-input
                        id="withdrawal_amount" 
                        name="withdrawal_amount" 
                        type="number"
                        label="Quantidade (max: {{ $row[2] }})"
                        fgroup-class="w-100"
                        max="{{ $row[2] }}"
                    />
                </div>

                <div style="display: flex; gap: .5em;">
                    @php
                    $config = [
                        "singleDatePicker" => true,
                        "showDropdowns" => true,
                        "startDate" => "js:moment()",
                        "minYear" => 2000,
                        "maxYear" => "js:parseInt(moment().format('YYYY'),11)",
                        "cancelButtonClasses" => "btn-danger",
                        "locale" => ["format" => "DD-MM-YYYY"],
                    ];
                    @endphp

                    <div class="w-100">
                        <x-adminlte-date-range name="exit_date" id="exit_date" label="Data de saída" :config="$config">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-dark">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-date-range>
                    </div>
                    <div class="w-100">
                        <x-adminlte-date-range name="delivery_date" id="delivery_date" label="Data de entrega" :config="$config">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-dark">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-date-range>
                    </div>
                </div>

                <x-adminlte-input
                    style="display: none;"
                    id="uniformId" 
                    name="uniformId"
                    fgroup-class="w-100"
                    value="{{ $uniform->id }}"
                    readonly
                />

                <x-adminlte-input
                    style="display: none;"
                    id="sizeId" 
                    name="sizeId"
                    fgroup-class="w-100"
                    value="{{ $row[0] }}"
                    readonly
                />

                <div style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-top: 2em;
                ">
                    <x-adminlte-button type="submit" class="mr-auto" theme="success" label="Retirar"/>
                    <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
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
            <form action="/sizes/{{ $row[0] }}" method="POST">
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
            readonly
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


