<template>
    <ul v-if="hasErrors" >
        <li v-for="(error, index) in errors" :key="index" class="text-red-600 text-xs mt-2">{{ error }}</li>
    </ul>
</template>

<script>
export default {
    inheritAttrs: false,
    name: 'error-field',
    props: {
        errors: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        hasErrors() {
            return !!this.errors.length;
        }
    }
}
</script>