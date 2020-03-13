@extends('template.default.dashboard.layouts.app')

@section('title', 'Pedmap | Cadastros')

@section('content')

    <!-- header -->
    @include('template.default.dashboard.includes.header')

    <!-- section conteudo -->
    <section class="conteudo">

        <!-- container -->
        <div class="container">

            <!-- secBoxTitle -->
            <div class="secBoxTitle2">
                Cadastros
            </div>

            <!-- table actions -->
            <div class="tableActions">
                <!-- addRegistro -->
                <div class="addRegistro"> <a href="#"> <button type="button" class="btn btn-primary">Novo Cadastro</button> </a> </div>
            </div>

            <!-- table -->
            <table class="table table-striped tableStyle1">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>

            <!-- pagination -->
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link disabled" href="#" disabled>..</a></li>
                <li class="page-item"><a class="page-link" href="#">32</a></li>
                <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
            </ul>

        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection