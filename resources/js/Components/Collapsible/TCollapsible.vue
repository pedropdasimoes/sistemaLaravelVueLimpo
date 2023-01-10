<template>
    <div :class="['collapsible',calculatedCollapsibleStyle,
                    $page.props.auth.user.theme, 'boxShadowColapse']">
        <slot></slot>
    </div>
</template>

<script>
import {collapsibleStyleMixin} from "@/Mixins/Styles/collapsibleStyleMixin";

export default {
    name: "Collapsible",
    mixins: [collapsibleStyleMixin],
    data() {
        return {
            elementsStyle:{}
        };
    },
    created() {
        this.elementsStyle = this.$styleTheme;
    },
}
</script>
