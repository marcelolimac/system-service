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
        <h1 class="m-0 text-dark">Pedidos</h1>
        <x-adminlte-button data-toggle="modal" data-target="#modalToAdd" label="Fazer Pedido" theme="primary" />
    </div>
@stop

@section('content')
{{-- Setup data for datatables --}}
@php
$heads = [
    ['label' => 'ID', 'width' => 10],
    ['label' => 'Funcionário', 'width' => 20],
    ['label' => 'Matrícula', 'width' => 10],
    ['label' => 'Setor', 'width' => 10],
    ['label' => 'Produto', 'width' => 20],
    ['label' => 'Data de entrega', 'width' => 20],
    ['label' => 'Tamanho', 'width' => 10],
    ['label' => 'Quantidade', 'width' => 20],
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

$btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen" data-toggle="modal" data-target="#modalEdit"></i>
            </button>';
$btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
$btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye" data-toggle="modal" data-target="#modalToView"></i>
               </button>';

$config = [
    'data' => [
        [22, 'John Bender', '1', '1', 'Calça', '00/00/0000', 'G', '5', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [19, 'Sophia Clemens', '1', '1', 'Calça', '00/00/0000', 'G', '5', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [3, 'Peter Sousa', '1', '1', 'Calça', '00/00/0000', 'G', '5', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    ],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
];

@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" >
    @foreach($config['data'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{!! $cell !!}</td>
            @endforeach
        </tr>
    @endforeach
</x-adminlte-datatable>

<x-adminlte-modal id="modalMin" title="Minimal"/>

{{-- Modal de Edição --}}
<x-adminlte-modal id="modalEdit" title="Editar Dados" size="lg" theme="teal"
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

{{-- Modal de Registro --}}
<x-adminlte-modal id="modalToAdd" title="Adicionar funcionário" size="lg" theme="teal"
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
        <x-adminlte-button class="mr-auto" onclick="alert('Adicionado')" theme="success" label="Adicionar"/>
        <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
    </x-slot>
</x-adminlte-modal>

{{-- Modal de Visualização --}}
<x-adminlte-modal id="modalToView" title="Funcionário" size="lg" theme="teal"
    icon="fa fa-lg fa-fw fa-pen" v-centered static-backdrop scrollable>
   
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Fechar" data-dismiss="modal"/>
    </x-slot>
</x-adminlte-modal>
@stop


