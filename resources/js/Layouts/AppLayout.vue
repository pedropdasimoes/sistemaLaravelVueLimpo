<template>
    <div class="overflow-hidden">
        <jet-banner />
        <div class="flex h-screen bg-gray-100">
            <!--Left Area / Left Menu -->
            <transition name="app-left-menu">
                <left-menu v-if="hiddenLeftMenu === 'false'" :showingLeftMenu="showingLeftMenu"
                    class="bg-gray-800 relative">
                    <div v-for="(item, index) in menuList" :key="index">
                        <div class="flex flex-col px-2 py-1"
                            v-if="$page.props.user.permission.includes(item.permissao)">
                            <left-menu-item :key="index" :item="item" :showingLeftMenu="showingLeftMenu"
                                @showLeftMenuEmit="showingLeftMenu = 'true'">
                            </left-menu-item>
                        </div>
                    </div>
                </left-menu>
            </transition>
            <!--Main Area-->
            <div class="main-area">
                <!--Top Menu-->
                <div :class="[
                    'top-menu',
                    deviceType === 'tablet' || deviceType === 'phone' ? 'w-screen' : 'w-full',
                    $page.props.auth.user.theme, 'topMenu', 'bgTopMenu'
                ]">
                    <!--Left Menu Trigger-->
                    <transition-group :class="[
                        'trigger',
                        (deviceType === 'laptop')
                        | (deviceType === 'desktop') &&
                        'trigger-bordered',
                        $page.props.auth.user.theme,
                        'bgButtonHamburguer'
                    ]" enter-active-class="transition duration-700"
                        enter-class="transform opacity-0 scale-0 rotate-0" enter-to-class="transform opacity-100 "
                        leave-active-class="transition duration-700 scale-100 rotate-180"
                        leave-class="transform opacity-100 " leave-to-class="transform opacity-0" name="trigger"
                        tag="div" @click.native="leftMenuTrigger" style=" 
                        margin-left: -2.75rem;
                        box-shadow: 0 0 5px #000;
                        height: 2.5rem;
                        width: 2.5rem;
                        border-radius: 50%;">
                        <t-hamburger-menu-trigger-icon v-if="showingLeftMenu === 'false'" key="false" :class="[
                            'absolute',
                            deviceType === 'laptop' ||
                                deviceType === 'desktop'
                                ? 'w-4'
                                : 'w-8',
                        ]" />
                        <t-x-icon v-if="showingLeftMenu === 'true'" key="true" :class="[
                            'absolute',
                            deviceType === 'laptop' ||
                                deviceType === 'desktop'
                                ? 'w-4'
                                : 'w-8',
                        ]" />
                    </transition-group>
                    <!--Search Box-->
                    <div class="search-box-container">
                        <div class="search-box">
                            <svg aria-hidden="true" class="absolute h-6 w-6 mt-2.5 ml-2 text-gray-400"
                                fill="currentColor" viewBox="0 0 20 20"
                                :class="[$page.props.auth.user.theme, 'colorWhite']">
                                <path clip-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    fill-rule="evenodd" />
                            </svg>
                            <input placeholder="Pesquisar..." type="search"
                                :class="[$page.props.auth.user.theme, 'colorWhite', 'bgTopMenu']">
                        </div>
                    </div>
                    <!--User Menu-->
                    <div class="user-menu">
                        <!--Notification and Logout Buttons-->
                        <div class="action-section">
                            <!--Notifications-->
                            <t-dropdown align="right" v-if="$page.props.user.permission.includes('3')">
                                <template #trigger>
                                    <button class="trigger-button">
                                        <div v-if="$page.props.auth.user.alerta">
                                            <span
                                                class="absolute top-0 right-0 w-2 h-2 mt-1 mr-2 bg-red-500 rounded-full"></span>
                                            <span
                                                class="absolute top-0 right-0 w-2 h-2 mt-1 mr-2 bg-red-500 rounded-full animate-ping"></span>
                                        </div>
                                        <svg aria-hidden="true" class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </button>
                                </template>
                                <template #default>
                                    <div class="dropdown-list-container" 
                                    :class="[$page.props.auth.user.theme, 'bgDropdowMenu']">
                                        <div class="dropdown-header" :class="[$page.props.auth.user.theme, 'colorWhite']">
                                            Trabalhos Pendentes
                                        </div>
                                        <a class="dropdown-item cursor-pointer" 
                                        v-if="$page.props.auth.user.denunciaLgpd" 
                                        @click="segue('listar-denuncias-lgpd')"
                                        :class="[$page.props.auth.user.theme, 'colorWhite']">
                                            Den??cias LGPD Pendentes
                                        </a>
                                        <a class="dropdown-item cursor-pointer" 
                                        v-if="$page.props.auth.user.denunciaCompliance" 
                                        @click="segue('listar-denuncias-compliance')"
                                        :class="[$page.props.auth.user.theme, 'colorWhite']">
                                            Den??cias Compliance Pendentes
                                        </a>
                                    </div>
                                </template>
                            </t-dropdown>
                        </div>
                        <!--User Menu-->
                        <t-dropdown align="right">
                            <template #trigger>
                                <!--If The user has a avatar-->
                                <button v-if="
                                    $page.props.jetstream
                                        .managesProfilePhotos
                                " class="trigger-button tablet:gap-2" @click="hamburgerMenuTrigger">
                                    <!--User Info-->
                                    <span class="staff-info">
                                        <span class="staff-name"
                                            :class="[$page.props.auth.user.theme, 'colorWhite']">
                                            {{ $page.props.user.name }}
                                        </span>
                                        <span class="staff-title"
                                            :class="[$page.props.auth.user.theme, 'colorWhiteOff']">
                                            {{ $page.props.user.title }}
                                        </span>
                                    </span>
                                    <!--User Photo-->
                                    <t-avatar :alt="$page.props.user.name" :indicator="{
                                        color: 'solid-green',
                                        label: '',
                                        position: 'rb',
                                    }" :radius="8" :size="3" :src="
    $page.props.user.profile_photo_url
