<template>
<nav>
    <v-app-bar class="elevation-0 " clipped-left app>
        <v-layout flex align-center class="pl-4 pr-10">
        <v-icon class="mr-2 hidden-lg-and-up" @click="drawer = !drawer">menu</v-icon>
        <v-toolbar-title><span class="logo pr-3">M</span>Metrica</v-toolbar-title>
        <v-spacer></v-spacer>

        <v-badge class="message-indicator" right overlap>
            <template v-slot:badge>
                <v-icon ></v-icon>
            </template>
            <v-btn icon class="icon">
                <svg>
                    <use href="/assets/icons/bell.svg#root"></use>
                </svg>
            </v-btn>
        </v-badge>

         <v-toolbar-title class="name mr-6 ml-4">Hello, <span>Sofi</span></v-toolbar-title>
        <v-avatar>
            <img src="/assets/images/lady.png" alt="">
        </v-avatar>
        <v-menu>
            <template v-slot:activator="{ on }">
                <v-icon class="drop-down" v-on="on">arrow_drop_down</v-icon>
            </template>
            <v-list>
                <v-list-item :key="item" v-for="item in items">
                    <v-list-item-title>
                        {{item}}
                    </v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
                </v-layout>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" app clipped>

        <v-list class="mt-12" flat>
            <v-list-item class="pl-8 my-3" v-for="link in links" :key="link.text" router :to="link.route">
            <v-layout flex>

                <v-list-item-icon class="py-0 my-0 mr-7">
                    <svg>
                        <use :href="`${link.icon}#root`"></use>
                    </svg>
                </v-list-item-icon>

                <v-list-item-content class="py-0">
                    <v-list-item-title>
                        {{ link.text }}
                    </v-list-item-title>
                </v-list-item-content>
            </v-layout>
            </v-list-item>
        </v-list>

    </v-navigation-drawer>
</nav>
</template>

<script>
export default {
    data: () => ({
        drawer: true,
        items: ['profile', 'sign out'],
        links: [
            { icon: '/assets/icons/home.svg', text: 'Home', route: '/login'},
            { icon: '/assets/icons/person.svg', text: 'Audience', route: '/audience'},
            { icon: '/assets/icons/settings.svg', text: 'Behaviour', route: '/behaviour'},
            { icon: '/assets/icons/speed.svg', text: 'Speed Overview', route: '/speedoverview'},
            { icon: '/assets/icons/settings.svg', text: 'Settings', route: '/settings'},
        ],
        bell: { icon: '/assets/icons/bell.svg'}
    })
}
</script>

<style>
@font-face {
    font-family: 'Gilroy';
    src: url('/assets/fonts/Gilroy-Bold.eot');
    src: local('Gilroy Bold'), local('Gilroy-Bold'),
        url('/assets/fonts/Gilroy-Bold.eot?#iefix') format('embedded-opentype'),
        url('/assets/fonts/Gilroy-Bold.woff') format('woff'),
        url('/assets/fonts/Gilroy-Bold.ttf') format('truetype');
}

@font-face {
    font-family: 'GilroyLight';
    src: url('/assets/fonts/Gilroy-Light.eot');
    src: local('Gilroy Light'), local('Gilroy-Light'),
        url('/assets/fonts/Gilroy-Light.eot?#iefix') format('embedded-opentype'),
        url('/assets/fonts/Gilroy-Light.woff') format('woff'),
        url('/assets/fonts/Gilroy-Light.ttf') format('truetype');
}

@font-face {
  font-family: 'Inter';
  font-display: swap;
  src: url("/assets/fonts/Inter-Regular.woff2") format("woff2"),
       url("/assets/fonts/Inter-Regular.woff") format("woff");
}

@font-face {
  font-family: 'InterBold';
  font-display: swap;
  src: url("/assets/fonts/Inter-Bold.woff2") format("woff2"),
       url("/assets/fonts/Inter-Bold.woff") format("woff");
}

.v-toolbar__title.name {
    font-family: 'Inter';
    font-size: 12px;
    color: #122737;
}
    .v-navigation-drawer__border {
        display: none;
    }
    .v-navigation-drawer {
        width: 239px;
    }
    a.v-list-item {
        font-size: 14px;
        line-height: 17px;
        min-height: 34px;
        height: 34px;
        font-family: 'Gilroy';
    }

    .v-list-item {
        border-left: 3px solid transparent;
    }

    .v-list-item:hover {
        text-decoration: none;
    }

    .v-list-item__title {
        color: rgba(18, 39, 55);
        fill-opacity: 0.5;
    }

    .v-list-item--active {
        border-left: 3px solid #3C57DE;
    }

    svg { 
        width: 25px;
        height: 25px;
    }

    .icon {
        fill: rgba(0, 0, 0, 0.5);
    }

    .v-list-item__icon
    {
        fill: rgba(18, 39, 55, 0.5);
    }

    .v-list-item--active .v-list-item__icon {
        fill: #3C57DE;
        fill-opacity: 100%;
    }

    svg path {
        fill: inherit;
        fill-opacity: inherit;
    }

    .v-list-item--active .v-list-item__title
    {
        color: #3C57DE;
    }
    
    .v-toolbar__content {
        border-bottom: 1px solid rgba(0, 0, 0, 0.034);
        height: 61px;
    }

    .v-toolbar__title {
        font-family: 'GilroyLight';
        font-weight: light;
        color: rgba(18, 39, 55, 0.5);
        font-size: 14px;
    }

    .v-toolbar__title span.logo {
        font-family: 'InterBold';
        font-size: 32px;
        color: #3C57DE;
    }

    .v-toolbar__title.name span {
        font-family: 'InterBold';
    }

    i.v-icon.drop-down {
        color: #3C57DE;
    }

    .message-indicator .v-badge__badge.primary {
        min-width: 8px;
        height: 8px;
        top: 13px;
        right: 13px;
    }
</style>