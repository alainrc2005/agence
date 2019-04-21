<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agence</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <link rel="stylesheet" href="{{ assets_file('css/agence.css') }}"/>
    @yield('css')
</head>
<body>
<v-app id="app" v-cloak>
    <v-app-bar color="primary" dark fixed app>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <v-toolbar-title class="hidden-xs-only">AGENCE</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items class="hidden-sm-and-down">
            <v-btn  text><v-icon>mdi-office-building</v-icon>Agence</v-btn>
            <v-btn text><v-icon>mdi-file-check</v-icon>Projetos</v-btn>
            <v-btn text><v-icon>mdi-settings</v-icon>Administrativo</v-btn>
            <v-btn text><v-icon>mdi-account-group</v-icon>Comercial</v-btn>
            <v-btn text><v-icon>mdi-cash-usd</v-icon>Financiero</v-btn>
            <v-btn text><v-icon>mdi-account-box</v-icon>Usuario</v-btn>
        </v-toolbar-items>
        <v-toolbar-items class="hidden-md-and-up">
            <v-container fluid class="pa-0">
                <v-layout row wrap>
                    <v-flex xs2>
                        <v-btn icon>
                            <v-icon>mdi-office-building</v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs2>
                        <v-btn icon>
                            <v-icon>mdi-file-check</v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs2>
                        <v-btn icon>
                            <v-icon>mdi-settings</v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs2>
                        <v-btn icon>
                            <v-icon>mdi-account-group</v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs2>
                        <v-btn icon>
                            <v-icon>mdi-cash-usd</v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs2>
                        <v-btn icon>
                            <v-icon>mdi-account-box</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-toolbar-items>
        <v-tooltip bottom>
            <template v-slot:activator="{ on }">
                <v-btn icon v-on="on"><v-icon>mdi-exit-to-app</v-icon></v-btn>
            </template>
            <span>Sair</span>
        </v-tooltip>
    </v-app-bar>
    <v-content>
        @yield('content')
    </v-content>
</v-app>
<script src="{{ assets_file('js/agence.js') }}"></script>
@yield('js')
</body>
</html>