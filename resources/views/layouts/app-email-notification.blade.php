<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            background: #eceff1;
        }

        .card {
            border: none !important;
        }

        p, span, div, a, h1, h2, h3, h4, h5, h6 {
            font-family: Montserrat;
        }

        a{
            text-decoration: none;
        }

    </style>
    <title>Hello, world!</title>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 mx-auto card p-4">
            <h5 class="card-title">Olá,
                <div style="color: #ff5850;"><strong>{{$user->name}}!</strong></div>
            </h5>
            <br/>
            <p>Você foi cadastrado(a) no <strong>Gestão ILPI</strong> como <strong>{{$user->getPost->name}}</strong>, segue informações da sua conta:</p>
            <p><strong>Acesso:</strong> <a href="{{env('app_url')}}" target="_blank">GestaoIlpi</a></p>
            <p><strong>E-mail:</strong> {{$user->email}}</p>
            <p><strong>Senha:</strong> {{$user->password}}</p>
            <p class="text-muted" style="font-size:10px">A senha foi gerada automaticamente pelo nosso sistema e poderá ser alterada no seu painel</p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>
