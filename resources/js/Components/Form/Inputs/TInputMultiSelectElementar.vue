<template>
    <div v-click-outside="outside" class="relative select-none min-w-3">
        <!--Container-->
        <div :class="['z-10 flex-col', radiusStyle, $page.props.auth.user.theme, 'colorInput']"
        >
            <div :class="['select-container z-10', radiusStyle]">
                <!-- <t-input-text
                    v-model="searchText"
                    :placeholder="
                        searchPlaceHolder ? searchPlaceHolder : 'Buscar...'
                    "
                /> -->
                <input
                    class="textElementar focus:ring-0"
                    :class="[$page.props.auth.user.theme, 'colorInput']"
                    type="text"
                    id="id"
                    autocomplete="off"
                    :placeholder="
                        searchPlaceHolder ? searchPlaceHolder : 'Buscar...'
                    "
                    v-model="searchText"
                    :disabled="false"
                    v-on:keydown.enter.prevent=""
                    v-on:focus="toogleSearchBox(true)"
                />
                <!--Icons-->
                <div class="inline-flex" v-if="addValue">
                    <t-button
                        v-if="showButton"
                        :radius="2"
                        color="solid-green"
                        size="sm"
                        type="button"
                        @click.native="buttonClick()"
                    >
                        <svg
                            version="1.1"
                            id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            x="0px"
                            y="0px"
                            width="1rem"
                            height="1rem"
                            viewBox="0 0 459.325 459.325"
                            style="fill: #fff"
                            xml:space="preserve"
                        >
                            <g>
                                <path
                                    d="M459.319,229.668c0,22.201-17.992,40.193-40.205,40.193H269.85v149.271c0,22.207-17.998,40.199-40.196,40.193
                                            c-11.101,0-21.149-4.492-28.416-11.763c-7.276-7.281-11.774-17.324-11.769-28.419l-0.006-149.288H40.181
                                            c-11.094,0-21.134-4.492-28.416-11.774c-7.264-7.264-11.759-17.312-11.759-28.413C0,207.471,17.992,189.475,40.202,189.475h149.267
                                            V40.202C189.469,17.998,207.471,0,229.671,0c22.192,0.006,40.178,17.986,40.19,40.187v149.288h149.282
                                            C441.339,189.487,459.308,207.471,459.319,229.668z"
                                />
                            </g>
                        </svg>
                        Adicionar na Lista
                    </t-button>
                </div>
            </div>
            <div
                :class="['select-container z-10', radiusStyle, $page.props.auth.user.theme, 'colorInput']"
                style="cursor: default;!important"
            >
                <!--Texts-->
                <div class="flex">
                    <!--Placeholder Text-->
                    <span
                        v-if="
                            value === [] || value === null || value.length === 0
                        "
                        class="w-full"
                        v-text="placeHolder ? placeHolder : 'Selecione'"
                    />

                    <!--Selected Option-->
                    <div
                        v-else
                        class="flex flex-wrap justify-start gap-2 py-2 z-10"
                    >
                        <!--ScopeSlot Rich Label-->
                        <span
                            v-for="(item, key, index) in selectedOption"
                            v-if="$scopedSlots.label"
                            :key="selectedOption[optionsValueKey]"
                        >
                            <t-badge :radius="8">
                                <t-x-circle-icon
                                    slot="icon"
                                    class="w-5 h-5 text-gray-400 hover:text-red-500"
                                    @click.native="select(item)"
                                />
                                <slot
                                    :props="item"
                                    name="label"
                                    v-html="item[optionsLabelKey]"
                                />
                            </t-badge>
                        </span>

                        <!--Simple Text Label-->
                        <span
                            v-for="(item, key, index) in selectedOption"
                            v-if="!$scopedSlots.label"
                            :key="selectedOption[optionsValueKey]"
                        >
                            <t-badge :radius="8">
                                <t-x-circle-icon
                                    slot="icon"
                                    class="w-5 h-5 text-gray-400 hover:text-red-500"
                                    @click.native="select(item)"
                                />
                                {{ item[optionsLabelKey] }}
                            </t-badge>
                        </span>
                    </div>
                </div>

                <!--Icons-->
                <div class="inline-flex">
                    <!--Clear Button-->
                    <div
                        v-if="clearButton && selectedOption.length > 0"
                        @click="
                            selectedIDs = [];
                            searchText = '';
                            $emit('input', []);
                        "
                    >
                        <t-x-circle-icon
                            class="w-6 h-6 rounded-full hover:bg-red-500 hover:text-white cursor-pointer"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!--Options Container-->
        <div
            v-if="showOptions"
            class="select-options-container overflow-y-auto max-h-72"
            :class="[$page.props.auth.user.theme, 'colorInput']"
        >
            <!--Options List-->
            <div
                v-for="item in searchedList"
                :key="item[optionsValueKey]"
                :class="[
                    'select-option-item',
                    selectedIDs.includes(item[optionsValueKey]) &&
                        'bg-gray-100 border-b last:border-b-0',
                    alignStyle[align],
                    $page.props.auth.user.theme === 'solid-dark' ? 'textSearch' : ''
                ]"
                @click="select(item)"
                id="textSearch"
            >
                <!--ScopeSlot Rich Label-->
                <slot
                    v-if="$scopedSlots.label"
                    :props="item"
                    name="label"
                    v-html="item[optionsLabelKey]"
                />
                <!--Simple Text Label-->
                <span v-else v-text="item[optionsLabelKey]" />
                <t-check-circle-solid-icon
                    v-if="selectedIDs.includes(item[optionsValueKey])"
                    class="w-5 h-5 text-green-500"
                />
            </div>

            <!--Many Items Notification-->
            <!-- <div
          v-if="searchedList.length>10"
          class="hidden tablet:block text-xs text-center p-2 text-blue-500"
      >
        The
        results({{ searchedList.length }}) are
        too many, please search...
      </div> -->
        </div>
    </div>
