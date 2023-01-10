<template>
    <div
        class="collapsible-item-container"
        :class="[$page.props.auth.user.theme, 'collapsibleItemContainer']">
        <!--Title-->
        <div
            :class="[
                'collapsible-item',
                calculatedCollapsibleTitleStyle,
                align === 'right' && 'flex-row-reverse',
                $page.props.auth.user.theme, 'collapsibleItem'
            ]"
            @click="showPanel = !showPanel"
        >
            <div
                :class="[
                    'flex items-center space-x-2 w-full whitespace-normal',
                    align === 'left' && 'justify-start',
                    align === 'center' && 'justify-center',
                    align === 'right' && 'flex-row-reverse',
                ]"
            >
                <span>
                    <slot name="title" />
                </span>
            </div>
            <!--DropDown Icon-->
            <t-chevron-down-icon
                :class="[
                    'w-6 h-6 transform duration-300',
                    showPanel ? 'rotate-90' : 'rotate-0',
                ]"
            />
        </div>
        <transition name="fade">
            <!--Content-->
            <div
                v-show="showPanel"
                :class="[calculatedCollapsibleItemContentStyle]"
            >
                <span 
                class="flex flex-col p-4 overflow-hidden" 
                :class="[$page.props.auth.user.theme,
                inside == true ? 'bgContentColapsInside':'bgContentColapsOutside']"
                >
                    <slot name="content"></slot>
                </span>
            </div>
        </transition>
    </div>
</template>

<script>
import { collapsibleStyleMixin } from "@/Mixins/Styles/collapsibleStyleMixin";
import TChevronDownIcon from "@/Components/Icon/TChevronDownIcon";
import { booleanLiteral } from "@babel/types";

export default {
    name: "CollapsibleItem",
    props: {
        inside: {
            type: Boolean,
            default: false,
        },
    },
    components: { TChevronDownIcon },
    mixins: [collapsibleStyleMixin],
    data() {
        return {
            showPanel: false,
            elementsStyle:{}
        };
    },
    created() {
        this.elementsStyle = this.$styleTheme;
    },
};
</script>

<style scoped>
/* .fade-enter-active {
    transition: all ease-out 0.75s;
}

.fade-enter {
    height: 0;
}

.fade-enter-to {
    height: 100%;
} */

/* .fade-leave-active {
    transition: all 0.1s ease;
}

.fade-leave {
    height: 100%;
}

.fade-leave-to {
    height: 0;
} */
</style>
