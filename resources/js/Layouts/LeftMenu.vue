<template>
    <aside class="flex flex-col justify-between h-full absolute"
        :class="[$page.props.auth.user.theme, 'bgLeftMenu']">

        <!--Logo-->
        <div class="left-menu-logo"
        :class="[$page.props.auth.user.theme, 'bgLeftMenu', 'boxShadowTopLeftMenu']">
            <inertia-link :href="route('dashboard')">
                <div class="flex justify-center items-center space-x-1 space-y-1">
                    <div class="flex justify-between h-10 overflow-hidden mx-4 items-center">
                        <t-logo class="w-10 mx-2 text-white" />
                        <transition name="left-menu">
                            <div v-if="showingLeftMenu === 'true'" class="flex text-2xl text-white h-10 items-end">
                                Sistema SGPD
                            </div>
                        </transition>
                    </div>
                </div>
            </inertia-link>
        </div>
        <!--Menu Items-->
        <nav
            class="h-full pt-6 px-1 overflow-y-auto text-gray-500 scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-gray-300 overflow-y-scroll"
            :class="[$page.props.auth.user.theme, 'scroll']">
            <slot />
        </nav>
        <!--Left Menu Footer-->
        <div class="flex flex-row" 
        :class="[$page.props.auth.user.theme, 'bgLeftMenu', 'boxShadowTopLeftMenu']">
            <div class="flex flex-row justify-center items-center w-full p-3 px-2 border-t border-gray-700 h-15 ">

                <!-- <toggle-button v-model="theme" :value="valueTheme"
                    :color="{ checked: '#5622e6', unchecked: '#2563eb', disabled: '#CCCCCC' }" :switch-color="{
                        checked: '#FFF',
                        unchecked: '#FFF',
                    }" :labels="{ checked: 'Claro', unchecked: 'Escuro' }" :height="20" :width="60" :margin="5"
                    :font-size="10" @change="alteraLayout" /> -->

                    <t-dropup :color="$page.props.auth.user.theme"
                    size="fit">
                        <template #title> Temas </template>
                        <t-dropdown-item @click.native="alteraLayout('solid-light')">
                            <span class="mr-1.5">
                                <font-awesome-icon icon="sun" slot="icon" />
                            </span>
                            Light
                        </t-dropdown-item>
                        <t-dropdown-item @click.native="alteraLayout('solid-dark')">
                            <span class="mr-1.5">
                                <font-awesome-icon icon="moon" slot="icon" />
                            </span>
                            Dark
                        </t-dropdown-item>
                        <t-dropdown-item @click.native="alteraLayout('solid-cosmic')">
                            <span class="mr-1.5">
                                <font-awesome-icon icon="user-astronaut" slot="icon" />
                            </span>
                            Cosmic
                        </t-dropdown-item>
                    </t-dropup>
            </div>
        </div>
    </aside>
</template>

<script>
import TLogo from "@/Components/Icon/TLogo";
import TCogIcon from "@/Components/Icon/TCogIcon";
import axios from "axios";
import TDropdown from "@/Components/Dropdown/TDropdown";
import TDropup from "@/Components/Dropdown/TDropup";
import TDropdownItem from "@/Components/Dropdown/TDropdownItem";

export default {
    name: "LeftMenu",
    components: {
        TCogIcon,
        TLogo,
        axios,
        TDropdown,
        TDropdownItem,
        TDropup
    },
    props: ["showingLeftMenu"],
    data() {
        return {
            elementsStyle: {},
            theme: this.$page.props.auth.user.theme == 'solid-dark'?true:false,
            valueTheme: false
        }
    },
    methods: {
        alteraLayout(theme) {
            var varTheme = '';
            switch(theme){
                case 'solid-light':
                    this.$page.props.auth.user.theme = 'solid-light';
                    varTheme = 'solid-light';
                    break;
                case 'solid-dark':
                    this.$page.props.auth.user.theme = 'solid-dark';
                    varTheme = 'solid-dark';
                    break;
                case 'solid-cosmic':
                    this.$page.props.auth.user.theme = 'solid-cosmic';
                    varTheme = 'solid-cosmic';
                    break;
            }

            const formData = new FormData();
            formData.append("theme", varTheme);
            axios
                .post(route("alter-theme"), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    // console.log("Resposta: ");
                    // console.log(response.data);
                })
                .catch(function (error) {
                    // console.log("Erro: ");
                    // console.log(error);
                });
        }

    },

    created() {
        this.elementsStyle = this.$styleTheme;
    },
};
</script>
<style>
.left-menu-enter-active,
.left-menu-leave-active {
    transition: all 0.75s;
}

.left-menu-enter,
.left-menu-leave-to {
    opacity: 0;
    max-width: 0;
}

.left-menu-enter-to,
.left-menu-leave {
    opacity: 1;
    max-width: 500px;
}
</style>