</template>

<script>
import TInputText from "@/Components/Form/Inputs/TInputText";
import { radiusSizeMixin } from "@/Mixins/radiusSizeMixin";
import TChevronDownIcon from "@/Components/Icon/TChevronDownIcon";
import TChevronLeftIcon from "@/Components/Icon/TChevronLeftIcon";
import TXCircleIcon from "@/Components/Icon/TXCircleIcon";
import TBadge from "@/Components/Badge/TBadge";
import TCheckCircleSolidIcon from "@/Components/Icon/TCheckCircleSolidIcon";
import TButton from "@/Components/Button/TButton";

export default {
    name: "TInputMultiSelectElementar",
    components: {
        TCheckCircleSolidIcon,
        TBadge,
        TXCircleIcon,
        TChevronLeftIcon,
        TChevronDownIcon,
        TInputText,
        TButton,
    },
    props: [
        "addValue",
        "value",
        "options",
        "optionsLabelKey",
        "optionsValueKey",
        "placeHolder",
        "searchPlaceHolder",
        "clearButton",
        "disabled",
        "search",
        "align",
        "presset",
        "id",
        "placeHolderText",
    ],
    mixins: [radiusSizeMixin],
    directives: {
        "click-outside": {
            bind: function (el, binding, vNode) {
                // Provided expression must evaluate to a function.
                if (typeof binding.value !== "function") {
                    const compName = vNode.context.name;
                    let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`;
                    if (compName) {
                        warn += `Found in component '${compName}'`;
                    }

                    console.warn(warn);
                }
                // Define Handler and cache it on the element
                const bubble = binding.modifiers.bubble;
                const handler = (e) => {
                    if (bubble || (!el.contains(e.target) && el !== e.target)) {
                        binding.value(e);
                    }
                };
                el.__vueClickOutside__ = handler;

                // add Event Listeners
                document.addEventListener("click", handler);
            },

            unbind: function (el) {
                // Remove Event Listeners
                document.removeEventListener("click", el.__vueClickOutside__);
                el.__vueClickOutside__ = [];
            },
        },
    },
    data() {
        return {
            elementsStyle: {},
            selectedIDs: [],
            searchText: "",
            showOptions: false,
            showButton: false,
            idsAdicionados: [],
            alignStyle: {
                left: "text-left",
                center: "text-center",
                right: "text-right",
            },
        };
    },
    created() {
        this.elementsStyle = this.$styleTheme;
    },
    beforeMount() {
        if (this.presset) {
            this.selectedIDs = this.presset;
        }
    },
    computed: {
        selectedOption() {
            if (!this.value) {
                return null;
            }

            let list = [];

            for (let i = 0; i < this.value.length; i++) {
                if (
                    this.options.find(
                        (item) => item[this.optionsValueKey] === this.value[i]
                    )
                ) {
                    list.push(
                        this.options.find(
                            (item) =>
                                item[this.optionsValueKey] === this.value[i]
                        )
                    );
                }
            }

            return list;
        },
        searchedList() {
            if (this.searchText === "") {
                return this.options;
            }

            return this.options.filter((option) =>
                option[this.optionsLabelKey]
                    .toLowerCase()
                    .replace(/[^a-zA-Z ]/g, "")
                    .includes(
                        this.searchText.toLowerCase().replace(/[^a-zA-Z ]/g, "")
                    )
            );
        },
    },
    watch: {
        searchText() {
            if (this.searchText != "") {
                this.showOptions = true;
                this.showButton = true;
            } else {
                this.showOptions = false;
                this.showButton = false;
            }
        },
    },
    methods: {
        toogleSearchBox(value) {
            this.showOptions = value;
        },
        buttonClick() {
            var contentInArray = null;
            if (this.searchText !== "") {
                if (this.searchText.includes(",")) {
                    var arrayTags = this.searchText.split(",");
                    arrayTags = arrayTags.map((item) =>
                        item.trim().replace(".", "")
                    );
                    arrayTags.forEach((element) => {
                        contentInArray = this.options.filter(
                            (option) =>
                                option[this.optionsLabelKey].toLowerCase() ==
                                element.toLowerCase()
                        );
                        if (contentInArray.length > 0) {
                            this.select(contentInArray[0]);
                        } else {
                            // console.log('Não existe');
                            var ids = this.options.map((object) => {
                                return object.id;
                            });
                            ids = Math.max(...ids);

                            if (ids == "-Infinity") {
                                ids = 0;
                            }
                            var object = {
                                id: ids + 1,
                                name: element,
                            };

                            this.$emit("addSelect", object);
                            this.idsAdicionados.push(ids + 1);
                            this.options.push(object);
                            this.select(object);
                        }
                    });
                } else {
                    contentInArray = this.options.filter(
                        (option) =>
                            option[this.optionsLabelKey].toLowerCase() ==
                            this.searchText.toLowerCase()
                    );
                    if (contentInArray.length > 0) {
                        this.select(contentInArray[0]);
                    } else {
                        // console.log('Não existe');
                        var ids = this.options.map((object) => {
                            return object.id;
                        });
                        ids = Math.max(...ids);

                        if (ids == "-Infinity") {
                            ids = 0;
                        }
                        var object = {
                            id: ids + 1,
                            name: this.searchText,
                        };

                        this.$emit("addSelect", object);
                        this.idsAdicionados.push(ids + 1);
                        this.options.push(object);
                        this.select(object);
                    }
                }
            }
        },
        outside() {
            this.showOptions = false;
        },
        changeShowOptions() {
            if (this.disabled) {
                this.showOptions = false;
            } else {
                this.showOptions = !this.showOptions;
            }
        },
        select(item) {
            if (!this.selectedIDs.includes(item[this.optionsValueKey])) {
                /*Select the option*/
                this.selectedOption.push(item);
                this.selectedIDs.push(item[this.optionsValueKey]);
                this.$emit("input", this.selectedIDs);
                this.showOptions = false;
                this.searchText = "";
            } else {
                /*Deselect the option*/
                this.selectedOption.forEach((a, index) => {
                    if (
                        a[this.optionsValueKey] === item[this.optionsValueKey]
                    ) {
                        this.selectedOption.splice(index, 1);
                        this.selectedIDs.splice(index, 1);
                        this.$emit("input", this.selectedIDs);
                        this.showOptions = false;
                        if (
                            this.idsAdicionados.includes(
                                item[this.optionsValueKey]
                            )
                        ) {
                            // this.$emit("removeSelect", object);
                            const objWithIdIndex = this.options.findIndex(
                                (obj) => obj.id === item[this.optionsValueKey]
                            );
                            this.$emit(
                                "removeSelect",
                                this.options[objWithIdIndex].id
                            );
                            this.options.splice(objWithIdIndex, 1);
                        }
                    }
                });
            }
        },
    },
};
</script>

<style scoped>
.textElementar {
    border: none;
    outline: none;
    padding-left: 0;
}
.textElementar:focus {
    outline: none;
}
.textSearch:hover{
    color: #364866 !important;
}
</style>
