@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('plugins.DateRangePicker', true)

@section('content_header')
    <h1 class="m-0 text-dark">Registro</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registrar Funcionário</h3>    
        </div>
        <!-- /.card-header -->
        <div class="card-body">
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


            <x-adminlte-button style="margin-top: 1em;" onclick="alert('teste')" label="Enviar" theme="primary" />
        </div>
        
    </div>
@stop


