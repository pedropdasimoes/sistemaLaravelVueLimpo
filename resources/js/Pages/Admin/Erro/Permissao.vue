<template>
    <app-layout :actionButtons="true">
        <template #header> Página de permissão! </template>
        <template #default> </template>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import TButton from "@/Components/Button/TButton";
import TFormSection from "@/Components/Form/TFormSection";
import TFormContent from "@/Components/Form/TFormContent";
import TInputGroup from "@/Components/Form/TInputGroup";
import TInputText from "@/Components/Form/Inputs/TInputText";
import TInputTextArea from "@/Components/Form/Inputs/TInputTextArea";
import SshPre from "simple-syntax-highlighter";
import "simple-syntax-highlighter/dist/sshpre.css";
import TInputSelect from "@/Components/Form/Inputs/TInputSelect";
import TBadge from "@/Components/Badge/TBadge";
import TInputFile from "@/Components/Form/Inputs/TInputFile";
import TInputCheckBox from "@/Components/Form/Inputs/TInputCheckBox";
import TInputRadioButton from "@/Components/Form/Inputs/TInputRadioButton";
import TBellIcon from "@/Components/Icon/TBellIcon";
import TCheckIcon from "@/Components/Icon/TCheckIcon";
import TXIcon from "@/Components/Icon/TXIcon";

export default {
    props: {
        errors: Object,
        success: String,
        items1: Array,
        idNewUsuario: Number,
    },
    name: "FormStructure",
    components: {
        TBadge,
        TInputSelect,
        AppLayout,
        TButton,
        TFormSection,
        TFormContent,
        TInputGroup,
        TInputText,
        TInputTextArea,
        SshPre,
        TInputFile,
        TInputCheckBox,
        TInputRadioButton,
        TBellIcon,
        TCheckIcon,

    },
    data() {
        return {
            tipoUsuario: [
                {
                    id: 1,
                    name: "Usuário Administrativo",
                },
                {
                    id: 2,
                    name: "Usuário Gestor",
                },
            ],
            permissao: [
                {
                    id: 1,
                    name: "Todas",
                },
                {
                    id: 2,
                    name: "Vagas",
                },
                {
                    id: 3,
                    name: "Aprovação",
                },
                {
                    id: 4,
                    name: "Candidato",
                },
                {
                    id: 5,
                    name: "RH",
                },
                {
                    id: 6,
                    name: "Usuários",
                },
                {
                    id: 7,
                    name: "Desenvolvedor",
                },
            ],
            posicaoItem: null,
            nomeChange: "",
            spinLoading: false,
            loading: false,
            form: this.$inertia.form({
                _method: "POST",
                nome: null,
                cargo: null,
                tipoUsuario: null,
                permissao: [],
                email: null,
                password: null,
                confirmPassword: null,
                hierarquia: null,
            }),
        };
    },
    watch: {
        nomeChange() {
            for (var i = 0; i < this.items1.length; i++) {
                if (this.items1[i].id == this.idNewUsuario) {
                    this.items1[i].title = this.nomeChange;
                    this.posicaoItem = i;
                }
            }
        },
    },
    methods: {
        reset: function () {
            this.form.nome = null;
            this.form.cargo = null;
            this.form.tipoUsuario = null;
            this.form.permissao = null;
            this.form.email = null;
            this.form.password = null;
            this.form.confirmPassword = null;
            this.form.hierarquia = null;
        },
        save() {
            if (this.success != false) {
                this.success = false;
            }
            if (this.error != false) {
                this.error = false;
            }
            if (this.errors.customer != null) {
                this.errors.customer = null;
            }
            this.spinLoading = true;

            this.form.nome = this.nomeChange;
            this.form.hierarquia = this.items1;

            this.form.post(route("create-usuario"), {
                errorBag: "customer",
                preserveScroll: false,
                onSuccess: () => (
                    (this.spinLoading = false), (this.success = true)
                ),
                onError: () => (
                    (this.spinLoading = false), (this.error = true)
                ),
            });
            this.loading = true;
        },
    },
};
</script>

<style scoped></style>
