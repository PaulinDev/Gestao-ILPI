<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
          integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <v-app>

        <app-navigation></app-navigation>

        <app-bar></app-bar>

        <v-main>

            <v-container fluid class="mt-5">
                <v-row>
                    <v-col
                        cols="11"
                        class="mx-auto"
                    >
                        @yield('content')
                    </v-col>
                </v-row>
            </v-container>

        </v-main>

    </v-app>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<style>
    main {
        background: #f4f5f5;
    }

    header {
        margin: 1% 2% !important;
        border-radius: 6px !important;
    }
</style>
</body>
</html>
