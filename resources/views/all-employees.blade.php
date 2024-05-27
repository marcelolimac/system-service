@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('plugins.DateRangePicker', true)

@section('content_header')
    <h1 class="m-0 text-dark">Listagem de Funcionários</h1>
@stop

@section('content')
{{-- Setup data for datatables --}}
@php
$heads = [
    ['label' => 'Matrícula', 'width' => 20],
    ['label' => 'Nome Funcionário', 'width' => 20],
    ['label' => 'Setor', 'width' => 20],
    ['label' => 'Data de entrega', 'width' => 20],
    ['label' => 'Sapato', 'width' => 10],
    ['label' => 'Calça', 'width' => 10],
    ['label' => 'Vestido', 'width' => 10],
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
        [22, 'John Bender', '1', '00/00/0000', '35', 'Nenhum', 'Nenhum', '<nobr>'.$btnEdit.$btnDelete.'</nobr>'],
        [19, 'Sophia Clemens', '1', '00/00/0000', '35', 'Nenhum', 'Nenhum', '<nobr>'.$btnEdit.$btnDelete.'</nobr>'],
        [3, 'Peter Sousa', '1', '00/00/0000', '35', 'Nenhum', 'Nenhum', '<nobr>'.$btnEdit.$btnDelete.'</nobr>'],
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
        <x-adminlte-input name="iLabel" label="Matrícula"
        fgroup-class="col-md-6" disable-feedback/>

        <x-adminlte-input name="iLabel" label="Nome Funcionário"
        fgroup-class="col-md-6" disable-feedback/>
    </div>

    <div style="
        display: flex; 
        align-items: center;
    " >
        <x-adminlte-input name="iLabel" label="Setor"
        fgroup-class="col-md-6" disable-feedback/>

        <div style="width: 100%; padding: .5em;">
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
            <x-adminlte-date-range name="drSizeSm" label="Data de entrega" :config="$config">
                <x-slot name="appendSlot">
                    <div class="input-group-text bg-dark">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>                    
        </div>
    </div>

    <div style="
        display: flex;
        justify-content: space-around;
        gap: 20px;
    ">
        <div style="width: 100%; padding: .4em;">
            <x-adminlte-select2 name="sel2Basic" label="Sapato">
                <option selected>Nenhum</option>
                <option>34</option>
                <option>35</option>
                <option>36</option>
                <option>37</option>
                <option>38</option>
            </x-adminlte-select2>
        </div>
        <div style="width: 100%; padding: .4em;">
            <x-adminlte-select2 name="sel2Basic" label="Calça">
                <option selected>Nenhum</option>
                <option>P</option>
                <option>M</option>
                <option>G</option>
                <option>GG</option>
                <option>XG</option>
            </x-adminlte-select2>
        </div>
        <div style="width: 100%; padding: .4em;">
            <x-adminlte-select2 name="sel2Basic" label="Vestido">
                <option selected>Nenhum</option>
                <option>P</option>
                <option>M</option>
                <option>G</option>
                <option>GG</option>
                <option>XG</option>
            </x-adminlte-select2>
        </div>
    </div>

    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" onclick="alert('Editado')" theme="success" label="Salvar"/>
        <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
    </x-slot>
</x-adminlte-modal>
@stop


