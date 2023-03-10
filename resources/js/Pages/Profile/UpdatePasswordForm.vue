<template>
    <t-form-content
        :disabled="form.processing"
        @submitted="updatePassword"
        :loading="spinLoadingEnviado"
        :reset-button="false"
    >
        <template #status>
            <t-button
                v-if="form.recentlySuccessful"
                :radius="3"
                color="gray"
                disabled="disabled"
            >
                <t-check-icon class="w-5 h-5" />
                Salvo
            </t-button>
        </template>
        <t-form-section
            description="Certifique-se de que sua conta esteja usando uma senha longa e aleatória para se manter seguro."
            title="Alterar Senha"
            
        >
            <!-- Current Password -->
            <t-input-group
                class="col-span-12"
                :error="form.errors.current_password"
                label="Senha Atual"
                label-for="current_password"
            >
                <t-input-text
                    id="current_password"
                    v-model="form.current_password"
                    :radius="3"
                    ref="current_password"
                    autocomplete="current-password"
                    type="password"
                />
            </t-input-group>

            <!-- New Password -->
            <t-input-group
                class="col-span-12 md:col-span-6"
                :error="form.errors.password"
                label="Nova Senha"
                label-for="password"
            >
                <t-input-text
                    id="password"
                    v-model="form.password"
                    :radius="3"
                    ref="password"
                    autocomplete="new-password"
                    type="password"
                />
            </t-input-group>

            <!-- Confirm New Password -->
            <t-input-group
                class="col-span-12 md:col-span-6"
                :error="form.errors.password_confirmation"
                label="Confirme a Nova Senha"
                label-for="password_confirmation"
            >
                <t-input-text
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :radius="3"
                    ref="password_confirmation"
                    autocomplete="new-password"
                    type="password"
                />
            </t-input-group>
        </t-form-section>
    </t-form-content>
</template>

<script>
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import TFormContent from "@/Components/Form/TFormContent";
import TButton from "@/Components/Button/TButton";
import TCheckIcon from "@/Components/Icon/TCheckIcon";
import TFormSection from "@/Components/Form/TFormSection";
import TInputGroup from "@/Components/Form/TInputGroup";
import TInputText from "@/Components/Form/Inputs/TInputText";
import TSvg from "@/Components/Svg/TSvg.vue";

export default {
    components: {
        TInputText,
        TInputGroup,
        TFormSection,
        TCheckIcon,
        TButton,
        TFormContent,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        TSvg,
    },

    data() {
        return {
            spinLoadingEnviado: false,
            form: this.$inertia.form({
                current_password: "",
                password: "",
                password_confirmation: "",
            }),
        };
    },

    methods: {
        updatePassword() {
            this.spinLoadingEnviado = true;
            this.form.put(route("user-password.update"), {
                errorBag: "updatePassword",
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset();
                    this.spinLoadingEnviado = false;
                },
                onError: () => {
                    this.spinLoadingEnviado = false;
                    if (this.form.errors.password) {
                        this.form.reset("password", "password_confirmation");
                        this.$refs.password.focus();
                    }

                    if (this.form.errors.current_password) {
                        this.form.reset("current_password");
                        this.$refs.current_password.focus();
                    }
                },
            });
        },
    },
};
</script>
