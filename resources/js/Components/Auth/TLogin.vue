<template>
    <t-full-screen-card :bg-image="bgImage" :color="bgColor" :gradient-direction="bgGradientDirection">
        <div class="shadow-2xl rounded-xl" :class="['relative', deviceType === 'phone' && 'w-11/12']">
            <!--Container-->
            <div :class="['auth-container', radiusStyle]">
                <!--Header-->
                <div class="opacity-80 " :class="['auth-header', calculatedLoginStyle]">
                    <!--Logo-->
                    <div class="auth-logo">
                        <slot name="logo" />
                    </div>
                    <!--Greeting-->
                    <div class="auth-greeting">
                        <div class="text-sm">
                            <!--Status-->
                            <div v-if="status" class="auth-status">
                                {{ status }}
                            </div>
                            <slot v-else name="greeting" />
                        </div>
                    </div>
                </div>

                <!--Form-->
                <div class="auth-form opacity-80 ">
                    <form @submit.prevent="submit">
                        <!--Email-->
                        <div>
                            <t-input-group label="Email" label-for="email">
                                <t-input-text id="email" v-model="form.email" :radius="3" autofocus required
                                    type="email" />
                            </t-input-group>
                        </div>
                        <!--Password-->
                        <div class="mt-4">
                            <t-input-group label="Senha" label-for="password">
                                <t-input-text id="password" v-model="form.password" :radius="3"
                                    autocomplete="current-password" required type="password" />
                            </t-input-group>
                        </div>
                        <div class="auth-remember">
                            <!--Remember Me-->
                            <label class="flex items-center">
                                <input v-model="form.remember" name="remember" type="checkbox" />
                                <span class="auth-remember-text">Lembre-me</span>
                            </label>
                            <!--Forgot Password-->
                            <inertia-link v-if="canResetPassword" :href="route('password.request')"
                                class="auth-forgot-password">
                                Esqueceu sua senha?
                            </inertia-link>
                        </div>
                        <!--Submit Area-->
                        <div class="auth-submit-area">
                            <!--Register Button-->
                            <t-button v-if="registerButton" :class="{ 'opacity-25': form.processing }"
                                :color="registerButtonColor" :link="route('register')" :radius="3" type="button">
                                Registrar
                            </t-button>
                            <div class="flex flex-col w-full justify-center items-center">

                                <!--Submit Button-->

                                <t-button color="light-blue" size="full">Entrar</t-button>
                                <t-svg :spinLoading="spinLoading"> </t-svg>
                            </div>
                        </div>
                    </form>
                    <div class="flex justify-between items-center">
                        <div class="line-separator h-px w-2/5 " style="background-color:#ccc;"></div>
                        <div class="or-label text-center">ou</div>
                        <div class="line-separator h-px w-2/5 " style="background-color:#ccc;"></div>
                    </div>
                    <t-button color="light-blue" size="full" type="button" @click.native="googleAuth()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"
                            width="30px" height="30px">
                            <path fill="#FFC107"
                                d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                            <path fill="#FF3D00"
                                d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                            <path fill="#4CAF50"
                                d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                            <path fill="#1976D2"
                                d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                        </svg>Entrar com Google</t-button>
                    <t-svg :spinLoading="spinLoadingGoogle"> </t-svg>
                </div>
            </div>

            <div class="auth-error">
                <!--Errors-->
                <transition @before-enter="beforeStyle" @after-enter="enterStyle">
                    <t-alert v-if="hasErrors" :radius="deviceType !== 'phone' && 5" color="solid-red">
                        <template #icon>
                            <t-bell-icon class="w-8 h-8" />
                        </template>
                        <ul class="list-inside text-sm">
                            <li v-for="(error, key) in errors" :key="key">
                                {{ error }}
                            </li>
                        </ul>
                    </t-alert>
                </transition>
            </div>
        </div>
    </t-full-screen-card>
</template>

<script>
import { loginStyleMixin } from "@/Mixins/Styles/loginStyleMixin";
import TAlert from "@/Components/Alert/TAlert";
import TBellIcon from "@/Components/Icon/TBellIcon";
import TButton from "@/Components/Button/TButton";
import TFullScreenCard from "@/Components/Card/TFullScreenCard";
import TInputGroup from "@/Components/Form/TInputGroup";
import TInputText from "@/Components/Form/Inputs/TInputText";
import { windowSizeMixin } from "@/Mixins/windowSizeMixin";
import TSvg from "../Svg/TSvg.vue";

export default {
    name: "TLogin",
    components: {
        TAlert,
        TBellIcon,
        TButton,
        TFullScreenCard,
        TInputGroup,
        TInputText,
        TSvg
    },
    mixins: [windowSizeMixin, loginStyleMixin],
    props: {
        canResetPassword: Boolean,
        status: String,
        registerButtonColor: {
            type: String,
            default: "solid-white"
        },
        loginButtonColor: {
            type: String,
            default: "solid-green"
        },
        bgColor: {
            type: String,
            default: "solid-gray"
        },
        bgGradientDirection: {
            type: String
        },
        bgImage: {
            type: String
        },
        registerButton: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            spinLoading: false,
            spinLoadingGoogle: false,
            form: this.$inertia.form({
                email: "",
                password: "",
                remember: false
            })
        };
    },

    methods: {
        googleAuth(){
            this.spinLoadingGoogle = true;
            window.location.href = "authGoogle/redirect";
        },
        submit() {
            this.spinLoading = true;
            this.form
                .transform(data => ({
                    ...data,
                    remember: this.form.remember ? "on" : ""
                }))
                .post(this.route("login"), {
                    onFinish: () =>
                        this.form.reset("password")((this.spinLoading = false))
                });
        },
        beforeStyle(event) {
            event.style.opacity = 0;
        },
        enterStyle(event) {
            event.style.opacity = 1;
            event.style.transition = `all 1s linear`;
        }
    },
    computed: {
        errors() {
            return this.$page.props.errors;
        },

        hasErrors() {
            return Object.keys(this.errors).length > 0;
        }
    }
};
</script>

<style scoped>

</style>