" />
                                </button>
                                <!--If The user has not a avatar-->
                                <span v-else class="inline-flex rounded-md">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        type="button">
                                        {{ $page.props.user.name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path clip-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                fill-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </template>
                            <template #default>
                                <div v-show="deviceType !== 'phone'" class="dropdown-list-container" :class="[$page.props.auth.user.theme, 'bgDropdowMenu']">
                                    <!-- Account Management -->
                                    <div class="dropdown-header" :class="[$page.props.auth.user.theme, 'colorWhite']">
                                        Gerenciar Conta
                                    </div>

                                    <!--Profile-->
                                    <inertia-link :href="route('profile.show')">
                                        <div class="dropdown-item"  :class="[$page.props.auth.user.theme, 'colorWhite']">Perfil</div>
                                    </inertia-link>

                                    <!--API Tokens-->
                                    <inertia-link v-if="
                                        $page.props.jetstream.hasApiFeatures
                                    " :href="route('api-tokens.index')">
                                        <div class="dropdown-item"  :class="[$page.props.auth.user.theme, 'colorWhite']">Perfil</div>
                                    </inertia-link>

                                    <!-- Team Management -->
                                    <!-- <div class="border-t border-gray-100"></div>
                                    <template
                                        v-if="
                                            $page.props.jetstream
                                                .hasTeamFeatures
                                        "
                                    >
                                        <div class="dropdown-header">
                                            Gerenciar Equipe
                                        </div>

                                        --><!-- Team Settings --><!--
                                        <inertia-link
                                            :href="
                                                route(
                                                    'teams.show',
                                                    $page.props.user
                                                        .current_team
                                                )
                                            "
                                        >
                                            <div class="dropdown-item">
                                                Configurar Equipe
                                            </div>
                                        </inertia-link>

                                        --><!--Create New Team--><!--
                                        <inertia-link
                                            v-if="
                                                $page.props.jetstream
                                                    .canCreateTeams
                                            "
                                            :href="route('teams.create')"
                                        >
                                            <div class="dropdown-item">
                                                Criar nova Equipe
                                            </div>
                                        </inertia-link>

                                        --><!-- Team Switcher --><!--
                                        <div
                                            class="border-t border-gray-100"
                                        ></div>
                                        <div class="dropdown-header">
                                            Alterar Equipe
                                        </div>

                                        <template
                                            v-for="team in $page.props.user
                                                .all_teams"
                                        >
                                            <form
                                                :key="team.id"
                                                @submit.prevent="
                                                    switchToTeam(team)
                                                "
                                            >
                                                <button class="dropdown-item">
                                                    <span
                                                        class="flex items-center"
                                                    >
                                                        <t-check-circle-icon
                                                            v-if="
                                                                team.id ===
                                                                    $page.props
                                                                        .user
                                                                        .current_team_id
                                                            "
                                                            class="mr-2 h-5 w-5 text-green-400"
                                                        />
                                                        {{ team.name }}
                                                    </span>
                                                </button>
                                            </form>
                                        </template>
                                    </template> -->

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <button class="w-full border-red-500">
                                            <span class="logout-button">
                                                <t-log-out-icon class="w-5 h-5" />
                                                Sair
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </template>
                        </t-dropdown>
                    </div>
                </div>
                <!-- Responsive Navigation Menu -->
                <div v-if="deviceType === 'phone' && showingNavigationDropdown">
                    <div class="pt-2 pb-3 space-y-1">
                        <jet-responsive-nav-link :active="route().current('dashboard')" :href="route('dashboard')">
                            Dashboard
                        </jet-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="
                                $page.props.jetstream.managesProfilePhotos
                            " class="flex-shrink-0 mr-3">
                                <img :alt="$page.props.user.name" :src="$page.props.user.profile_photo_url"
                                    class="h-10 w-10 rounded-full object-cover" />
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <jet-responsive-nav-link :active="route().current('profile.show')"
                                :href="route('profile.show')">
                                Perfil
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link v-if="$page.props.jetstream.hasApiFeatures"
                                :active="route().current('api-tokens.index')" :href="route('api-tokens.index')">
                                API Tokens
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Sair
                                </jet-responsive-nav-link>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200"></div>

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Gerenciar Equipe
                                </div>

                                <!-- Team Settings -->
                                <jet-responsive-nav-link :active="route().current('teams.show')" :href="
                                    route(
                                        'teams.show',
                                        $page.props.user.current_team
                                    )
                                ">
                                    Gerenciar Time
                                </jet-responsive-nav-link>

                                <jet-responsive-nav-link :active="route().current('teams.create')"
                                    :href="route('teams.create')">
                                    Criar novo time
                                </jet-responsive-nav-link>

                                <div class="border-t border-gray-200"></div>

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Alterar time
                                </div>

                                <!-- <template
                                    v-for="team in $page.props.user.all_teams"
                                >
                                    <form
                                        :key="team.id"
                                        @submit.prevent="switchToTeam(team)"
                                    >
                                        <jet-responsive-nav-link as="button">
                                            <div class="flex items-center">
                                                <svg
                                                    v-if="
                                                        team.id ===
                                                        $page.props.user
                                                            .current_team_id
                                                    "
                                                    class="mr-2 h-5 w-5 text-green-400"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    ></path>
                                                </svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </jet-responsive-nav-link>
                                    </form>
                                </template> -->
                            </template>
                        </div>
                    </div>
                </div>
                <!--Content-->
                <div :class="[
                    'content-container',
                    deviceType === 'tablet' || deviceType === 'phone'
                        ? 'w-screen'
                        : 'w-full',
                    $page.props.auth.user.theme, 'colorWhite', 'bgContentGeral', 'boxShadowContentContainer'
                    ]">
                    <!--Content Header-->
                    <div class="container-header">
                        <!--Page Header-->
                        <header class="page-header">
                            <!--Page Title-->
                            <h1 class="page-title" :class="[$page.props.auth.user.theme, 'colorWhite']">
                                <slot name="header"></slot>
                            </h1>
                            <!--Page SubTitle-->
                            <h2 class="page-subtitle" :class="[$page.props.auth.user.theme, 'colorWhite']">
                                <slot name="subHeader"></slot>
                            </h2>
                        </header>
                        <!--Page Action Buttons-->
                        <div v-if="actionButtons === true" class="page-action-buttons">
                            <slot name="action-buttons"></slot>
                        </div>
                    </div>
                    <!--Breadcrumb-->
                    <slot name="breadcrumb"></slot>
                    <!--Content-->
                    <main class="flex flex-col flex-grow">
                        <!--Flash Messages-->
                        <div v-if="$page.props.flash.message" class="alert">
                            <t-alert :color="$page.props.flash.message.type" :timer="5000" class="my-2">
                                <span v-html="$page.props.flash.message.content"></span>
                            </t-alert>
                        </div>
                        <slot></slot>
                    </main>
                    <!-- Modal Portal -->
                    <portal-target multiple name="modal"> </portal-target>
                    <!--Toastr Notifications-->
                    <div v-if="$page.props.flash.toastr">
                        <t-toastr :key="$page.props.flash.toastr.content" :closeable="true"
                            :color="$page.props.flash.toastr.type" :position="$page.props.flash.toastr.position"
                            :timer="3000">
                            <span v-html="$page.props.flash.toastr.content"></span>
                        </t-toastr>
                    </div>
                </div>
                <!-- <footer class="footer"  :style="[$page.props.auth.user.theme === 'solid-dark' ? elementsStyle.dark.colorWhite : '',$page.props.auth.user.theme === 'solid-dark' ? elementsStyle.dark.paletaDark2 : '']"></footer> -->
            </div>
        </div>
    </div>
</template>
<script>
import JetApplicationMark from "@/Jetstream/ApplicationMark";
import JetBanner from "@/Jetstream/Banner";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import LeftMenu from "@/Layouts/LeftMenu";
import LeftMenuItem from "@/Layouts/LeftMenuItem";
import { leftMenuItemsMixin } from "@/Mixins/leftMenuItemsMixin";
import { windowSizeMixin } from "@/Mixins/windowSizeMixin";
import TGithubIcon from "@/Components/Icon/TGitHubIcon";
import TButton from "@/Components/Button/TButton";
import TAlert from "@/Components/Alert/TAlert";
import TToastr from "@/Components/Toastr/TToastr";
import TAvatar from "@/Components/Avatar/TAvatar";
import TDropdown from "@/Components/Dropdown/TDropdown";
import THamburgerMenuTriggerIcon from "@/Components/Icon/THamburgerMenuTriggerIcon";
import TXIcon from "@/Components/Icon/TXIcon";
import TLogOutIcon from "@/Components/Icon/TLogOutIcon";
import TCheckCircleIcon from "@/Components/Icon/TCheckCircleIcon";

export default {
    components: {
        TCheckCircleIcon,
        TLogOutIcon,
        TXIcon,
        THamburgerMenuTriggerIcon,
        TDropdown,
        TAvatar,
        TToastr,
        LeftMenuItem,
        LeftMenu,
        JetApplicationMark,
        JetBanner,
        JetResponsiveNavLink,
        TButton,
        TGithubIcon,
        TAlert,
    },

    mixins: [leftMenuItemsMixin, windowSizeMixin],

    props: {
        actionButtons: {
            require: false,
            default: false,
        },
        pendencias: {
            require: false,
            default: false,
        },
    },
    
    data() {
        return {
            elementsStyle: {},
            showingLeftMenu: localStorage.showingLeftMenu,
            hiddenLeftMenu: localStorage.hiddenLeftMenu,
            showingNavigationDropdown: false,
        };
    },
    methods: {
        segue: function (uri) {
            window.location.href = window.location.origin + "/" + uri;
        },
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id,
                },
                {
                    preserveState: false,
                }
            );
        },

        leftMenuTrigger() {
            if (this.deviceType === "tablet" || this.deviceType === "phone") {
                if (this.hiddenLeftMenu === "true") {
                    this.hiddenLeftMenu = "false";
                    this.showingLeftMenu = "true";
                } else {
                    this.hiddenLeftMenu = "true";
                    this.showingLeftMenu = "false";
                }
            } else {
                if (this.showingLeftMenu === "true") {
                    this.showingLeftMenu = "false";
                } else {
                    this.showingLeftMenu = "true";
                }
                this.hiddenLeftMenu = "false";
            }
            this.leftMenuStorage();
        },
        hamburgerMenuTrigger() {
            if (this.deviceType === "phone") {
                this.showingNavigationDropdown =
                    !this.showingNavigationDropdown;
            }
        },
        leftMenuStorage() {
            localStorage.setItem("showingLeftMenu", this.showingLeftMenu);
            localStorage.setItem("hiddenLeftMenu", this.hiddenLeftMenu);
        },

        logout() {
            this.$inertia.post(route("logout"));
        },
    },

    created() {
        if (this.deviceType === "tablet" || this.deviceType === "phone") {
            if (!localStorage.hiddenLeftMenu) {
                this.hiddenLeftMenu = "true";
                this.showingLeftMenu = "false";
            }
        } else {
            if (!localStorage.showingLeftMenu) {
                this.showingLeftMenu = "true";
                this.hiddenLeftMenu = "false";
            }
        }
        this.leftMenuStorage();
        this.elementsStyle = this.$styleTheme;
    },
    watch: {
        deviceType() {
            if (this.deviceType === "tablet" || this.deviceType === "phone") {
                this.hiddenLeftMenu = "true";
                this.showingLeftMenu = "false";
            } else {
                this.hiddenLeftMenu = "false";
            }
        },
    },
};
</script>
<style>
.app-left-menu-enter-active,
.app-left-menu-leave-active {
    transition: all 0.75s;
}

.app-left-menu-enter,
.app-left-menu-leave-to {
    opacity: 0;
    max-width: 0;
}

.app-left-menu-enter-to,
.app-left-menu-leave {
    opacity: 1;
    max-width: 250px;
}
</style>
