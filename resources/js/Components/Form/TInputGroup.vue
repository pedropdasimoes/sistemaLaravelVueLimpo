<template>
    <div class="flex flex-col">
        <!--Label-->
        <label
            :for="labelFor"
            class="flex flex-row gap-1 items-center font-medium text-base text-gray-700 whitespace-normal"
        >
            <div class="flex">
                <!--Label-->
                <span v-if="label" 
                :class="[$page.props.auth.user.theme, 'inputGroupColorWhite']">
                    {{ label }}
                </span>
                <t-tooltip position="right" class="ml-2" v-if="description">
                    <template #mainContent><img style="max-width: 17px" src="/img/assets/information.png" alt="" /></template>
                    <template #secondContent>{{description}}</template>
                </t-tooltip>
            </div>
            <!--Label Prop-->
            <span
                v-if="!label && $slots.label"
                class="inline-flex items-center"
            >
                <!--Label Slot-->
                <slot name="label" />
            </span>
            <!--Sub Label-->
            <span
                v-if="subLabel"
                :class="['text-xs italic', subLabelColors[subLabelColor]]"
            >
                {{ subLabel }}
            </span>
        </label>
        <!--Input Content-->
        <slot></slot>
        <!--Error-->
        <div v-show="error">
            <p class="text-sm text-red-600 mt-2 whitespace-nowrap">
                {{ error }}
            </p>
        </div>
    </div>
</template>

<script>
import { inputGroupStyleMixin } from "@/Mixins/Styles/inputGroupStyleMixin";
import TTooltip from "@/Components/Tooltip/TTooltip";

export default {
    props: ["label", "subLabel", "subLabelColor", "labelFor", "error", "description"],
    components: {
        TTooltip
    },
    data() {
        return {
            elementsStyle: {}
        }
    },
    created() {
        this.elementsStyle = this.$styleTheme;
    },
    mixins: [inputGroupStyleMixin]
};
</script>
