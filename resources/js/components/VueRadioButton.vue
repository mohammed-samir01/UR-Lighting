<template>
    <div class="v-radio-container row justify-content-center">
        <slot name="pay"></slot>
        <template v-for="(option, idx) in options" :key="idx" >
            <div v-if="option.active" class="col-md-4 mt-2" style="text-align: center">
                <input
                    :id="`input-${idx}`"
                    type="radio"
                    name="iman"
                    :value="option.key"
                    :checked="isActive(option.key)"
                    @input="updateActivePlan"
                />
                <label
                    :for="`input-${idx}`"
                    :class="{
          'v-radio-label': true,
          'v-radio-active': isActive(option.key),
        }" style="width: 130px; height: 65px;
"
                >
                    <slot name="label" :props="option">
                        {{ option.title }}
                    </slot>
                </label>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    name: "VueRadioButton",
    model: {
        prop: "value",
        event: "update:modelValue",
    },
    emits: ["update:modelValue"],
    props: {
        value: {
            default: null,
        },
        options: {
            type: Array,
            required: true,
        },
        name: {
            default: 'vue-radio-button',
            type: [String, Number]
        }
    },
    methods: {
        updateActivePlan(e) {
            this.$emit("update:modelValue",e.target.value);
        },
        isActive(id) {
            return this.$parent.selectedButton == id
        }
    },
};
</script>

<style scoped>

.v-radio-container input {
    display: none;
}
.v-radio-label {
    cursor: pointer;
}


.v-radio-label {
    cursor: pointer
}


.v-radio-label {
    display: inline-flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100px;
    height: 100px;
    margin: 5px;
    border-radius: 4px;
    border: 1px solid #eee;
    transition: all 500ms;
}

.v-radio-active {
    border: 1px solid #007bff; /* Blue border */
    border-radius: 4px; /* Rounded corners */
    position: relative;
}

/* Create a circular icon at the top right */
.v-radio-active::before {
    content: "\2713";
    position: absolute;
    top: 0px;
    right: 0px;
    background-color: #007bff;
    color: #fff;
    border-radius: 50%;
    width: 19px;
    height: 19px;
    text-align: center;
    line-height: 19px;
    font-size: 13px;
    font-weight: bold;
}
</style>
