<template>
    <button
        class="button mt-3 text-white rounded-xl border-blue-500 bg-blue-500 hover:text-blue-700 hover:bg-blue-100 h-10"
        :class="[$page.props.auth.user.theme, 'buttonBack']"
        @click="backView" @mouseenter="hover = true" @mouseleave="hover = false">
        {{title}}
    </button>
</template>

<script>
import { buttonStyleMixin } from "@/Mixins/Styles/buttonStyleMixin";

export default {
    name: "TButtonBackElementar",
    mixins: [buttonStyleMixin],
    props: {
        title: {
            type: String,
            default: "Voltar",
        },
    },
    data() {
        return {
            hover: false,
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
