<template>
    <app-layout :actionButtons="true">
        <template #header> Usuário </template>
        <template #default>
            <t-list :radius="5" :color="$page.props.auth.user.theme">
                <t-list-item :active="false">
                    <template #title> Nome Usuário: </template>
                    <template #default>
                        {{ usuario.name }}
                    </template>
                </t-list-item>
                <t-list-item :active="false">
                    <template #title> Tipo Usuário: </template>
                    <template #default>
                        {{ usuario.permission }}
                    </template>
                </t-list-item>
                <t-list-item :active="false">
                    <template #title> Email Usuário: </template>
                    <template #default>
                        {{ usuario.email }}
                    </template>
                </t-list-item>
            </t-list>
                <t-button-back-elementar title="Voltar"></t-button-back-elementar>
        </template>
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
import TAlert from "@/Components/Alert/TAlert";
import TList from "@/Components/List/TList";
import TListItem from "@/Components/List/TListItem";
import TAvatar from "@/Components/Avatar/TAvatar";
import TButtonBackElementar from "@/Components/Button/TButtonBackElementar";

export default {
    props: {
        usuario: Object,
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
        TAlert,
        TListItem,
        TList,
        TBadge,
        TAvatar,
        TButtonBackElementar
    },
    data() {
        return {
            elementsStyle: {},
        
        };
    },
    methods: {
        backView() {
            history.back();
        },
    },
    created() {
        this.elementsStyle = this.$styleTheme;
    },
};
</script>

<style scoped>

</style>
    