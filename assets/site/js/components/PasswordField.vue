<script>
    import Password from 'vue-password-strength-meter';

    export default {
        components: {
            Password
        },
        data() {
            return {
                password: null
            }
        }
    }
</script>

<template>
    <password v-model="password" placeholder="Password" defaultClass="form-control"></password>
</template>

<style type="scss">
    .Password {
        max-width: none !important;
        margin: 0 auto;
    }

    .Password__badge {
        position: absolute !important;
        bottom: 10px !important;
        right: 10px !important;
        height: auto !important;
        width: auto !important;
        display: inline-block;
        padding: 0.25em 0.4em !important;
        font-size: 75% !important;
        font-weight: 700;
        line-height: 1 !important;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem !important;
    }
</style>
