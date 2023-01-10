<template>
    <app-layout>
        <template #header> Bem vindo ao Sistema SGPD </template>
        <template #subHeader>
            Abaixo segue um tutorial dos campos para você poder acessar.
        </template>
        <template #default>
            <t-collapsible :radius="5">
                <t-collapsible-item color="solid-blue" :inside="false">
                    <template #title> Inicio </template>
                    <template #content>
                        <t-collapsible-item color="solid-blue" :inside="true">
                            <template #title> Como Navegar </template>
                            <template #content>
                                Um tutorial referente as abas que o site contém.
                            </template>
                        </t-collapsible-item>
                    </template>
                </t-collapsible-item>

                <t-collapsible-item color="solid-blue" :inside="false" v-if="$page.props.user.permission.includes(5)">
                    <template #title> Usuários </template>
                    <template #content>
                        <t-collapsible-item color="solid-blue" :inside="true">
                            <template #title> Criar Usuário </template>
                            <template #content>
                                Nesta aba você irá cadastrar os usuários podendo
                                escolher como usuários Administrador, Editor, Visualizador Dados, Visualizador
                                Denúncia.<br>
                                ->Administrador: Tem acesso à criar usuários e a todo o sistema.<br>
                                ->Editor: Pode cadastrar formulários, cadastrar mapeamentos e pesquisar dados.<br>
                                ->Visualizador: Pode fazer a pesquisa de dados no sistema.<br>


                            </template>
                        </t-collapsible-item>
                        <t-collapsible-item color="solid-blue" :inside="true">
                            <template #title> Listar Usuários </template>
                            <template #content>
                                Nesta aba será listado todos os usuários cadastrados
                                no sistema. Também tendo a opção de editá-lo e excluir
                                usuários.
                            </template>
                        </t-collapsible-item>
                    </template>
                </t-collapsible-item>

                <t-collapsible-item color="solid-blue" :inside="false" v-if="$page.props.user.permission.includes(6)">
                    <template #title> Configurações </template>
                    <template #content>
                        <t-collapsible-item color="solid-blue" :inside="true">
                            <template #title> Perfil </template>
                            <template #content>
                                Nesta aba você pode alterar sua foto de perfil e
                                senha.
                            </template>
                        </t-collapsible-item>
                    </template>
                </t-collapsible-item>

                <t-collapsible-item color="solid-blue" :inside="false" v-if="$page.props.user.permission.includes(7)">
                    <template #title> Desenvolvedor </template>
                    <template #content>
                        <t-collapsible-item color="solid-blue" :inside="true">
                            <template #title> Abas de desenvolvimento </template>
                            <template #content>
                                Nas abas Components, Layout Items e Form Elements,
                                você encontrará exemplos de componentes para
                                utilizar no projeto.
                            </template>
                        </t-collapsible-item>
                    </template>
                </t-collapsible-item>
            </t-collapsible>
        </template>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import GridSection from "@/Layouts/GridSection";
import TStatisticWidget from "@/Components/Card/TStatisticWidget";
import TCashIcon from "@/Components/Icon/TCashIcon";
import TShoppingBagIcon from "@/Components/Icon/TShoppingBagIcon";
import TContentCard from "@/Components/Card/TContentCard";
import TList from "@/Components/List/TList";
import TListItem from "@/Components/List/TListItem";
import TAvatar from "@/Components/Avatar/TAvatar";
import TTable from "@/Components/Table/TTable";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import TProgress from "@/Components/Progress/TProgress";
import TAlert from "@/Components/Alert/TAlert";
import TInformationCircleIcon from "@/Components/Icon/TInformationCircleIcon";
import TTrashIcon from "@/Components/Icon/TTrashIcon";
import TCheckCircleIcon from "@/Components/Icon/TCheckCircleIcon";
import TCollapsible from "@/Components/Collapsible/TCollapsible";
import TCollapsibleItem from "@/Components/Collapsible/TCollapsibleItem";

export default {
    props: {
        permissoes: Array,
    },
    components: {
        TCheckCircleIcon,
        TTrashIcon,
        TInformationCircleIcon,
        TAlert,
        TProgress,
        TBreadcrumb,
        TTable,
        TAvatar,
        TListItem,
        TList,
        TContentCard,
        TShoppingBagIcon,
        TCashIcon,
        TStatisticWidget,
        GridSection,
        AppLayout,
        Welcome,
        TCollapsible,
        TCollapsibleItem,
    },
    data() {
        return {};
    },
};
</script>
