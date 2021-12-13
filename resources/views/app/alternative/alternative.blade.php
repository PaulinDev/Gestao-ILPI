@extends('layouts.app-without-nav')

@section('content')
    <v-card
        class="mx-auto mt-5 px-4 py-4"
        max-width="400"
    >

        <v-card-title class="pb-0">
            Você possui permissões especiais
        </v-card-title>

        <v-card-text class="text--primary mt-5">
            <p>
                Olá {{auth()->user()->name}}, você possui permissões de administrador e também está cadastrado como responsável de alguns utentes, deseja continuar para qual página?
            </p>
        </v-card-text>

        <v-card-actions>
            <v-btn
                color="primary"
            >
                Àrea de utentes
            </v-btn>

            <v-btn
                color="secondary"
            >
                Àrea administrativa
            </v-btn>
        </v-card-actions>
    </v-card>
@endsection
