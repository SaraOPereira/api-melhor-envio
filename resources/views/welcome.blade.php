<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>API Melhor Envio - Lojas e Endereços</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <style>
            span.bar{display: block; width: 1px;height: 100%;background:#414141;margin: auto;}
        </style>
    </head>
    <body>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>API Melhor Envio - Lojas e Endereços</h1>
                        <a class="btn btn-secondary" target="_blank" href="https://www.melhorenvio.com.br/oauth/authorize?client_id=4568&redirect_uri=https://laborastore.com.br/api-melhor-envio&response_type=code&scope=cart-read cart-write companies-read companies-write coupons-read coupons-write notifications-read orders-read products-read products-write purchases-read shipping-calculate shipping-cancel shipping-checkout shipping-companies shipping-generate shipping-preview shipping-print shipping-share shipping-tracking ecommerce-shipping transactions-read users-read users-write webhooks-read webhooks-write">Get Code</a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Nova loja</h2>
                                <form action="{{ route('sendLoja') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row mt-4 mb-4">
                                        <label for="csv" class="col-md-1 col-form-label">CSV</label>
                                        <div class="col-md-11">
                                            <input type="file" name="csv" id="csv" class="form-control" required>
                                        </div>
                                    </div>
                                    <button class="btn btn-info" type="submit">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <span class="bar"></span>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="mb-3">Novo endereço para loja</h2>
                                <form action="{{ route('sendEndereco') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="storeId">Escolha a loja</label>
                                        <input type="text" name="storeId" id="storeId" class="form-control">
                                    </div>
                                    <div class="form-group row mt-3 mb-3">
                                        <label for="csv" class="col-md-1 col-form-label">CSV</label>
                                        <div class="col-md-11">
                                            <input type="file" name="csv" id="csv" class="form-control" required>
                                        </div>
                                    </div>
                                    <button class="btn btn-info" type="submit">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @if (isset($return) && !empty($return))
                    <div class="row mt-5">
                        <div class="col-md-12">
                            @foreach ($return as $r)
                                {!! $r !!}
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </body>
</html>