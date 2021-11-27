<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <v-app>
        <app-login></app-login>
    </v-app>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<style>
    main {
        background: #f4f5f5;
    }
</style>
</body>
</html>
<script>
    import AppLogin from "../../js/components/auth/app-login";
    export default {
        components: {AppLogin}
    }
</script>
