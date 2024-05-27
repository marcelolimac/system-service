@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('plugins.DateRangePicker', true)

@section('content_header')
    <h1 class="m-0 text-dark">Adicionar</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Adicionar Produto</h3>    
        </div>

        <!-- /.card-header -->
        <div class="card-body">
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


            <x-adminlte-button style="margin-top: 1em;" onclick="alert('teste')" label="Enviar" theme="primary" />
        </div>
    </div>
@stop


